<?php
header('Content-type: application/json;charset=utf-8');
require_once './DatabaseService.php';
try{
  $database = new \DatabaseService();
}catch(Exception $e){
  header('HTTP/1.0 503 Temporary Unavailable');
  echo json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE); 
  exit();
}
$dataFromClient = (array) json_decode(file_get_contents('php://input'));
$credentials = [];
$credentials['login'] = isset($dataFromClient['login']) ? filter_var(trim($dataFromClient['login']),FILTER_SANITIZE_STRING) : 'test2';
$credentials['password'] = isset($dataFromClient['password']) ? filter_var(trim($dataFromClient['password']),FILTER_SANITIZE_STRING) : 'test pwd';
$credentials['confrimpassword'] = isset($dataFromClient['confrimpassword']) ? filter_var(trim($dataFromClient['confrimpassword']),FILTER_SANITIZE_STRING) : 'test pwd cnf';

$action = isset($_GET['action']) ? $_GET['action'] : false;

switch($action){
  case 'register':
    register($database, $credentials);
  break;
  case 'login':
    login($database, $credentials);
  break;
  case 'getUserPhoto':
    getUserPhoto($database, $dataFromClient);
  break;
  case 'getUserProfile':
    getUserProfile($database, $dataFromClient);
  break;
  default:
    sendErrorResponse('Unknown action ' . $action . ' !');
}

function register($database, $credentials){
  $credentialsValidationResult = validateCredentials($credentials);
  if($credentialsValidationResult['status']){
    $credentials['password'] = md5($credentials['password']);//хеш пароля, чтобы не хранить их в базе
    $dbResponse = $database->insertUser($credentials);
    $headerString = $dbResponse['status'] ? 'HTTP/1.0 200 OK' : 'HTTP/1.0 400 Bad request';
    header($headerString);
    echo json_encode($dbResponse['data'], JSON_UNESCAPED_UNICODE);
  } else{
    sendErrorResponse($credentialsValidationResult['data']);
  }
}
 
function login($database, $credentials){
  $dbResponse = $database->getUserByLogin($credentials['login']);
  $loginResult = false;
  if($dbResponse['status']){
      $loginResult = $dbResponse['data']['password'] === md5($credentials['password']);
  }
  if ($loginResult){
    session_start();
    $_SESSION['user'] = $credentials['login'];
    echo json_encode('Logged in', JSON_UNESCAPED_UNICODE);
  }else{
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode('Неверный логин или пароль', JSON_UNESCAPED_UNICODE);
  }
}

function authorize($providedUserLogin){
  //для авторизации, т.е. проверки, является ли пользовател тем, чьи данные хочет получить. Нужно будет проверять везде, где будет работа с данными пользователя (вывести что-то или запистаь)
  session_start();
  return (isset($_SESSION['user']) && ($_SESSION['user'] === $providedUserLogin));
}

function getUserPhoto($database, $dataFromClient){
  //1. пример с авторизацией
  // if (authorize($dataFromClient['login'])){
  //   $dbResponse = $database->getUserPhoto($dataFromClient['login']);
  
  //2.   или можно нчиего не отправлять с клиента и сразу смотреть какая переменна лежит в сессии
  session_start();
  $dbResponse = $database->getUserPhoto($_SESSION['user']);

  if ($dbResponse){
    echo json_encode($dbResponse['data'], JSON_UNESCAPED_UNICODE);
  }
    
  // }
 
}

function getUserProfile($database, $dataFromClient){
  session_start();
  $dbResponse = $database->getUserPhoto($_SESSION['user']);
  $data = [];
  $data['user'] = $_SESSION['user'];

  echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

function logout($credentials){
  //для выхода из аккаунта
  $_SESSION = [];
  session_destroy();
}

function sendErrorResponse($message){
  header('HTTP/1.0 400 Bad request');
  echo json_encode($message, JSON_UNESCAPED_UNICODE);
}

function validateCredentials($credentials){
  if(mb_strlen($credentials['login']) < 5 || mb_strlen($credentials['login']) > 90 ) {
    ['status' => false, 'data' => 'Недопустимая длина e-mail'];
  } else if(mb_strlen($credentials['password']) < 5 || mb_strlen($credentials['password']) > 32 ) {
    return ['status' => false, 'data' => 'Недопустимая длина пароля( от 5 до 32 символов)'];
  }  else if($credentials['confrimpassword'] != $credentials['password'] ) {
    return ['status' => false, 'data' => 'Пароли не совпадают'];
  }
  return ['status' => true];
}