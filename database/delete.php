<?php
require 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM cvbestand WHERE id = '$id'";
$db->query($sql);

header("location: overzicht.php");
exit();