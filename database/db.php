<?php
$localhost = "localhost";
$databasename = "eindopdracht";
$username = "root";
$password = "";

$db = new mysqli($localhost, $username, $password, $databasename);

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}