<?php

session_start();
$db = require __DIR__ . "/databaze.php";
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);
$id_pritele = htmlspecialchars($_GET['id']);
$jmeno_pritele = htmlspecialchars($_GET['jmeno']);

$sql_anime = "SELECT * FROM ROZKOUKANE LEFT JOIN ANIME ON ROZKOUKANE.ANIME_ID=ANIME.ID WHERE USER_Id='$id_pritele' ";
$vysledek_anime = $db->query($sql_anime);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Domovská stránka</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holiday.css@0.11.0" />
    <link rel="stylesheet" type="text/css" href="admin_panel_style.css">
    <link rel="stylesheet" type="text/css" href="karta.css">
</head>
<body>
<div class="main2">
    <div class="menu">
        <h2 id="nazev">AniTrack</h2>
        <a href="index2.html">Domů</a>
        <a href="hledani_anime.php">Hledat anime</a>
        <a href="oblibene.php">Oblíbené</a>
        <a href="rozkoukane.php">Rozkoukané</a>
        <a href="pratele_vyhledavani.php">Přátelé</a>
        <a href="pratele.php">Vyhledat přítele</a>
        <a href="odhlaseni.php">Odhlásit se</a>
    </div>

    <div class="body">
        <h1>Rozkoukané uživatele: <?php echo htmlspecialchars($jmeno_pritele)?></h1>


        <main>
            <?php
            while($vybrane_anime = $vysledek_anime->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="karta">
                <div class="obrazek">
                    <img src="<?= htmlspecialchars($vybrane_anime['OBRAZEK_CESTA'])?>">
                </div>
                <div class="info">
                    <a href="stranka_anime.php?id=<?=htmlspecialchars($vybrane_anime['ID'])?>"><p class="nazev_a"><?php echo $vybrane_anime["NAZEV_ENG"] ?></p></a>
                    <p class="nazev_j"><?php echo htmlspecialchars($vybrane_anime["NAZEV_JP"]) ?></p>
                    <p class="pocet_d"><?php echo htmlspecialchars($vybrane_anime["POCET_EPIZOD"])?></p>
                    <p class="pocet_s"><?php echo htmlspecialchars($vybrane_anime["POCET_SERII"])?></p>
                </div>
            </div>
        </main>
        <?php
        }
        ?>

        </main>

    </div>
</div>

</body>
</html>