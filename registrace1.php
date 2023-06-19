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
        <input type="text" id="jmeno" name="jmeno">
    <?php
    if(empty($_POST["jmeno"])) {
        die("Je nutné zadat jméno");
    }?>
    </div>

    <div>

        <label for="email">E-mail</label>
        <input type="text" id="email" name="email">

    </div>


    <div>

        <label for="heslo">Heslo</label>
        <input type="password" id="heslo" name="heslo">

    </div>

    <div>

        <label for="overeni">Heslo znovu</label>
        <input type="password" id="overeni" name="overeni">

        <button>Registrovat</button>

    </div>

</form>
</body>
</html>