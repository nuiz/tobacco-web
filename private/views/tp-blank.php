<?php
/**
 * Created by PhpStorm.
 * User: NUIZ
 * Date: 23/3/2558
 * Time: 10:10
 */
session_start();
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
</head>
<body oncontextmenu="return false">
<div id="main">
    <div id="main-body-2">
        <?php $fnCallPage = function(){
            include(__DIR__ ."/".(isset($_GET['view'])? $_GET['view']: "home").".php");
        };
        $fnCallPage();
        ?>
    </div>
</div>
</body>
</html>