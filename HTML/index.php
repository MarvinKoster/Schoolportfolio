<!--
Dit is de main index. dit moet je hebben om alles te kunnen bekijken werkend. tot zover ik dat weet

-->




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylesheet/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Portfolio</title>
</head>
<body>

<header>
    <h1>Marvin Koster</h1>
    <?php include '../PHP/menu.php'; ?>
</header>

<section id="home">
    <img src="../image/pfp.jpg" alt="guy sitting on a rock looking at the sunset" class="profile-pic">
    <h2>Welkom op mijn portfolio!</h2>
    <p>Hier vind je informatie over mij, mijn familie, hobby's, opleiding en contactgegevens.</p>

    <!--  De darkmode is nog steeds in de maak maar hij werkt momenteel helemaal niet meer. dit zou ik fixen)  -->
    <button onclick="darkmode()"><i class="fa-solid fa-moon fa-beat"></i></button>
    <!-- <button onclick="window.location.href='#about'">Meer over mij ⬇</button>   De buttons zijn nog in beta :) -->
</section>


<section class="darker">
    <div id="about">
        <h2>Over mij</h2>
        <p>Hier leer je me beter kennen!</p>

        <!-- <img src="../image/pfp.jpg" alt="guy sitting on a rock looking at the sunset" class="big-pic"> -->

        <div class="mijnverhaal">
            <h3>Mijn verhaal</h3>
            <p>Ik ben Marvin Koster, 16 jaar. Momenteel werk ik bij de Dirk. Sinds kort ben ik verhuisd naar Assen. Dit heb ik gedaan voor mijn opleiding die ik nu volg op Drenthe College. </p>
        </div>

        <div class="watikleukvind">
            <h3>Wat ik leuk vind</h3>
            <p>Ik hou van gamen (zoals iedereen). Ik hou eigenlijk best veel van leren, vooral als je het in één keer snapt uit het niets. Verder hou ik van lopen, foto's maken en random dingen kopen.</p>
        </div>
    </div>
    <!-- <button onclick="window.location.href='about1'">Klik voor meer over mij ⮕</button>   De buttons zijn nog in beta :) -->
</section>

<section id="familie">
    <h2>Familie</h2>
    <p>Hier vind je informatie over mijn familie!</p>

    <div class="fam-cards">
        <div class="hoek">
            <img src="../image/mama.jpg" alt="foto van familie">
            <h3 style="margin: 3%;">Moeder</h3>
            <h4 style="color:  #7BDFF2; margin: 0;">Mijn Moeder</h4>
            <p>Dit is m'n moeder.</p>
        </div>

        <div class="normaal">
            <img src="../image/pa.jpg" alt="foto van familie">
            <h3 style="margin: 3%;">Vader</h3>
            <h4 style="color:  #7BDFF2; margin: 0;">Mijn pa</h4>
            <p>Dit is m'n Pa.</p>
        </div>

        <div class="normaal" onclick="openBroer()">
            <span class="tooltiptext">
                klik op het kaartje voor meer
            </span>
            <img src="../image/brather.jpg" alt="foto van broerders">
            <h3 style="margin: 3%;">Broer</h3>
            <h4 style="color:  #7BDFF2; margin: 0;">Mijn broer</h4>
            <p>Ik heb één broer, Kevin hij woont toevalig dichtbij, dus kom regelmatig langs.</p>
        </div>

        <div class="normaal">
            <img src="../image/zus(je).jpg" alt="foto van broer en zus(je)">
            <h3 style="margin: 3%;">Zus(je)</h3>
            <h4 style="color:  #7BDFF2; margin: 0;">Mijn zus(je)</h4>
            <p>Ik heb een zus die heet caeley en die is 21, en een zusje die heet mandy die is 15.</p>
        </div>

        <div class="hoek">
            <img src="../image/cat.jpg" alt="foto van me kat:)">
            <h3 style="margin: 3%;">Huisdieren</h3>
            <h4 style="color:  #7BDFF2; margin: 0;">Mijn huisdieren</h4>
            <p>Ik heb 4 huisdieren. Spike, Lexy, Lucky en Jovi</p>
        </div>
    </div>

    <!-- <button onclick="window.location.href='#familie1'">Klik voor meer over mijn familie ⮕</button>  De buttons zijn nog in beta :) -->
</section>

<section class="darker">
    <div id="hobby">
        <h2>Hobby's</h2>
        <p>Hier vind je informatie over mijn hobby's!</p>
        <div class="hob-cards">
            <div class="gamen">
                <img src="../image/room.jpg" alt="plaatje van me kamer die ik heb gemaakt">
                <h3>Gamen</h3>
                <p>In mijn vrije tijd hou ik er van om te game. Het is gewoon een klein beetje tijd doden.</p>
            </div>

            <div class="lopen">
                <img src="../image/lopen.jpg" alt="plaatje van een man in het bos">
                <h3>Lopen</h3>
                <p>Ik hou er van om te lopen. Dit doe ik vooral als het lekker weer is.</p>
            </div>

            <div class="muziek">
                <img src="../image/muziek.png" alt="plaatje van muziek instrumenten">
                <h3>Muziek</h3>
                <p>Ik vind dat muziek toch wel een deel van m'n leven verbeterd. het geeft rust en toch soms energie derbij</p>
            </div>
        </div>
    </div>
    <!-- <button onclick="window.location.href='#hobby1'">Klik voor meer over mijn hobby's ⮕</button>  De buttons zijn nog in beta :) -->
</section>

<section id="opleiding">
    <h2>Opleiding</h2>
    <p>Hier vind je informatie over mijn opleiding!</p>
    <div class="school-cards">
        <div class="huidigeopleiding">
            <h3>Huidige opleiding</h3>
            <h4>Drenthe college</h4>
            <p><time>2025 t/m 2???</time> Assen </p>
            <p>Hier merk ik dat mijn zelfstandigheid steeds meer begint te groeien. Op deze opleiding werk je veel meer op jezelf en leer je zelfstandig keuzes maken. Soms is dat even wennen, maar ik denk dat het juist de bedoeling is om op die manier te groeien.
                <br>
                <br>
                Ik vind de opleiding Software Developer oprecht interessant. Omdat het onderwerp mij echt aanspreekt, maakt het school voor mij ook leuker en motiverender. En het leren maakt het leuk. Ik merk dat ik thuis ook meer met code bezig ben.w
            </p>
        </div>

        <div class="middelbareschool">
            <h3>Mijn middelbare school</h3>
            <h4>Porteum </h4>
            <p><time>2020 t/m 2025 </time> Lelystad  </p>
            <p>Tijdens mijn middelbare schoolperiode heb ik veel geleerd, niet alleen op het gebied van kennis, maar ook op sociaal vlak. Ik leerde omgaan met verschillende soorten mensen en situaties, waardoor ik beter ben geworden in samenwerken en communiceren, Al vindt ik het ook niet erg om alleen te werken;)
                Ik had hier ook 2 jaar lang koken gedaan. Dit kon ik kiezen tussen een paar andere keuzenvakken, Opzich was het best prima maar ik weet wel dat me passie der niet licht
            </p>
        </div>

        <div class="bassischool">
            <h3>Mijn basisschool </h3>
            <h4>Lepelaar</h4>
            <p><time>2012 t/m 2020</time> Lelystad  </p>
            <p>Hier begon m´n opbouw van m´n leven. Hier leerde ik schrijven, lezen en op tijd komen.
                Rond groep 6 hadden we elke dag (soms hielden ze langer vol) een invaller, dus elke dag een nieuwe jufvrouw. Voor de rest had ik best een leuke bassischool.
            </p>
        </div>
    </div>
    <!-- <button onclick="window.location.href='#opleiding1'">Klik voor meer over mijn opleiding ⮕</button>  De buttons zijn nog in beta :) -->
</section>


<section id="eten">
    <h2>Eten</h2>
    <p>Hier kom je meer te weten over wat ik lekker vind:D</p>

    <div class="foedsol"></div>
    <div class="foedsol"></div>
    <div class="foedsol"></div>
    <div class="foedsol"></div>
</section>

<!-- <button onclick="window.location.href='Eten'">Klik voor meer over mijn eten te weten komen</button>  De buttons zijn nog in beta :) -->


<section id="projecten">
    <h2>Projecten</h2>
    <p>Hier komen projecten die ik heb gemaakt te staan</p>
    <div class="projecten-cards">
        <div class="cards" onclick="myFunction()">
            <span class="tag school">School</span>
            <img src="../image/number-1.png" alt="">
            <div class="text">
                <h3>Website Portfolio </h3>
                <p>HTML & CSS</p>
                <p>Een persoonlijke portfolio</p>

            </div>
        </div>


        <div class="cards">
            <span class="tag school">School</span>
            <img src="../image/circle-2.png" alt="">
            <div class="text">
                <h3>Legpuzzel</h3>
            </div>
        </div>

        <div class="cards">
            <span class="tag home">Home</span>
            <img src="../image/number-3.png" alt="">
            <h3>SOON</h3>
        </div>

    </div>
</section>


<section id="beoordeling">
    <h2>Beoordeling</h2>
    <p>Hier zie je wat ik vindt van de opdrachten die ik heb gemaakt.</p>
    <?php include '../PHP/view.html'?>


</section>


<footer>
    <h2 id="contact">Laten we contact maken</h2>
    <p>In contact komen met mij?     Kies de manier die het beste bij je past.</p>
    <div class="email">
        <aside><img src="../image/email.png" alt="emailpng" style="width: 24px; height: 24px;"></aside>
        <h3>Email</h3>
        <p>School mail</p>
        <h4>147651@student.dcterra.nl</h4>
    </div>
    </a>

    <div class="teams">
        <aside><img src="../image/team.png" alt="teamspng" style="width: 24px; height: 24px;"></aside>
        <h3>Teams</h3>
        <p>voor directe communicatie</p>
        <h4>147651@student.dcterra.nl</h4>

    </div>

    <div class="locatie" onclick="myFunction2()">
        <aside><img src="../image/map.png" alt="mappng" style="width: 24px; height: 24px;"></aside>
        <h3>locatie</h3>
        <p>Gevestigd in</p>
        <p style="font-weight: bold;">Assen, Nederland</p>
    </div>

    <div class="volgme">
        <h3>Volg me online</h3>
        <button onclick="myFunction4()"><i class="fa-brands fa-github fa-fade fa-lg"></i></button>
    </div>

    </div>

</footer>

<script src="../javascript/main.js"></script>

</body>
</html>