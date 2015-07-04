<?php
//Включаем вывод ошибок
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//Запускаем сессию
session_start();

//Подключаем файл конфигурации базы данных
require("system/connect.php");
//Подключаем файл с функциями проекта
require("system/function.php");

//Объявляем константы
define('BASE_PATH', dirname(__FILE__));

//Сохраняем реферала
if(isset($_GET['ref'])){
    setcookie('ref', intval($_GET['ref']));
}

//Смотрим какой файл будем запускать
if(isset($_GET['m'])){
    $moduleName = secureData($_GET['m'], $connect);
    $path = BASE_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR;
    if(is_dir(BASE_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$moduleName)){
        if(file_exists($path.'header.php') && file_exists($path.'footer.php')){
            require($path.'header.php');
            require($path.'index.php');
            require($path.'footer.php');
        }
    }
}else{
    $current_file = isset($_GET['r']) && checkExistFile(secureData($_GET['r'], $connect)) ? $_GET['r'] : 'index';

    //Вызываем шаблон
    if(isset($_GET['no'])){
        renderPartial(BASE_PATH . '/includes/' . $current_file, ['connect' => $connect]);
    }else{
        render(BASE_PATH . '/includes/' . $current_file, ['connect' => $connect, 'current_file' => $current_file]);
    }
}