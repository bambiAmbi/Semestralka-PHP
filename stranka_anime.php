<?php
session_start();
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);
$db = require __DIR__ . "/databaze.php";

if(isset($_GET['id'])) {

    $anime_id = htmlspecialchars($_GET['id']);
    $sql_anime = "SELECT * FROM ANIME WHERE ID = $anime_id";
    $vysledek_anime = $db->query($sql_anime);
    $vybrane_anime = $vysledek_anime->fetch(PDO::FETCH_ASSOC);

}
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
        <h1><?= htmlspecialchars($vybrane_anime['NAZEV_ENG'])?></h1>
        <div class="sloupec">
            <img src="<?= htmlspecialchars($vybrane_anime['OBRAZEK_CESTA'])?>">
            <p>Pocet epizod: <?= htmlspecialchars($vybrane_anime['POCET_EPIZOD'])?></p>
            <p>Počet serii:<?= htmlspecialchars($vybrane_anime['POCET_SERII'])?></p>
        </div>
        <div class="sloupec">
            <p>Název v japonštině: <?= htmlspecialchars($vybrane_anime['NAZEV_JP'])?></p>
            <p>Popis: <?= htmlspecialchars($vybrane_anime['POPIS'])?>
            </p>
        </div>


        <?php
        $sql_anime_oblibene = "SELECT * FROM OBLIBENE LEFT JOIN ANIME ON OBLIBENE.ANIME_ID=ANIME.ID WHERE USER_Id='$id_uzivatele' AND ANIME_ID='$anime_id'";
        $vysledek_anime = $db->query($sql_anime_oblibene);
        $vybrane_anime_oblibene = $vysledek_anime->fetch(PDO::FETCH_ASSOC);
        $pocet_oblibenych = $vysledek_anime->RowCount();

        if($pocet_oblibenych == 0) { ?>

            <form method="post" action="pridat_do_oblibenych.php">
                <input type="hidden" id="anime_id" name="anime_id" value=<?php echo htmlspecialchars($vybrane_anime["ID"])?>>
                <input type="hidden" id="user_id" name="user_id" value=<?php echo htmlspecialchars($_SESSION['id_uzivatele'])?>>
                <button>Oblíbené</button>
            </form>
            <?php
        } else {
            ?>
            <form method="post" action="odebrat_z_oblibenych.php">
                <input type="hidden" id="anime_id" name="anime_id" value=<?php echo htmlspecialchars($vybrane_anime["ID"])?>>
                <input type="hidden" id="user_id" name="user_id" value=<?php echo htmlspecialchars($_SESSION['id_uzivatele'])?>>
                <button>Odebrat z oblíbených</button>
            </form>
        <?php } ?>

        <?php
        $sql_anime_rozkoukane = "SELECT * FROM ROZKOUKANE LEFT JOIN ANIME ON ROZKOUKANE.ANIME_ID=ANIME.ID WHERE USER_Id='$id_uzivatele' AND ANIME_ID='$anime_id'";
        $vysledek_anime_rozkoukane = $db->query($sql_anime_rozkoukane);
        $vybrane_anime_rozkoukane = $vysledek_anime_rozkoukane->fetch(PDO::FETCH_ASSOC);
        $pocet_rozkoukanych = $vysledek_anime_rozkoukane->RowCount();

        if($pocet_rozkoukanych == 0) {
            ?>

            <form method="post" action="pridat_do_rozkoukanych.php">
                <input type="hidden" id="anime_id" name="anime_id" value=<?php echo htmlspecialchars($vybrane_anime["ID"])?>>
                <input type="hidden" id="user_id" name="user_id" value=<?php echo htmlspecialchars($_SESSION['id_uzivatele'])?>>
                <button>Rozkoukané</button>
            </form>
            <?php
        } else {
        ?>
        <form method="post" action="odebrat_z_rozkoukanych.php">
            <input type="hidden" id="anime_id" name="anime_id" value=<?php echo htmlspecialchars($vybrane_anime["ID"])?>>
            <input type="hidden" id="user_id" name="user_id" value=<?php echo htmlspecialchars($_SESSION['id_uzivatele'])?>>
            <button>Odebrat z rozkoukaných</button>
            <?php } ?>
    </div>


</div>

</body>
</html>