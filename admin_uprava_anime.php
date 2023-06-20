<?php

session_start();
$id_uzivatele = htmlspecialchars($_SESSION["id_uzivatele"]);
$validni_post = false;
$validni_jmeno = true;
$validni_jp_jmeno = true;
$validni_pocet_epizod = true;
$validni_pocet_serii = true;
$validni_popis_anime = true;


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

if(isset($_POST['submit'])){
    if (empty($_POST["nazev_eng"])) {
        $validni_jmeno = false;
    }

    if (empty($_POST["nazev_jp"])) {
        $validni_jp_jmeno = false;
    }

    if (empty($_POST["pocet_ep"])) {
        $validni_pocet_epizod = false;
    } else if($_POST["pocet_ep"] <= 0) {
        $validni_pocet_epizod = false;
    }

    if (empty($_POST["pocet_s"])) {
        $validni_pocet_serii = false;
    } else if($_POST["pocet_s"] <= 0) {
        $validni_pocet_serii = false;
    }

    if (empty($_POST["popis"])) {
        $validni_popis_anime = false;
    }


    if($validni_jmeno && $validni_jp_jmeno && $validni_pocet_epizod && $validni_pocet_serii && $validni_popis_anime){
        $validni_post = true;
    }
    if($validni_post) {
        $id = htmlspecialchars($_GET['id']);
        $sql_puvodni_soubor="SELECT OBRAZEK_CESTA FROM ANIME WHERE ID = $id";
        $vysledek_souboru = $db->query($sql_puvodni_soubor);
        $vybrana_cesta = $vysledek_souboru->fetch(PDO::FETCH_ASSOC);
        $stara_cesta = $vybrana_cesta['OBRAZEK_CESTA'];

        unlink($stara_cesta);


        $nazev_souboru = $_FILES['files']['name'];
        $cilovy_soubor = './uploads/'.$nazev_souboru[0];
        $typ_souboru = pathinfo(
            $cilovy_soubor, PATHINFO_EXTENSION);
        $typ_souboru = strtolower($typ_souboru);
        $cilovy_soubor = './uploads/'.$id.'.'.$typ_souboru;

        // Upload file
        move_uploaded_file($_FILES['files']['tmp_name'][0], $cilovy_soubor);


        $data = [
            'NAZEV_ENG' => htmlspecialchars($_POST["nazev_eng"]),
            'NAZEV_JP' => htmlspecialchars($_POST["nazev_jp"]),
            'POCET_EPIZOD' => htmlspecialchars($_POST["pocet_ep"]),
            'POCET_SERII' => htmlspecialchars($_POST["pocet_s"]),
            'POPIS' => htmlspecialchars($_POST["popis"]),
            'OBRAZEK_CESTA' => htmlspecialchars($cilovy_soubor)

        ];

        $sql = "UPDATE ANIME SET 
                 NAZEV_ENG = :NAZEV_ENG, 
                 NAZEV_JP = :NAZEV_JP,
                 POCET_EPIZOD = :POCET_EPIZOD,
                 POCET_SERII = :POCET_SERII,
                 POPIS = :POPIS,
                 OBRAZEK_CESTA = :OBRAZEK_CESTA
                 WHERE ID LIKE $id";
        $statement = $db->prepare($sql);
        $statement->execute($data);


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
    }
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
          <form method='post' action=''
                enctype='multipart/form-data'>
              <div class="pridani">
                  <div>
                      <label for="nazev_eng">Název v angličtině</label>
                      <input type="text" name="nazev_eng" id="nazev_eng" value="<?= htmlspecialchars($vybrane_anime['NAZEV_ENG'] ?? "")?>">
                      <?php if(!$validni_jmeno): ?>
                          <em>Musíte zadat anglický název anime</em>
                      <?php endif; ?>
                  </div>

                  <div>
                      <label for="nazev_jp">Název v japonštině</label>
                      <input type="text" name="nazev_jp" id="nazev_jp" value="<?= htmlspecialchars($vybrane_anime['NAZEV_JP'] ?? "")?>">
                      <?php if(!$validni_jp_jmeno): ?>
                          <em>Musíte zadat japonský název anime</em>
                      <?php endif; ?>
                  </div>

                  <div>
                      <label for="pocet_ep">Počet epizod</label>
                      <input type="number" name="pocet_ep" id="pocet_ep" value="<?= htmlspecialchars($vybrane_anime['POCET_EPIZOD'] ?? "")?>">
                      <?php if(!$validni_pocet_epizod): ?>
                          <em>Počet epizod musí být větší než 0</em>
                      <?php endif; ?>
                  </div>

                  <div>
                      <label for="pocet_s">Počet sezon</label>
                      <input type="number" name="pocet_s" id="pocet_s" value="<?= htmlspecialchars($vybrane_anime['POCET_SERII'] ?? "")?>">
                      <?php if(!$validni_pocet_serii): ?>
                          <em>Počet sérií musí být větší než 0</em>
                      <?php endif; ?>
                  </div>

                  <div>
                      <label for="popis">Popis anime</label>
                      <br>
                      <textarea id="popis" name="popis" rows="6" cols="50"><?= htmlspecialchars($vybrane_anime['POPIS'] ?? "")?></textarea>
                      <br/>
                      <?php if(!$validni_popis_anime): ?>
                          <em>Musíte zadat popis anime</em>
                      <?php endif; ?>
                  </div>

                  <div>
                      <input type="hidden" name="id" id="id" value="<?php echo $id?>"
                  </div>

                  <div>
                      <label for="image">Název obrázku</label>
                      <input type='file' name='files[]' accept="image/png, image/jpeg" required/>
                      <input type='submit' value='Přidat' name='submit' />
                  </div>
              </div>
          </form>
          <?php endif; ?>
      </div>

  </div>
</div>
</body>
</html>