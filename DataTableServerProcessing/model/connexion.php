<?php

define('SERVER','localhost');
define('DATABASE','gu001');
define('USER','root');
define('PASSWORD','');


class connexion {
    public static function getConnexion()
    {      
        try
        {
            $connexion = new PDO('mysql:host='.SERVER.';dbname='.DATABASE,USER, PASSWORD);
            $connexion->exec('SET NAMES utf8');
        }
        catch(Exception $e)
        {
            echo 'Erreur : '.$e->getMessage().'<br />';
            echo 'N° : '.$e->getCode();
        }
    return $connexion;
    }
}
