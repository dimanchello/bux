<?php
session_start();

//Если запрос не AJAX, закрываем доступ.
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'){
	exit('Access dained');
}

require("../system/connect.php");
require("../system/function.php");

$amount = (float)$_POST['amount'];
$type = $_POST['payment'];
$price_usd = round($amount / 34, 2);
$username = $_SESSION['username'];
$time = time();

switch ($type) {
	case 'interkassa':
		// if($json_config['interkassa'] == 1){
			mysql_query("INSERT INTO tb_payin(username, amount, type, date)VALUES('$username', '$price_usd', 'InterKassa', '$time')") or die(mysql_error());
			$id = mysql_insert_id();

			echo '
			<form name="payment" action="https://www.interkassa.com/lib/payment.php" method="post" 
			enctype="application/x-www-form-urlencoded" accept-charset="cp1251">
			<input type="hidden" name="ik_shop_id" value="D861B824-4B8E-7EEB-80D3-F73270143406">
			<input type="hidden" name="ik_payment_amount" value="'.$price_usd.'">
			<input type="hidden" name="ik_payment_id" value="'.$id.'">
			<input type="hidden" name="ik_payment_desc" value="account">

			<input type="submit" name="process" value="Продолжить оплату">
			';
			// }else{
			// 	echo 'Извините, но ИнтерКасса отключена';
			// }
	break;

	case 'webmoney':
		// if($json_config['webmoney'] == 1){
			mysqli_query($connect, "INSERT INTO tb_payin(username, amount, type, date)VALUES('$username', '$amount', 'WebMoney', '$time')");
			$id = mysql_insert_id();

			echo 
				'
				<form method = "post" action="https://merchant.webmoney.ru/lmi/payment.asp" accept-charset = "windows-1251">
				<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.$amount.'">
				<input type="hidden" name="LMI_PAYMENT_DESC" value="Оплата заказа '.$id.'">
				<input type="hidden" name="LMI_PAYEE_PURSE" value="R00000000000">
				<input type="hidden" name="service" value="account">
				<input type="hidden" name="id" value="'.$id.'">

				<input type="submit" value = "Продолжить оплату">
				</form>
				';
		// }else{
		// 	echo 'Извините, но WebMoney отключена';
		// }
	break;

	case 'perfect':
		// if($json_config['perfect'] == 1){
			mysql_query("INSERT INTO tb_payin(username, amount, type, date)VALUES('$username', '$price_usd', 'PerfectMoney', '$time')") or die(mysql_error());
			$id = mysql_insert_id();

			echo '
			<form action="https://perfectmoney.is/api/step1.asp" method="POST">
			<input type="hidden" name="PAYEE_ACCOUNT" value="U3360199">
			<input type="hidden" name="PAYEE_NAME" value="Администратор">
			<input type="hidden" name="PAYMENT_ID" value="account '.$id.'">
			<input type="hidden" name="PAYMENT_AMOUNT" value="'.$price_usd.'">
			<input type="hidden" name="PAYMENT_UNITS" value="USD">
			<input type="hidden" name="STATUS_URL" value="http://'.$_SERVER['HTTP_HOST'].'/payment/perfect/status.php">
			<input type="hidden" name="PAYMENT_URL" value="http://'.$_SERVER['HTTP_HOST'].'/payment/perfect/success.php">
			<input type="hidden" name="NOPAYMENT_URL" value="http://'.$_SERVER['HTTP_HOST'].'/payment/perfect/fail.php">
			<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
			<input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
			<input type="submit" name="PAYMENT_METHOD" value="Продолжить оплату">
			</form>
			';
		// }else{
		// 	echo 'Извините, но Perfect Money отключен';
		// }
	break;
}
?>