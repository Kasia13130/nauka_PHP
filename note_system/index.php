<?php

declare(strict_types=1); 

spl_autoload_register(function(string $classNamespace)
{
    $path = str_replace(['\\', 'Note/'], ['/', ''], $classNamespace);
    $path = "src/$path.php";
    require_once($path);
});

use Note\Request;
use Note\Controller\AbstractActivityController;
use Note\Controller\ActivityNoteController;
use Note\Exception\AppExcepttion;
use Note\Exception\ConfigurationException;

require_once("src/Utils/debug.php");

$config = require_once("config/config.php");

$request = new Request($_GET, $_POST, $_SERVER);

try {

AbstractActivityController::initConfig($config);
(new ActivityNoteController($request))->runApp();

} catch (ConfigurationException $e) {
    echo '<h3>Błąd w aplikacji</h3>';
    echo 'Skontaktuj się z administratorem';
} catch (AppExcepttion $e) {
    echo '<h3>Błąd w aplikacji</h3>';
    echo '<h3>' . $e->getMessage() . '</h3>';
} catch (\Throwable $e) {    
    echo '<h3>Błąd w aplikacji</h3>';
    debuging($e);
}    