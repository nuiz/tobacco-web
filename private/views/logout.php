<?php
/**
 * Created by PhpStorm.
 * User: NuizHome
 * Date: 7/5/2558
 * Time: 12:44
 */

session_destroy();

header("location: ?view=news&ts=".time());