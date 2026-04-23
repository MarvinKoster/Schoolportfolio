<?php
require_once 'db.php';

$beschrijving = $_POST['beschrijving'];
$bestandnaam = $_FILES['bestandnaam']['name'];

move_uploaded_file($_FILES['bestandnaam']['tmp_name'], 'uploads/' . $bestandnaam);


$sql = "INSERT INTO cvbestand (beschrijving, bestandnaam) VALUES ('$beschrijving', '$bestandnaam')";
$db->query($sql);
if($db->error) {
    die($db->error);
}

header("location: overzicht.php");
exit();