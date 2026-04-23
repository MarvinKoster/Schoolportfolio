<?php
require 'db.php';

$id = $_GET['id'];
$result = $db->query("SELECT * FROM cvbestand WHERE id = $id");
$bestand = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit</title>
</head>
<body>
<form method="post" action="update.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="text" name="beschrijving">
    <input type="file" name="bestandsnaam">
    <input type="submit" value="Update">
</form>
</body>
</html>