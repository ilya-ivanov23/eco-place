<?php
header('Content-type: application/json;charset=utf-8');
require_once './user.DataServise.php';
try{
  $database = new \DatabaseService();
}catch(Exception $e){
  header('HTTP/1.0 503 Temporary Unavailable');
  echo json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE); 
  exit();
}
$action = isset($_GET['action']) ? $_GET['action'] : false;
switch($action){
  case 'getUserPhoto':
    getUserPhoto($database, $dataFromClient);
  break;
  case 'getUserProfile':
    getUserProfile($database, $dataFromClient);
  break;
}