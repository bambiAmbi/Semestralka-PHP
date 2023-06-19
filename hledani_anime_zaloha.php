<?php
session_start();
$db = require __DIR__ . "/databaze.php";


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
        <a href="pratele.php">Přátelé</a>
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
            $filtr = $_GET['vyhledej'];
            $sql = "SELECT * FROM ANIME WHERE CONCAT(NAZEV_ENG, NAZEV_JP) LIKE '%$filtr%'";
            $vysledek = $db->query($sql);

            while($vybrane_anime = $vysledek->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="karta">
                <div class="obrazek">
                    <?php echo '<img src="data:image/jpeg, image/png, image/jpg;base64,'.base64_encode( $vybrane_anime['OBRAZEK'] ).'"/>' ?>
                </div>
                <div class="info">
                    <p class="nazev_a"><?php echo $vybrane_anime["NAZEV_ENG"] ?></p>
                    <p class="nazev_j"><?php echo $vybrane_anime["NAZEV_JP"] ?></p>
                    <p class="pocet_d"><?php echo $vybrane_anime["POCET_EPIZOD"]?></p>
                    <p class="pocet_s"><?php echo $vybrane_anime["POCET_SERII"]?></p>
                </div>
                <div class="tlacitka">
                    <form method="post" action="pridat_do_oblibenych.php">
                        <input type="hidden" id="anime_id" name="anime_id" value=<?php echo $vybrane_anime["ID"]?>>
                        <input type="hidden" id="user_id" name="user_id" value=<?php echo $_SESSION['id_uzivatele']?>>
                        <button>Oblíbené</button>
                    </form>

                    <form method="post" action="pridat_do_rozkoukanych.php">
                        <input type="hidden" id="anime_id" name="anime_id" value=<?php echo $vybrane_anime["ID"]?>>
                        <input type="hidden" id="user_id" name="user_id" value=<?php echo $_SESSION['id_uzivatele']?>>
                        <button>Rozkoukané</button>
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