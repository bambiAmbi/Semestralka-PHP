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
        <a href="admin_pridani_anime.php">Přidat anime</a>
        <a href="admin_uprava_anime.php">Upravit anime</a>
        <a href="upload_obrazku.php">Nahrát obrázky</a>
        <a href="odhlaseni.php">Odhlásit se</a>
    </div>

    <div class="body">
    <h1>Admin panel</h1>
        <p>Vítejte na adminském panelu. Zde můžete
        upravovat a přidávat nové anime do naši databáze.</p>
    </div>
</div>

</body>
</html>
