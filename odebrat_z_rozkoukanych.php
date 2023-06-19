<?php
$db = require __DIR__ . "/databaze.php";

$data = [
    'USER_ID' => (int)htmlspecialchars($_POST["user_id"]),
    'ANIME_ID' => (int)htmlspecialchars($_POST["anime_id"]),
];

$sql = 'DELETE FROM ROZKOUKANE WHERE USER_ID=:USER_ID AND ANIME_ID=:ANIME_ID ';
$statement = $db->prepare($sql);

try {
    $statement->execute($data);
    header("Location: user_uspesne.html");
    exit;
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        echo "Anime není ve vašich rozkoukaných.";
    } else {
        $db->errorInfo();
    }
}



?>
