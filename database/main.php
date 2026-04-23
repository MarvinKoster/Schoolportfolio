<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bestand uploaden</title>
    <link rel="stylesheet" href="../stylesheet/db-styling/style.css">
</head>
<body>

<header>
    <?php include '../PHP/menu.php'; ?>
</header>

<div class="main-container">
<h1>CV UPLOADEN</h1>
<p>Upload hier je cv</p>
<form action="process.php" method="post" enctype="multipart/form-data">
    <input type="text" name="beschrijving" placeholder="Omschrijving" required>
    <input type="file" name="bestandnaam" required>
    <input type="submit" value="Uploaden" class="button">
</form>
<a href="overzicht.php" class="overzicht">Terug naar overzicht?</a>
</div>
</body>
</html>