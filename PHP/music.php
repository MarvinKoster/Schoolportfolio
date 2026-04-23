<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Muziek</title>
</head>
<body>
<link rel="stylesheet" href="../stylesheet/muziek.css">
<script src="../javascript/menu.js"></script>

<?php
$hour = date("G"); // 0–23 format

if ($hour >= 6 && $hour < 12) {
    echo "<h1>Goede Morgen</h1>";
} elseif ($hour >= 12 && $hour < 18) {
    echo "<h1>Goede Middag</h1>";
} else {
    echo "<h1>Goede Avond</h1>";
}
?>

<!--    
Wat doet dit?
We zeggen hier $hour = date(g) <-- dit houd in dat 0 23 format is dus 1 zou gezien worden als echo goeden avond

Als (if) $hour gelijk (>=) is aan 6 en het is lager (<) dan 12 zeg dan (echo) Goede Morgen

-->

<section>
    <h1>Muziek</h1>
    <p>Hier vindt je mijn muziek smaak</p>
</section>
<h2>Featured Playlists</h2>
<section class="FeaturedPlaylists">
    <div class="playlist">
        <div class="playlistcover">
            <img src="../image/cover.jpg">
        </div>
        <div class="playlisttittle">Peak playlist</div>
        </div>
    </div>
    <div class="playlist">
        <div class="playlistcover">
            <img src="../image/cover.jpg">
        </div>
        <div class="playlisttittle">Music</div>
    </div>
    </div>
    </div>
    <div class="playlist">
        <div class="playlistcover">
            <img src="../image/cover.jpg">
        </div>
        <div class="playlisttittle">Music</div>
    </div>
    </div>
    </div>
    <div class="playlist">
        <div class="playlistcover">
            <img src="../image/cover.jpg">
        </div>
        <div class="playlisttittle">Music</div>
    </div>
    </div>
    </div>
</section>

</body>
</html>