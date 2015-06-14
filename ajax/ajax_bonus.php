<?php
session_start();

//Если запрос не AJAX, закрываем доступ.
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'){
	exit('Access dained');
}

require("../system/connect.php");
require("../system/function.php");

$bonus = getConfig('bonus', $connect);
$date = time();
$username = $_SESSION['username'];

if($bonus != 0 && hasBonus($connect)):
	mysqli_query($connect, "UPDATE tb_users SET balance = balance + {$bonus}, last_bonus = '{$date}' WHERE username = '{$username}'");
	echo "Получен бонус: ".$bonus." р.";
endif;
?>