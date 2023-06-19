<?php
session_start();
$db = require __DIR__ . "/databaze.php";
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);


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
        <h1>Vyhledávání anime</h1>

        <form action="" method="get">
            <div class="wrap">
                <div class="hledat">
                    <input type="text" name="vyhledej" class="searchTerm" placeholder="Vyhledej anime, které tě zajímá" value="<?php if(isset($_GET['vyhledej'])){echo $_GET['vyhledej']; } ?>">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <main>
            <?php
            if(isset($_GET['vyhledej'])) {
            $filtr = htmlspecialchars($_GET['vyhledej']);
            $sql = "SELECT * FROM ANIME WHERE CONCAT(NAZEV_ENG, NAZEV_JP) LIKE '%$filtr%'";
            $vysledek = $db->query($sql);

            while($vybrane_anime = $vysledek->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="karta">
              <div class="obrazek">
                  <img src="<?= htmlspecialchars($vybrane_anime['OBRAZEK_CESTA'])?>">
              </div>
                <div class="info">
                    <a href="stranka_anime.php?id=<?=htmlspecialchars($vybrane_anime['ID'])?>"><p class="nazev_a"><?php echo $vybrane_anime["NAZEV_ENG"] ?></p></a>
                    <p class="nazev_j"><?php echo htmlspecialchars($vybrane_anime["NAZEV_JP"])?></p>
                    <p class="pocet_d"><?php echo htmlspecialchars($vybrane_anime["POCET_EPIZOD"])?></p>
                    <p class="pocet_s"><?php echo htmlspecialchars($vybrane_anime["POCET_SERII"])?></p>
                </div>

                <div class="tlacitka">
                    <?php
                    $id_anime = htmlspecialchars($vybrane_anime['ID']);
                    $sql_anime_oblibene = "SELECT * FROM OBLIBENE LEFT JOIN ANIME ON OBLIBENE.ANIME_ID=ANIME.ID WHERE USER_Id='$id_uzivatele' AND ANIME_ID='$id_anime'";
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
                        <form method="post" action="odebrat_z_oblibenych.php.php">
                            <input type="hidden" id="anime_id" name="anime_id" value=<?php echo htmlspecialchars($vybrane_anime["ID"])?>>
                            <input type="hidden" id="user_id" name="user_id" value=<?php echo htmlspecialchars($_SESSION['id_uzivatele'])?>>
                            <button>Odebrat z oblíbených</button>
                        </form>
                    <?php } ?>

                    <?php
                    $sql_anime_rozkoukane = "SELECT * FROM ROZKOUKANE LEFT JOIN ANIME ON ROZKOUKANE.ANIME_ID=ANIME.ID WHERE USER_Id='$id_uzivatele' AND ANIME_ID='$id_anime'";
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
                    </form>
                </div>
                </div>
            </main>
            <?php
                }
            }
            ?>

        </main>

    </div>
</div>

</body>
</html>