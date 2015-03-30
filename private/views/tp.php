<?php
/**
 * Created by PhpStorm.
 * User: NUIZ
 * Date: 23/3/2558
 * Time: 10:10
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1024, initial-scale=1">
    <link rel="stylesheet" href="public/assert/css/main.css"/>
    <link rel="stylesheet" href="bower_components/open-sans-fontface/open-sans.css"/>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="public/assert/js/main.js"></script>
</head>
<body>
<div id="main">
    <nav id="main-nav" class="nav">
        <div id="main-nav2">
            <img src="public/images/font.png" width="100%">
            <div id="nav-menu-list">
                <a class="nav-menu" href="?view=news">ข่าวสาร</a>
                <a class="nav-menu" href="?view=category">หมวดหมู่</a>
                <a class="nav-menu" href="?view=expert">ผู้เชี่ยวชาญ</a>
                <a class="nav-menu" href="?view=e-book">E-Book</a>
                <a class="nav-menu" href="?view=km_center">ศูนย์ KM</a>
                <a class="nav-menu" href="?view=faq">FAQ</a>
            </div>
        </div>
    </nav>
    <div id="main-body">
        <?php $fnCallPage = function(){
            include(__DIR__ ."/".(isset($_GET['view'])? $_GET['view']: "home").".php");
        };
        $fnCallPage();
        ?>
    </div>
</div>
</body>
</html>