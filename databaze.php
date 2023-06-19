<?php

/** @var \PDO $db - připojení k databázi */
$db = new PDO("mysql:host=127.0.0.1;dbname=ambr00;charset=utf8", "ambr00", "Jee7ohbeikoso4ohch");
//TODO nezapomeňte v předchozím řádku zadat své xname a heslo k databázi

//při chybě v SQL chceme vyhodit Exception
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

return $db;
