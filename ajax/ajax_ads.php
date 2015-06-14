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
            if(canLookAds($id, $connect)){
                echo $result['name'] . "  " . $result['url'] . "  " . $result['timer'] . "  " . $result['key_hash'];
            }else{
                echo "error";
            }
        }else if($_POST['type'] == 'check'){
            if(canLookAds($id, $connect)){
                $hash = $_POST['hash'];
                if($hash == $result['key_hash']){
                    $username = $_SESSION['username'];
                    $amount = getConfig('click', $connect);
                    plusBalance($username, $amount, $connect);
                    if(getUserParam($connect)['referer'] !== ''){
                        $to_referer = getConfig('refclick', $connect);
                        plusBalance(getUserParam($connect)['referer'], $to_referer, $connect);
                    }
                    $id_site = $result['id'];
                    $date = time();
                    mysqli_query($connect, "INSERT INTO tb_adver_looked(id_site, username, date)VALUES('{$id_site}', '{$username}', '{$date}')");
                }
            }else{
                echo "error";
            }
        }
    }
}