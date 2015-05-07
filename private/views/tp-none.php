<?php
session_start();
$fnCallPage = function(){
    include(__DIR__ ."/".(isset($_GET['view'])? $_GET['view']: "home").".php");
};
$fnCallPage();
?>