<?php
/**
 * Created by PhpStorm.
 * User: NuizHome
 * Date: 7/5/2558
 * Time: 11:51
 */
session_start();

header("Content-type: application/json");
if($_GET['action']=="logout"){
    session_destroy();
    echo json_encode([
        'success'=> true
    ]);
}

if($_GET['action']=="login"){
    $_SESSION['user'] = $_POST["user"];
}