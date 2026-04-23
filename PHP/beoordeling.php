<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../stylesheet/beoordeling.css">
    <title>Beoordeling</title>
</head>
<body>

<header>
    <h1>Marvin Koster</h1>
    <?php include '../PHP/menu.php'; ?>
</header>

<section id="beoordeling">
    <h2>Beoordeling</h2>

    <form action="../PHP/save.php" method="post">
        <label for="naam">Naam:</label>
        <input type="text" name="naam" required>

        <label for="beoordeling">Beoordeling:</label>
        <textarea id="beoordeling" name="beoordeling"></textarea>

        <label for="cijfer">Cijfer:</label>
        <input type="number" name="cijfer" min="1" max="10" step="0.1" required>

        <input type="submit" value="Submit">
    </form>

</section>

</body>
</html>
