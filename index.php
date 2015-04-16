<?php
/**
 * Created by PhpStorm.
 * User: NUIZ
 * Date: 23/3/2558
 * Time: 14:23
 */

$tp = "tp.php";
if(!empty($_GET['tp'])){
    $tp = $_GET['tp'].".php";
}
$tp = "private/views/".$tp;
include($tp);