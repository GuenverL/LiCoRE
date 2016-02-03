<?php

$mysql = true;

// Connexion a la base de donnees
if($mysql) {
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=licorebdd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
}
else {
    try {
        $bdd = new PDO('sqlite:'.$_SERVER['DOCUMENT_ROOT'].'/Projet_Licore/Bdd/licorebdd.sqlite');
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
    } catch(Exception $e) {
        echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
        die();
    }
}
