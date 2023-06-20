<?php
session_start();
$db = require __DIR__ . "/databaze.php";
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);
$validni_post = false;
$validni_jmeno = true;
$validni_jp_jmeno = true;
$validni_pocet_epizod = true;
$validni_pocet_serii = true;
$validni_popis_anime = true;
$validni_obrazek = true;


if($id_uzivatele != 14) {
    header("Location: index2.html");
}
if(isset($_POST['submit'])){
    if (empty($_POST["nazev_eng"])) {
        $validni_jmeno = false;
    }

    if (empty($_POST["nazev_jp"])) {
        $validni_jp_jmeno = false;
    }

    if (empty($_POST["pocet_ep"])) {
        $validni_pocet_epizod = false;
    } else if($_POST["pocet_ep"] <= 0) {
        $validni_pocet_epizod = false;
    }

    if (empty($_POST["pocet_serii"])) {
        $validni_pocet_serii = false;
    } else if($_POST["pocet_serii"] <= 0) {
        $validni_pocet_serii = false;
    }

if($validni_jmeno && $validni_jp_jmeno && $validni_pocet_epizod && $validni_pocet_serii && $validni_popis_anime){
    $validni_post = true;
}
if($validni_post) {
    $data = [
        'NAZEV_ENG' => htmlspecialchars($_POST["nazev_eng"]),
        'NAZEV_JP' => htmlspecialchars($_POST["nazev_jp"]),
        'POCET_EPIZOD' => htmlspecialchars($_POST["pocet_ep"]),
        'POCET_SERII' => htmlspecialchars($_POST["pocet_s"]),
        'POPIS' => htmlspecialchars($_POST["popis"]),
        'OBRAZEK_CESTA' => htmlspecialchars($_POST["obrazek"])

    ];

    $sql = 'INSERT INTO ANIME(NAZEV_ENG, NAZEV_JP, POCET_EPIZOD, POCET_SERII, POPIS, OBRAZEK_CESTA) VALUES(:NAZEV_ENG, :NAZEV_JP, :POCET_EPIZOD, :POCET_SERII, :POPIS, :OBRAZEK_CESTA)';
    $statement = $db->prepare($sql);

    try {
        $statement->execute($data);
        header("Location: admin_uspesne.html");
        exit;
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            echo "Toto anime je již zadané.";
        } else {
            $db->errorInfo();
        }
    }
}
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

        <form method="post" action="">
        <div class="pridani">
            <div>
                <label for="nazev_eng">Název v angličtině</label>
                <input type="text" name="nazev_eng" id="nazev_eng">
                <?php if(!$validni_jmeno): ?>
                    <em>Musíte zadat anglický název anime</em>
                <?php endif; ?>
            </div>

            <div>
                <label for="nazev_jp">Název v japonštině</label>
                <input type="text" name="nazev_jp" id="nazev_jp">
                <?php if(!$validni_jp_jmeno): ?>
                    <em>Musíte zadat japonský název anime</em>
                <?php endif; ?>
            </div>

            <div>
                <label for="pocet_ep">Počet epizod</label>
                <input type="number" name="pocet_ep" id="pocet_ep">
                <?php if(!$validni_pocet_epizod): ?>
                    <em>Počet epizod musí být větší než 0</em>
                <?php endif; ?>
            </div>

            <div>
                <label for="pocet_s">Počet sezon</label>
                <input type="number" name="pocet_s" id="pocet_s">
                <?php if(!$validni_pocet_serii): ?>
                    <em>Počet sérií musí být větší než 0</em>
                <?php endif; ?>
            </div>

            <div>
                <label for="popis">Popis anime</label>
                <br>
                <textarea id="popis" name="popis" rows="6" cols="50"></textarea>
                <br/>
                <?php if(!$validni_popis_anime): ?>
                    <em>Musíte zadat popis anime</em>
                <?php endif; ?>
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

