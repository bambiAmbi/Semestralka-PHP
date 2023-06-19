<?php

session_start();
$db = require __DIR__ . "/databaze.php";
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Domovská stránka</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holiday.css@0.11.0" />
    <link rel="stylesheet" type="text/css" href="admin_panel_style.css">
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

        <form action="" method="get">
            <div class="wrap">
                <div class="hledat">
                    <input type="text" name="vyhledej" class="searchTerm" placeholder="Vyhledej anime, které tě zajímá" value="<?php if(isset($_GET['vyhledej'])){echo $_GET['vyhledej']; } ?>">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

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

                if(isset($_GET['vyhledej'])) {
                    $filtr = htmlspecialchars($_GET['vyhledej']);
                    $sql_2 = "SELECT JMENO, ID FROM USER WHERE ID NOT IN (SELECT PRITEL_ID FROM PRATELE WHERE USER_ID=$id_uzivatele) AND ID NOT LIKE $id_uzivatele AND CONCAT(JMENO) LIKE '%$filtr%' ";
                    $vysledek = $db->query($sql_2);


                    if($vysledek->rowCount() > 0) {

                        foreach ($vysledek as $polozka) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($polozka['JMENO'])?></td>
                                <td>0</td>
                                <td>0</td>
                                <td>
                                    <form action="pridat_do_pratel.php" method="post">
                                        <input type="hidden" id="user_id" name="user_id" value=<?php echo $_SESSION['id_uzivatele']?>>
                                        <input type="hidden" id="pritel_id" name="pritel_id" value=<?php echo $polozka['ID']?>>
                                        <button>Přidat</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }

                    } else {
                        ?>
                        <tr>
                            <td>Nebyli nalezeni žádní uživatelé</td>
                        </tr>
                        <?php
                    }
                }
                ?>

                </tbody>
            </table>
            <?php endif; ?>

        </main>

    </div>
</div>
</body>
</html>