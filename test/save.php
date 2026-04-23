<?php

// Bestand waar we in schrijven
define("FILE", "view.html");

// Ophalen van formulierdata
$title = $_POST['naam'] ?? '';
$description = $_POST['bijschrijving'] ?? '';
$rating = $_POST['cijfer'] ?? '';

// Regeleindes in de beschrijving vervangen door <br>
$description = str_replace("\n", "<br>", $description);

// Bestand openen in append-mode
$file = fopen(FILE, "a");

// HTML wegschrijven
fwrite($file, "<div class=\"post\">\n");
fwrite($file, "  <p class=\"post-title\"><strong>$title</strong></p>\n");
fwrite($file, "  <p class=\"post-description\">$description</p>\n");
fwrite($file, "  <p class=\"post-rating\">Resultaat: $rating</p>\n");
fwrite($file, "</div>\n\n");

// Bestand sluiten
fclose($file);
?>