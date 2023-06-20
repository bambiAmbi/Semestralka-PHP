<?php
session_start();
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);

if($id_uzivatele != 14) {
    header("Location: index2.html");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holiday.css@0.11.0" />
    <link rel="stylesheet" type="text/css" href="admin_panel_style.css">
</head>
<body>
<div class="main">
    <div class="menu">
        <h2 id="nazev">AniTrack</h2>
        <a href="admin_panel.php">Domů</a>
        <a href="admin_pridani_anime.html">Přidat anime</a>
        <a href="admin_uprava_anime.php">Upravit anime</a>
        <a href="odhlaseni.php">Odhlásit se</a>
    </div>

    <div class="body">
        <h1>Admin panel</h1>
        <h2>Přidání anime</h2>
        <p>Zde můžete přidat anime, které právě vyšlo nebo nějaké, které není v databázi.</p>

        <form method="post" action="pridani_anime.php">
        <div class="pridani">
            <div>
                <label for="nazev_eng">Název v angličtině</label>
                <input type="text" name="nazev_eng" id="nazev_eng">
            </div>

            <div>
                <label for="nazev_jp">Název v japonštině</label>
                <input type="text" name="nazev_jp" id="nazev_jp">
            </div>

            <div>
                <label for="pocet_ep">Počet epizod</label>
                <input type="number" name="pocet_ep" id="pocet_ep">
            </div>

            <div>
                <label for="pocet_s">Počet sezon</label>
                <input type="number" name="pocet_s" id="pocet_s">
            </div>

            <div>
                <label for="popis">Popis anime</label>
                <br>
                <textarea id="popis" name="popis" rows="6" cols="50"></textarea>
                <br/>
            </div>

            <div>
                <label for="image">Název obrázku</label>
                <input type='file' name='files[]' accept="image/png, image/jpeg" />
                <input type='submit' value='Přidat' name='submit' />

            </div>
        </div>
        </form>



        </div>
    </div>
</div>

</body>
</html>

