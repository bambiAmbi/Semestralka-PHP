<?php

session_start();
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);

if($id_uzivatele != 14) {
    header("Location: index2.html");
}

$db = require __DIR__ . "/databaze.php";

if(isset($_GET['id'])) {

    $id = htmlspecialchars($_GET['id']);
    $sql_anime = "SELECT * FROM ANIME WHERE ID = $id";
    $vysledek_anime = $db->query($sql_anime);
    $vybrane_anime = $vysledek_anime->fetch(PDO::FETCH_ASSOC);

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin panel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holiday.css@0.11.0" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
  <link rel="stylesheet" type="text/css" href="admin_panel_style.css">
</head>
<body>
<div class="main">
  <div class="menu">
    <h2 id="nazev">AniTrack</h2>
    <a href="admin_panel.php">Domů</a>
    <a href="admin_pridani_anime.php">Přidat anime</a>
    <a href="admin_uprava_anime.html">Upravit anime</a>
    <a href="odhlaseni.php">Odhlásit se</a>
  </div>

  <div class="body">
    <h1>Admin panel</h1>
    <h2>Úprava anime</h2>
    <p>Zde můžete upravit anime, které vyhledáte a vyberete.</p>
    <form action="" method="get">
    <div class="wrap">
      <div class="hledat">
        <input type="text" name="vyhledej" class="searchTerm" placeholder="Vyhledej anime, které chceš upravit" value="<?php if(isset($_GET['vyhledej'])){echo $_GET['vyhledej']; } ?>">
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
                  <th>Název CZ</th>
                  <th>Název JP</th>
                  <th>Počet epizod</th>
                  <th>Počet sezon</th>
              </tr>
              </thead>

              <tbody>
                <?php

                if(isset($_GET['vyhledej'])) {
                    $filtr = htmlspecialchars($_GET['vyhledej']);
                    $sql = "SELECT * FROM ANIME WHERE CONCAT(NAZEV_ENG, NAZEV_JP) LIKE '%$filtr%'";
                    $vysledek = $db->query($sql);


                    if($vysledek->rowCount() > 0) {

                        foreach ($vysledek as $polozka) {
                            ?>
                            <tr>
                                <td><a href="admin_uprava_anime.php?id=<?=$polozka['ID']?>"><?= $polozka['NAZEV_ENG']?></a></td>
                                <td><?= htmlspecialchars($polozka['NAZEV_JP'])?></td>
                                <td><?= htmlspecialchars($polozka['POCET_EPIZOD'])?></td>
                                <td><?= htmlspecialchars($polozka['POCET_SERII'])?></td>
                            </tr>
                            <?php
                        }

                    } else {
                        ?>
                            <tr>
                                <td>Nebylo nalezeno žádné anime</td>
                            </tr>
                        <?php
                    }
                }
                ?>

              </tbody>
          </table>
          <?php endif; ?>


          <?php if (isset($_GET['id'])): ?>
          <form method="post" action="upravit_anime.php">
              <div class="pridani">
                  <div>
                      <label for="nazev_eng">Název v angličtině</label>
                      <input type="text" name="nazev_eng" id="nazev_eng" value="<?= htmlspecialchars($vybrane_anime['NAZEV_ENG'] ?? "")?>">
                  </div>

                  <div>
                      <label for="nazev_jp">Název v japonštině</label>
                      <input type="text" name="nazev_jp" id="nazev_jp" value="<?= htmlspecialchars($vybrane_anime['NAZEV_JP'] ?? "")?>">
                  </div>

                  <div>
                      <label for="pocet_ep">Počet epizod</label>
                      <input type="number" name="pocet_ep" id="pocet_ep" value="<?= htmlspecialchars($vybrane_anime['POCET_EPIZOD'] ?? "")?>">
                  </div>

                  <div>
                      <label for="pocet_s">Počet sezon</label>
                      <input type="number" name="pocet_s" id="pocet_s" value="<?= htmlspecialchars($vybrane_anime['POCET_SERII'] ?? "")?>">
                  </div>

                  <div>
                      <label for="popis">Popis anime</label>
                      <br>
                      <textarea id="popis" name="popis" rows="6" cols="50"><?= htmlspecialchars($vybrane_anime['POPIS'] ?? "")?></textarea>
                      <br/>
                  </div>

                  <div>
                      <input type="hidden" name="id" id="id" value="<?php echo $id?>"
                  </div>

                  <div>
                      <label for="obrazek">Náhledový obrázek</label>
                      <input type="file" name="obrazek" id="obrazek" accept="image/png, image/jpeg, image/jpg"  value="<?= htmlspecialchars($vybrane_anime['OBRAZEK'] ?? "")?>">

                      <button>Přidat</button>
                  </div>
              </div>
          </form>
          <?php endif; ?>
      </div>

  </div>
</div>
</body>
</html>