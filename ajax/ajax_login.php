<?php
session_start();

//Если запрос не AJAX, закрываем доступ.
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'){
	exit('Access dained');
}

require("../system/connect.php");
require("../system/function.php");

if(isset($_POST)){
	$username = secureData($_POST['username']);
	$password = secureData($_POST['password']);

	$user = mysqli_query($connect, "SELECT * FROM tb_users WHERE username = '$username'");

	if(mysqli_num_rows($user) > 0){
		$res = mysqli_fetch_assoc($user);
		$password_md5 = $res['password'];

		if(!password_verify($password, $password_md5)){
			echo 'error:password';
		}else{
			$_SESSION["username"] = strtolower($username);
			$_SESSION["password"] = $password;
			$curdate = time();

			mysqli_query($connect, "UPDATE tb_users SET date_last = '$curdate' WHERE username = '$username'");
            // addHistory('Аккаунт', 'Успешный вход с IP: '.$_SERVER['REMOTE_ADDR']);
			echo 'error:success';
		}
	}else{
		echo 'error:username';
	}
}
?>