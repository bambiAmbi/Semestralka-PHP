<?php

session_start();
$db = require __DIR__ . "/databaze.php";
$id_uzivatele = htmlspecialchars($_SESSION['id_uzivatele']);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Domovská stránka</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holiday.css@0.11.0" />
    <link rel="stylesheet" type="text/css" href="admin_panel_style.css">
    <link rel="stylesheet" type="text/css" href="karta.css">
</head>
<body>
<div class="main2">
    <div class="menu">
        <h2 id="nazev">AniTrack</h2>
        <a href="index2.html">Domů</a>
        <a href="hledani_anime.php">Hledat anime</a>
        <a href="oblibene.php">Oblíbené</a>
        <a href="rozkoukane.php">Rozkoukané</a>
        <a href="pratele_vyhledavani.php">Přátelé</a>
        <a href="pratele.php">Vyhledat přítele</a>
        <a href="odhlaseni.php">Odhlásit se</a>
    </div>

    <div class="body">
        <h1>Přatelé</h1>


        <?php if (!isset($_GET['id'])): ?>
        <div class="tabulka">
            <table>
                <thead>
                <tr>
                    <th>Jméno přítele</th>
                    <th>Rozkoukané</th>
                    <th>Oblíbené</th>
                </tr>
                </thead>

                <tbody>
                <?php

                $id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);
                $sql = "SELECT USER.JMENO, USER.ID FROM `USER` RIGHT JOIN PRATELE ON USER.ID=PRATELE.PRITEL_ID WHERE PRATELE.USER_ID = $id_uzivatele; ";
                    $vysledek = $db->query($sql);


                    if($vysledek->rowCount() > 0) {

                        foreach ($vysledek as $polozka) {
                            $id_pritele = htmlspecialchars($polozka['ID']);
                            $sql_pocet_oblibeneych = "SELECT COUNT(USER_ID) FROM `OBLIBENE` WHERE USER_ID=$id_pritele; ";
                            $sql_pocet_rozkoukanych = "SELECT COUNT(USER_ID) FROM `OBLIBENE` WHERE USER_ID=$id_pritele; ";
                            $pocet_oblibenych= $db->query($sql_pocet_oblibeneych);
                            $pocet_rozkoukanych= $db->query($sql_pocet_rozkoukanych);
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($polozka['JMENO'])?></td>
                                <td><a href="pritel_rozkoukane.php?id=<?=htmlspecialchars($polozka['ID'])?>&jmeno=<?=htmlspecialchars($polozka['JMENO'])?>"><?= $pocet_oblibenych['COUNT(USER_ID)']?></a></td>
                                <td><a href="pritel_oblibene.php?id=<?=htmlspecialchars($polozka['ID'])?>&jmeno=<?=htmlspecialchars($polozka['JMENO'])?>">0</a></td>
                                <td>
                                    <form action="odebrat_pritele.php" method="post">
                                        <input type="hidden" id="user_id" name="user_id" value=<?php echo htmlspecialchars($_SESSION['id_uzivatele'])?>>
                                        <input type="hidden" id="pritel_id" name="pritel_id" value=<?php echo htmlspecialchars($polozka['ID'])?>>
                                        <button class="odebrat">Odebrat</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }

                    } else {
                        ?>
                        <tr>
                            <td>Nemáte žádné kamarády.</td>
                        </tr>
                        <?php
                }
                ?>

                </tbody>
            </table>
            <?php endif;?>

            </main>

        </div>
    </div>
</body>
</html>