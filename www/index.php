<?php

use core\Routing;
require 'conf.inc.php';

function myAutoloader($class)
{

    $classname = substr($class, strpos($class , '\\') + 1);
    // $classController = 'controllers'.$classname.'.class.php';
    $classPath = 'core/'.$classname.'.php';
    $classModel = 'models/'.$classname.'.php';
    if (file_exists($classPath)) {
        include $classPath;
    } elseif (file_exists($classModel)) {
        include $classModel;
    }
}

// La fonction myAutoloader est lancé sur la classe appelée n'est pas trouvée
spl_autoload_register('myAutoloader');

// Récupération des paramètres dans l'url - Routing
$slug = explode('?', $_SERVER['REQUEST_URI'])[0];
$routes = Routing::getRoute($slug);
extract($routes);

$container = [];
$container['config'] = require 'config/global.php';
$container += require 'config/di.global.php';

// Vérifie l'existence du fichier et de la classe pour charger le controlleur
if (file_exists($cPath)) {
    include $cPath;
    if (class_exists('\\controllers\\'.$c)) {
        //instancier dynamiquement le controller
        $cObject = $container['controllers\\'.$c]($container);
        //vérifier que la méthode (l'action) existe
        if (method_exists($cObject, $a)) {
            //appel dynamique de la méthode
            $cObject->$a();
        } else {
            die('La methode '.$a." n'existe pas");
        }
    } else {
        die('La class controller '.$c." n'existe pas");
    }
} else {
    die('Le fichier controller '.$c." n'existe pas");
}
