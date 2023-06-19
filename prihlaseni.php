<?php

$validni_prihlaseni = false;

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $db = require __DIR__ . "/databaze.php";

    $sql = sprintf("SELECT * FROM USER
            WHERE EMAIL= %s", $db->quote($_POST["email"]));
    $vysledek = $db->query($sql);
    $user = $vysledek->fetch(PDO::FETCH_ASSOC);

    if($user) {
        if(password_verify($_POST["heslo"], $user["HASH_HESLO"])) {
            session_start();
            session_regenerate_id();

            $_SESSION["id_uzivatele"] = $user["ID"];
            $user_id = $_SESSION["id_uzivatele"];

            if($user_id == 14) {
                header("Location: admin_panel.php");
                exit;
            } else {
                header("Location: index2.html");
                exit;
            }
        }
    }

    $validni_prihlaseni = true;

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holiday.css@0.11.0" />
</head>
<body>
<h1>Přihlášení</h1>

<?php if($validni_prihlaseni): ?>
    <em>Nesprávné příhlášení</em>
<?php endif; ?>

<form method="post">
    <div>
    <label for="email">email</label>
    <input type="email" name="email" id="email"
    value="<?= htmlspecialchars($_POST["email"] ?? "")?>">
    </div>
    <div>
    <label for="heslo">heslo</label>
    <input type="password" name="heslo" id="heslo">
    </div>

    <button>Příhlásit se</button>

</form>
</body>
</html>