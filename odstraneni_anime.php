<?php


session_start();
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);

if ($id_uzivatele != 14) ;
header("Location: index2.html");

$db = require __DIR__ . "/databaze.php";

$id = htmlspecialchars($_POST['id']);
$cesta = htmlspecialchars($_POST['cesta']);

$sql = "DELETE FROM ANIME WHERE ID=$id";
$statement = $db->prepare($sql);
unlink($cesta);

try {
    $statement->execute();
    header("Location: admin_uspesne.html");
    exit;
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        echo "Toto anime je již zadané.";
    } else {
        $db->errorInfo();
    }
}


?>