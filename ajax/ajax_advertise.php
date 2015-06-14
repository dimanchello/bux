<?php
session_start();

//Если запрос не AJAX, закрываем доступ.
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'){
	exit('Access dained');
}

require("../system/connect.php");
require("../system/function.php");

if(isset($_POST)){
	$name = secureData($_POST['name'], $connect);
	$url = secureData($_POST['url'], $connect);
	$visit = intval($_POST['visit']);
	$timer = intval($_POST['timer']);
	$payment = secureData($_POST['payment'], $connect);
	$date = time();

	if(validateData($name, 'empty') || validateData($url, 'empty') || validateData($visit, 'empty')){
		exit("Не все поля заполнены");
	}

	if(!validateData($url, 'url')){
		exit("Поле URL заполнено некорректно");
	}

	if(!validateData($visit, 'int') || !validateData($timer, 'int')){
		exit("Поле визиты должнj быть целочисленными");
	}

	if($payment == 'input' && !isGuest()){
		$price = $visit * getConfig('click_for_advertisers', $connect);
        $key = $name."-".$url."-".$visit."-".$timer."-".$payment."-".$date;
        $key = md5($key);

		if($price > getUserParam($connect)['balance']){
			exit("На вашем балансе не хватает средств");
		}else{
			mysqli_query($connect, "INSERT INTO tb_adver(name, url, visit_all, timer, key_hash, date_add, status)VALUES('{$name}', '{$url}', '{$visit}', '{$timer}', '{$key}', '{$date}', '1')");
			minusBalance(getUserParam($connect)['id'], $price, $connect);
		}
	}else if($payment == 'webmoney'){
		mysqli_query($connect, "INSERT INTO tb_adver(name, url, visit_all, timer, key_hash, date_add, status)VALUES('{$name}', '{$url}', '{$visit}', '{$timer}', '{$key}', '{$date}', '0')");
	}

	echo "Ваша ссылка успешно добавлена";
}