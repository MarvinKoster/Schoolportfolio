
<?php
$menu = [
    [
        "text" => "Home",
        "link" => "../HTML/index.php#home"
    ],
    [
        "text" => "Over mij!",
        "link" => "#",
        "submenu" => [
            ["text" => "Over mij!", "link" => "../HTML/index.php#about"],
            ["text" => "Familie", "link" => "../HTML/index.php#familie"],
            ["text" => "Hobby's", "link" => "../HTML/index.php#hobby"],
            ["text" => "Eten", "link" => "../HTML/index.php#eten"],

            
        ]
    ],
    [
        "text" => "Opleiding",
        "link" => "../HTML/index.php#opleiding",
        "submenu" => []
    ],
    [
        "text" => "Projecten",
        "link" => "#",
        "submenu" => [
            ["text" => "Toad puzzel", "link" => "../HTML/legpuzzel.php"],
            ["text" => "Pijltjes", "link" => "../HTML/pijltjes.php"],
            ["text" => "Projecten", "link" => "../HTML/index.php#projecten"], 
            ["text" => "Beoordeling", "link" => "../PHP/beoordeling.php"],
            ["text" => "CV uploader", "link" => "../database/main.php"],
        ]
    ],
    [
        "text" => "Contact",
        "link" => "../HTML/index.php#contact",
        "submenu" => [
                ["text" => "Beoordeling", "link" => "../HTML/index.php#beoordeling"]
        ]
    ]
];
?>


<nav>
    <?php foreach ($menu as $item): ?>

        <?php if (!empty($item["submenu"])): ?>
            <div class="dropdown">
                <a class="dropdownbtn">
                    <?= $item["text"] ?>
                    <i class="fa-solid fa-caret-down"></i>
                </a>

                <div class="dropdown-content">
                    <?php foreach ($item["submenu"] as $sub): ?>
                        <a href="<?= $sub["link"] ?>"><?= $sub["text"] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php else: ?>
            <a href="<?= $item["link"] ?>"><?= $item["text"] ?></a>
        <?php endif; ?>

    <?php endforeach; ?>
</nav>

<link rel="stylesheet" href="../stylesheet/navbar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

