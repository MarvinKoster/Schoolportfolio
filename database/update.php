<?php
require 'db.php';

$id = $_POST['id'];
$beschrijving = $_POST['beschrijving'];
$bestandnaam = $_POST['bestandsnaam'];

$sql = "UPDATE cvbestand SET beschrijving = '$beschrijving', bestandnaam = '$bestandnaam' WHERE id = '$id'";
$db->query($sql);

header("location: overzicht.php");
exit();