<?php
session_start();

// Если запрос не AJAX, закрываем доступ.
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'){
	exit('Access dained');
}

require("../system/connect.php");
require("../system/function.php");

if(isset($_POST)){
	$wallet = strval($_POST['wallet']);
	$wallet = secureData($wallet, $connect);
	$amount = is_string($_POST['amount']) ? floatval($_POST['amount']) : intval($_POST['amount']);
	$username = $_SESSION['username'];

	if(empty($wallet) || strlen(trim($wallet)) == 0){
		exit('error:wallet');
	}

	if(($amount <= 0) || ($amount > getUserParam($connect)['balance'])){
		exit('error:amount');
	}

	if($amount < getConfig('minimum', $connect)){
		exit('error:minimum');
	}

	$time = time();
	mysqli_query($connect, "INSERT INTO tb_payout(username, amount, date_pay, wallet, type, ok)VALUES('$username', '$amount', '$time', 'WebMoney', '$wallet', 0);");
	mysqli_query($connect, "UPDATE tb_users SET balance = balance - '$amount' WHERE username = '$username'");
	// setConfig('payout', getConfig('payout', $connect) + $amount, $connect);
	// addHistory("Баланс", "Успешно заказана выплата на ".$amount." руб.");

	echo 'success:'.$amount;
}