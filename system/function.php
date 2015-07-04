<?php
//Функция для построения правильных URL
function createUrl($to, $params = array(), $module = NULL){
    $url = $_SERVER['SERVER_NAME'];
    $url = 'http://' . $url . '/' . basename(dirname(__DIR__)) . '/index.php?r=' . $to;

    foreach($params as $key => $value){
        $url .= "&" . $key . "=" . $value;
    }

    if(isset($module)){
        $url .= "&m=" . $module;
    }

    return $url;
}

function baseUrl(){
    $url = $_SERVER['SERVER_NAME'];
    $url = '/' . basename(dirname(__DIR__));

    return $url;
}

//Делаем проверку $data на подозрительные сущности
function secureData($data, $connect = NULL){
    $data = trim($data);
    $data = strip_tags($data);
    if(isset($connect)) $data = mysqli_real_escape_string($connect, $data);
    $data = htmlspecialchars($data);

    return $data;
}

function checkExistFile($file){
    $list = scandir(BASE_PATH . "/includes");
    $file .= ".php";

    array_shift($list);
    array_shift($list);

    if(in_array($file, $list)){
        return true;
    }else{
        return false;
    }
}

function getUserParam($connect, $username = NULL){
    if($username == NULL){
        $username = $_SESSION['username'];
    }

    $query = mysqli_query($connect, "SELECT * FROM tb_users WHERE username = '$username'");

    if(mysqli_num_rows($query) > 0){
        $result = mysqli_fetch_assoc($query);

        return $result;
    }else{
        return null;
    }
}

function isGuest(){
    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
        return false;
    }else{
        return true;
    }
}

function isAdmin($connect){
    $status = getUserParam($connect)['status'];

    if($status == 2)
        return true;
    else
        return false;
}

function validateEmail($data){
    if(!filter_var($data, FILTER_VALIDATE_EMAIL)) return false;else
        return true;
}

function validateInt($data){
    if(!filter_var($data, FILTER_VALIDATE_INT)) return false;else
        return true;
}

function validateUrl($data){
    if(!filter_var($data, FILTER_VALIDATE_URL)) return false;else
        return true;
}

function validateRange($data, $min, $max){
    return ($data >= $min && $data <= $max);
}

function validateEmpty($data){
    if(empty(trim($data))){
        return true;
    }else{
        return false;
    }
}

function validateEnglish($data){
    if(preg_match('/^[a-z0-9]+$/i', $data)){
        return true;
    }else{
        return false;
    }
}

function validateData($data, $validator){
    $ckecker = false;

    switch($validator){
        case 'email':
            $checker = validateEmail($data);
            break;

        case 'int':
            $checker = validateInt($data);
            break;

        case 'range':

            break;

        case 'url':
            $checker = validateUrl($data);
            break;

        case 'username':
            $checker = validateEnglish($data);
            break;

        case 'empty':
            $ckecker = validateEmpty($data);
            break;


        default:
            echo 'Валидатор не найден';
            break;
    }

    return $checker;
}

function sendEmail($to){
    $from = "support@mlm-reklama.com";
    $from_name = "Поддержка mlm-reklama";
    $type = "text/html";
    $encoding = "utf-8";
    $notify = false;
    $message = "Привет";
    $subject = "Привет";

    $message_text = '
                    <html>
                        <head>
                        </head>
                        <body>
                            <p>Здравствуйте!</p>
                            <br>
                            <p>' . $message . '</p>
                            <br>
                            <p>--</p>
                            <p>С уважением команда проекта MLM-REKLAMA</p>
                        </body>
                    </html>';

    $from = "=?utf-8?B?" . base64_encode($from_name) . "?=" . " <" . $from . ">";
    $headers = "From: " . $from . "\r\nReply-To: " . $from . "\r\nContent-type: " . $type . "; charset=" . $encoding . "\r\n";

    $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
    mail($to, $subject, $message_text, $headers);
}

function getConfig($param, $connect){
    $query = mysqli_query($connect, "SELECT * FROM tb_config WHERE param = '$param'");
    if(mysqli_num_rows($query) > 0){
        $result = mysqli_fetch_assoc($query);
        return $result['value'];
    }
}

function setConfig($param, $value, $connect){
    $query = mysqli_query($connect, "UPDATE tb_config SET value = '$value' WHERE param = '$param'");
}

function minusBalance($username, $amount, $connect){
    if(!isGuest()){
        mysqli_query($connect, "UPDATE tb_users SET balance = balance - '{$amount}' WHERE username = '{$username}'");
    }
}

function plusBalance($username, $amount, $connect){
    if(!isGuest()){
        mysqli_query($connect, "UPDATE tb_users SET balance = balance + '{$amount}' WHERE username='{$username}'");
    }
}

function hasBonus($connect){
    if(!isGuest()){
        $username = $_SESSION['username'];
        $query = mysqli_query($connect, "SELECT last_bonus FROM tb_users WHERE username='{$username}'");
        $result = mysqli_fetch_array($query);

        if($result['last_bonus'] + 1 * 24 * 3600 < time() && $result['last_bonus'] != 0) return true;else
            return false;
    }
}

function canLookAds($id, $connect){
    if(!isGuest()){
        $username = $_SESSION['username'];
        $query = mysqli_query($connect, "SELECT * FROM tb_adver_looked WHERE id_site={$id} AND username='{$username}'");
        if(mysqli_num_rows($query) > 0){
            $adver_query = mysqli_query($connect, "SELECT * FROM tb_adver WHERE id={$id}");
            $res = mysqli_fetch_assoc($adver_query);
            if($res['visit_all'] <= $res['visited']){
                mysqli_query($connect, "DELETE FROM tb_adver WHERE id={$id}");
            }
            return false;
        }else{
            return true;
        }
    }
}

function render($view, $param = NULL){
    if(is_array($param)) extract($param);else
        return;

    require_once("header.php");
    require_once($view . ".php");
    require_once("footer.php");
}

function renderPartial($view, $param = NULL){
    if(is_array($param)) extract($param);

    require_once($view . ".php");
}