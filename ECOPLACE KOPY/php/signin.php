<?php
session_start();
require_once './DatabaseService.php'
$credentials['login'] = isset($dataFromClient['login']) ? filter_var(trim($dataFromClient['login']),FILTER_SANITIZE_STRING) : 'test2';
$credentials['password'] = isset($dataFromClient['password']) ? filter_var(trim($dataFromClient['password']),FILTER_SANITIZE_STRING) : 'test pwd';
$check_user = mysqli_query($connect, query:"SELECT * FROM `users` WHERE 'login' = 'login' AND 'password' = 'password'");
if (echo mysqli_num_rows($check_user) > 0) {

    $user = mysqli_fetch_assoc($check_user);
  
$_SESSION['user'] = [

   
    
 "id" => $user['id']
 "login" =>  $user['login']
];
} else {
    header( string: 'location: ../ECOPLACE KOPY/profile/')
}
<pre>
<?php
print_r($check_user)
print_r($user);
?>
</pre>
