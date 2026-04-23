<?php
require 'db.php';

$sql = "SELECT * FROM cvbestand";
$result = $db->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Overzicht</title>
    <link rel="stylesheet" href="../stylesheet/db-styling/overzicht.css">
</head>
<body>
<header>
    <?php include '../PHP/menu.php'; ?>
</header>
<div class="main-container">

<h1>Bestanden</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Beschrijving</th>
        <th>Bestandsnaam</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td class="id"><?=$row['id']?></td>
            <td><?=$row['beschrijving']?></td>
            <td><a class="button"  href="uploads/<?=$row['bestandnaam']?>"><?=$row['bestandnaam']?></a></td>
            <td><a class="button" href="edit.php?id=<?=$row['id']?>">Edit</a></td>
            <td><a class="button" href="delete.php?id=<?=$row['id']?>">Delete</a></td>
        </tr>
    <?php } ?>
</table>
<a href="main.php" class="new">Bestand toevoegen </a>
</div>
</body>
</html>