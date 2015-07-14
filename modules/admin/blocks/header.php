<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!--    <link rel="stylesheet" type="text/css" href="--><?php //echo baseUrl(); ?><!--/css/style.css">-->
    <link rel="stylesheet" type="text/css" href="<?php echo baseUrl(); ?>/css/material.min.css">

    <script type="text/javascript" src="<?php echo baseUrl(); ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo baseUrl(); ?>/js/material.min.js"></script>
    <link href="<?php echo baseUrl(); ?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <title>Название</title>
</head>
<body>
<!--<div id="maincontainer">-->
<!---->
<!--    <div id="headline1">-->
<!--        <a href="--><?php //echo createUrl('index'); ?><!--">-->
<!--            <div class="title">Адмнка</div>-->
<!--        </a>-->
<!--    </div>-->
<!---->
<!--    <div id="navtoplist">-->
<!--        <ul>-->
<!--            <li id="--><?php //if($current_file == 'index') echo 'current'; ?><!--">-->
<!--                <a href="--><?php //echo createUrl("index", null, 'admin'); ?><!--">Главная</a>-->
<!--            </li>-->
<!--            <li id="--><?php //if($current_file == 'contact') echo 'current'; ?><!--">-->
<!--                <a href="--><?php //echo createUrl("user", null, 'admin'); ?><!--">Пользователи</a>-->
<!--            </li>-->
<!--            <li id="--><?php //if($current_file == 'contact') echo 'current'; ?><!--">-->
<!--                <a href="--><?php //echo createUrl("contact"); ?><!--">На сайт</a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
<!---->
<!--    <div id="contentwrapper">-->
<!--            <div class="text">-->

<!-- No header, and the drawer stays open on larger screens (fixed drawer). -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--overlay-drawer-button">
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Меню</span>
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link" href="<?php echo createUrl("user", null, 'admin'); ?>">Пользователи</a>
            <a class="mdl-navigation__link" href="<?php echo createUrl("adver", null, 'admin'); ?>">Реклама</a>
            <a class="mdl-navigation__link" href="">Счета</a>
        </nav>
    </div>
    <main class="mdl-layout__content">
        <div class="page-content">