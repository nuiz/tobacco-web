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
    <link rel="stylesheet" href="public/assert/font/font.css"/>
    <link rel="stylesheet" href="public/assert/css/main.css"/>
    <link rel="stylesheet" href="bower_components/open-sans-fontface/open-sans.css"/>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="public/assert/js/socket.io.js"></script>
    <script src="public/assert/js/main.js"></script>
    <script src="public/app/config.js"></script>
	<script>
window.config = {
    nfc_auth_ip: "http://58.137.91.19:5000",
    api_url: "http://58.137.91.19/tobacco"
};
</script>
    <?php //echo $_SERVER["HTTP_HOST"];?>
</head>
<body oncontextmenu="return false">
<div id="main">
    <?php
    $fnActivePage = function($page){
        $curPage = isset($_GET['view'])? $_GET['view']: "home";
        if($page==$curPage) echo "active";
    };
    ?>
    <nav id="main-nav" class="nav">
        <?php if(empty($_COOKIE['kiosk_id']) && empty($_GET['kiosk_id'])){?>
        <div style="  position: absolute;
  z-index: 2;
  width: 122px;
  background: white;
  margin-left: 90px;
  padding: 10px;
  font-size: 18px;
  text-align: center;">หากต้องการเข้าใช้งานระบบ KM เดิม <a href="http://192.168.0.159">คลิกที่นี่</a></div>
        <?php }?>
        <div id="main-nav2">
            <?php if(@$_SESSION['user']){?>
            <a class="story-btn" href="?view=feed"></a>
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
            <div>
                <form action="index.php">
                    <input type="hidden" name="view" value="search">
                    <input type="search" placeholder="search" name="keyword" required style="
                    margin: 10px;
                    margin-left: 30px;
                    border-radius: 4px;
                    padding: 10px;
                    width: 175px;">
                </form>
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