<?php
session_start();

//Если запрос не AJAX, закрываем доступ.
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'){
    exit('Access dained');
}

require("../system/connect.php");
require("../system/function.php");

if(isset($_POST)){
    $id = intval($_POST['id']);
    $query = mysqli_query($connect, "SELECT * FROM tb_adver WHERE id={$id} AND status=1");
    if(mysqli_num_rows($query) > 0){
        $result = mysqli_fetch_assoc($query);
        if($_POST['type'] == 'get'){
            echo $result['name']."  ".$result['url']."  ".$result['timer']."  ".$result['key_hash'];
        }else if($_POST['type'] == 'check'){
            $hash = $_POST['hash'];
            if($hash == $result['key_hash']){
                $username = $_SESSION['username'];
                $amount = getConfig('click', $connect);
                plusBalance($username, $amount, $connect);
                if(getUserParam($connect)['referer'] !== ''){
                    $to_referer = getConfig('refclick', $connect);
                    plusBalance(getUserParam($connect)['referer'], $to_referer, $connect);
                }

                echo "good";
            }
        }else{
            echo "error";
        }
    }
}