<?php


function chargementAuto($class) {
   
    if(file_exists($fichier = __DIR__ . '/' . $class . '.php')) {

        require_once $fichier;

    }
}

spl_autoload_register('chargementAuto');




