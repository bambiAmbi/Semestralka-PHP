<?php
include "database_connection.php";

if(isset($_POST['submit'])) {

    $pocet_obrazku = count($_FILES['files']['name']);

    for($i = 0; $i < $pocet_obrazku; $i++) {

        // File name
        $nazev_souboru = $_FILES['files']['name'][$i];

        // Location
        $cilovy_soubor = './uploads/'.$nazev_souboru;

        // file extension
        $typ_souboru = pathinfo(
            $cilovy_soubor, PATHINFO_EXTENSION);

        $typ_souboru = strtolower($typ_souboru);

        // Valid image extension
        $spravny_typ = array("png","jpeg","jpg");

        if(in_array($typ_souboru, $spravny_typ)) {

            // Upload file
            if(move_uploaded_file(
                $_FILES['files']['tmp_name'][$i],
                $cilovy_soubor)
            ) {

            }
        }
    }

    echo "File upload successfully";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
    "width=device-width, initial-scale=1.0">
    <title>Geeks for geeks Image Upload</title>
</head>

<body>
<h1>Upload Images</h1>

<form method='post' action=''
      enctype='multipart/form-data'>
    <input type='file' name='files[]' />
    <input type='submit' value='Submit' name='submit' />
</form>

<a href="view.php">|View Uploads|</a>
</body>

</html>