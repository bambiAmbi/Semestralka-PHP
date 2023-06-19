<?php

session_start();

if(isset($_SESSION["id_uzivatele"])) {
    $db = require __DIR__ . "/databaze.php";
    $id_uzivatele = htmlspecialchars($_SESSION['id_uzivatele']);

    $sql = "SELECT * FROM USER
            WHERE ID = $id_uzivatele";
    $vysledek = $db->query($sql);
    $user = $vysledek->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Domovská stránka</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holiday.css@0.11.0" />
</head>
<body>
<h1>Domovská stránka</h1>

    <?php if(isset($user)):?>
        <p>Jste přihlášeni. Vítej <?=htmlspecialchars($user["JMENO"])?></p>
    <p><a href="odhlaseni.php">Odhlásit se</a></p>
    <?php else: ?>
        <p><a href="prihlaseni.php">Příhlásit se</a> nebo se <a href="registrace1.php">zaregistrovat</a>.</p>

    <?php endif; ?>
</body>
</html>
