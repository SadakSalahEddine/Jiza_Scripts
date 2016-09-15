<?php

session_start();
function __autoload($class_name) {
    include_once 'connexion.php';
    include_once($class_name . '.php');
    
}

