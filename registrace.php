<?php

$validni_prihlaseni = false;
$validni_jmeno = true;
$validni_email = true;
$validni_heslo = true;
$validni_overovaci_heslo = true;
$dlouhe_heslo = true;
$nestejne_heslo = true;
if($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["jmeno"])) {
        $validni_jmeno = false;
    }

    if (!filter_var(htmlspecialchars($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $validni_email = false;
    }

    if (empty($_POST["heslo"])) {
        $validni_heslo = false;
    }

    if (empty($_POST["overeni"])) {
        $validni_overovaci_heslo = false;
    }

    if (strlen(htmlspecialchars($_POST["heslo"])) < 6) {
        $dlouhe_heslo = false;
    }

    if (htmlspecialchars($_POST["overeni"]) != htmlspecialchars($_POST["heslo"])) {
        $nestejne_heslo = false;
    }

    if($validni_jmeno &&
    $validni_email &&
    $validni_heslo &&
    $validni_overovaci_heslo &&
    $dlouhe_heslo &&
    $nestejne_heslo) {
        $validni_prihlaseni = true;
    }

}

if($validni_prihlaseni){

    $zahashovane_heslo = password_hash(htmlspecialchars($_POST["heslo"]), PASSWORD_DEFAULT);
    $db = require __DIR__ . "/databaze.php";

    $data = [
        'JMENO' => htmlspecialchars($_POST["jmeno"]),
        'EMAIL' => htmlspecialchars($_POST["email"]),
        'HASH_HESLO' => $zahashovane_heslo
    ];

    $sql = 'INSERT INTO USER(JMENO, EMAIL, HASH_HESLO) VALUES(:JMENO, :EMAIL, :HASH_HESLO)';
    $statement = $db->prepare($sql);
    $user = $vysledek->fetch(PDO::FETCH_ASSOC);


    try {
    $statement->execute($data);
    header("Location: uspesna_registrace.html");
    exit;
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        echo "Email již použit";
    } else {
        $db->errorInfo();
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holiday.css@0.11.0" />
</head>
<body>
<h1>Registrace</h1>


<form action="registrace.php" method="post">
    <div>
        <label for="jmeno">Jméno</label>
        <input type="text" id="jmeno" name="jmeno" value="<?= htmlspecialchars($_POST["jmeno"] ?? "")?>">
        <?php if(!$validni_jmeno): ?>
            <em>Nesprávné jmeno</em>
        <?php endif; ?>
    </div>

    <div>

        <label for="email">E-mail</label>
        <input type="text" id="email" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "")?>">
        <?php if(!$validni_email): ?>
            <em>Nesprávný email</em>
        <?php endif; ?>
    </div>


    <div>

        <label for="heslo">Heslo</label>
        <input type="password" id="heslo" name="heslo">
        <?php if(!$validni_heslo): ?>
            <em>Nesprávné heslo</em>
        <?php endif; ?>
        <?php if(!$dlouhe_heslo): ?>
            <em>Heslo musí mít alespoň 6 znaků.</em>
        <?php endif; ?>
    </div>

    <div>

        <label for="overeni">Heslo znovu</label>
        <input type="password" id="overeni" name="overeni">
        <?php if(!$nestejne_heslo): ?>
            <em>Heslo se musí shodovat.</em>
        <?php endif; ?>


    </div>

    <div>
        <button>Registrovat</button>
    </div>

</form>
</body>
</html>
