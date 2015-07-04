<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo baseUrl(); ?>/css/style.css">
    <script type="text/javascript" src="<?php echo baseUrl(); ?>/js/jquery.min.js"></script>
    <link href="<?php echo baseUrl(); ?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <title>Название</title>
</head>
<body>
<div id="maincontainer">

    <div id="headline1">
        <a href="<?php echo createUrl('index'); ?>"><div class="title">Адмнка</div></a>
    </div>

    <div id="navtoplist">
        <ul>
            <li id="<?php if($current_file == 'index') echo 'current'; ?>"><a href="<?php echo createUrl("index"); ?>">Главная</a></li>

            <?php if(isGuest()) :?>
                <li id="<?php if($current_file == 'register') echo 'current'; ?>"><a href="<?php echo createUrl("register"); ?>">Регистрация</a></li>
                <li id="<?php if($current_file == 'login') echo 'current'; ?>"><a href="<?php echo createUrl("login"); ?>">Вход</a></li>
            <?php else: ?>
                <li id="<?php if($current_file == 'surf') echo 'current'; ?>"><a href="<?php echo createUrl("surf"); ?>">Просмотр рекламы</a></li>
            <?php endif; ?>
            <li id="<?php if($current_file == 'faq') echo 'current'; ?>"><a href="<?php echo createUrl("faq"); ?>">FAQ</a></li>
            <li id="<?php if($current_file == 'advertise') echo 'current'; ?>"><a href="<?php echo createUrl("advertise"); ?>">Рекламодателю</a></li>
            <li id="<?php if($current_file == 'contact') echo 'current'; ?>"><a href="<?php echo createUrl("contact"); ?>">Контакты</a></li>
            <?php if(!isGuest()) :?>
                <li><a href="<?php echo createUrl("index", [], "admin"); ?>">Админка</a></li>
                <li><a href="<?php echo createUrl("logout"); ?>">Выход</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <div id="navtoplistline">&nbsp;</div>

    <div id="contentwrapper">
        <div id="maincolumn">
            <div class="text">