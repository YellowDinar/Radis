<?php
ini_set('max_execution_time', 1000);
ini_set('display_errors',1);
error_reporting(E_ALL);

include('direct.php');
include('db.php');

$db = new Database();
$link = $db->auth();

$direct = new Direct();

$keys = $db->getKeys($link);
$area = $db->getArea($link);

for($key = 0, $key_len = count($keys); $key < $key_len; $key++) {
    for($ar = 0, $area_len = count($area); $ar < $area_len; $ar++) {
        
    }
}
?>