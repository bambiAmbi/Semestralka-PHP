<?php

if(isset($_POST['submit'])) {

        $nazev_souboru = $_FILES['files']['name'];
        $id = 5;
        $cilovy_soubor = './uploads/'.$nazev_souboru[0];
        $typ_souboru = pathinfo(
                $cilovy_soubor, PATHINFO_EXTENSION);
        $typ_souboru = strtolower($typ_souboru);
        $cilovy_soubor = './uploads/'.$id.'.'.$typ_souboru;

            // Upload file
            move_uploaded_file(
                $_FILES['files']['tmp_name'][0],
                $cilovy_soubor);
    }

    echo "File upload successfully";

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
</body>

</html>