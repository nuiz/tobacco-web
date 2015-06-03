<?php
/**
 * Created by PhpStorm.
 * User: NUIZ
 * Date: 23/3/2558
 * Time: 10:10
 */
session_start();
if(isset($_GET["kiosk_id"])){
    $cookie_name = "kiosk_id";
    $cookie_value = $_GET["kiosk_id"];
    setcookie($cookie_name, $cookie_value, time() + 2000000000);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1024, initial-scale=1">
    <link rel="stylesheet" href="public/assert/css/main.css"/>
    <link rel="stylesheet" href="bower_components/open-sans-fontface/open-sans.css"/>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="public/assert/js/socket.io.js"></script>
    <script src="public/assert/js/main.js"></script>
    <script src="public/app/config.js"></script>
</head>
<body>
<div id="main">
    <?php
    $fnActivePage = function($page){
        $curPage = isset($_GET['view'])? $_GET['view']: "home";
        if($page==$curPage) echo "active";
    };
    ?>
    <nav id="main-nav" class="nav">
        <div id="main-nav2">
            <?php if(@$_SESSION['user']){?>
            <a class="profile-btn" href="?view=feed"></a>
            <a class="logout-btn" href="?view=logout&tp=tp-none"></a>
            <?php }else {?>
            <a class="login-btn" href="?view=login"></a>
            <?php }?>
            <img src="public/images/font.png" width="100%">
            <div id="nav-menu-list">
                <a class="nav-menu <?php $fnActivePage("news");?>" href="?view=news">
                    <i class="active-icon active-left"></i> ข่าวสาร <i class="active-icon active-right"></i>
                </a>
                <a class="nav-menu <?php $fnActivePage("category");?>" href="?view=category">
                    <i class="active-icon active-left"></i> หมวดหมู่ <i class="active-icon active-right"></i>
                </a>
                <a class="nav-menu <?php $fnActivePage("expert");?>" href="?view=expert">
                    <i class="active-icon active-left"></i> ผู้เชี่ยวชาญ <i class="active-icon active-right"></i>
                </a>
                <a class="nav-menu <?php $fnActivePage("e-book");?>" href="?view=e-book">
                    <i class="active-icon active-left"></i> E-Book <i class="active-icon active-right"></i>
                </a>
                <a class="nav-menu <?php $fnActivePage("km_center");?>" href="?view=km_center">
                    <i class="active-icon active-left"></i> ศูนย์ KM <i class="active-icon active-right"></i>
                </a>
                <a class="nav-menu <?php $fnActivePage("faq");?>" href="?view=faq">
                    <i class="active-icon active-left"></i> FAQ <i class="active-icon active-right"></i>
                </a>
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