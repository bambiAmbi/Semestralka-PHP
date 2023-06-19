<?php
$db = require __DIR__ . "/databaze.php";

$data = [
    'USER_ID' => (int)htmlspecialchars($_POST["user_id"]),
    'PRITEL_ID' => (int)htmlspecialchars($_POST["pritel_id"]),
];

$sql = 'DELETE FROM PRATELE WHERE USER_ID=:USER_ID AND PRITEL_ID=:PRITEL_ID ';
$statement = $db->prepare($sql);

try {
    $statement->execute($data);
    header("Location: user_uspesne.html");
    exit;
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        echo "Uživatel již v oblíbených";
    } else {
        $db->errorInfo();
    }
}



?>
