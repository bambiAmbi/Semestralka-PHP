<?php
session_start();
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);

if($id_uzivatele != 14);
header("Location: index2.html");

$db = require __DIR__ . "/databaze.php";

$data = [
    'NAZEV_ENG' => htmlspecialchars($_POST["nazev_eng"]),
    'NAZEV_JP' => htmlspecialchars($_POST["nazev_jp"]),
    'POCET_EPIZOD' => htmlspecialchars($_POST["pocet_ep"]),
    'POCET_SERII' => htmlspecialchars($_POST["pocet_s"]),
    'POPIS' => htmlspecialchars($_POST["popis"]),
    'OBRAZEK' => htmlspecialchars($_POST["obrazek"]),
    'ID' => htmlspecialchars($_POST["id"])

];

$sql = "UPDATE ANIME SET 
                 NAZEV_ENG = :NAZEV_ENG, 
                 NAZEV_JP = :NAZEV_JP,
                 POCET_EPIZOD = :POCET_EPIZOD,
                 POCET_SERII = :POCET_SERII,
                 POPIS = :POPIS,
                 OBRAZEK = :OBRAZEK
                 WHERE ID LIKE :ID ";
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



?>
