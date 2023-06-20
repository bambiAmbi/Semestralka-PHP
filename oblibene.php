<?php

session_start();
$db = require __DIR__ . "/databaze.php";
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);

$sql_anime = "SELECT * FROM OBLIBENE LEFT JOIN ANIME ON OBLIBENE.ANIME_ID=ANIME.ID WHERE USER_Id='$id_uzivatele' ";
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
        <h1>Oblíbené</h1>


        <main>
            <?php
            while($vybrane_anime = $vysledek_anime->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="karta">
                <div class="obrazek">
                    <img src="<?= htmlspecialchars($vybrane_anime['OBRAZEK_CESTA'])?>">

                </div>
                <div class="info">
                    <a href="stranka_anime.php?id=<?=htmlspecialchars($vybrane_anime['ID'])?>"><p class="nazev_a">Název: <?php echo htmlspecialchars($vybrane_anime["NAZEV_ENG"]) ?></p></a>
                    <p class="nazev_j">JP: <?php echo htmlspecialchars($vybrane_anime["NAZEV_JP"])?></p>
                    <p class="pocet_d">Pocet epizod:<?php echo htmlspecialchars($vybrane_anime["POCET_EPIZOD"])?></p>
                    <p class="pocet_s">Počet serii:<?php echo htmlspecialchars($vybrane_anime["POCET_SERII"])?></p>
                </div>
                <form method="post" action="odebrat_z_oblibenych.php">
                    <input type="hidden" id="anime_id" name="anime_id" value=<?php echo htmlspecialchars($vybrane_anime["ID"])?>>
                    <input type="hidden" id="user_id" name="user_id" value=<?php echo htmlspecialchars($_SESSION['id_uzivatele'])?>>
                    <button>Odebrat z oblíbených</button>
                </form>
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