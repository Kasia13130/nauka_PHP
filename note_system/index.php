<?php

declare(strict_types=1); 

namespace Note;                          

use Note\Exception\AppExcepttion;
use Note\Exception\ConfigurationException;
use Throwable;
use Note\Request;

require_once("src/Utils/debug.php");
require_once("src/ActivityController.php");
require_once("src/Exception/AppException.php");
require_once("src/Request.php");

$config = require_once("config/config.php");

$request = new Request($_GET, $_POST);

try {

// wywolanie metody konfiguracyjnej
ActivityController::initConfig($config);

// szybsze wywolanie metody runApp()
(new ActivityController($request))->runApp();

} catch (ConfigurationException $e) {
    echo '<h3>Błąd w aplikacji</h3>';
    echo 'Skontaktuj się z administratorem';
} catch (AppExcepttion $e) {
    echo '<h3>Błąd w aplikacji</h3>';
    echo '<h3>' . $e->getMessage() . '</h3>';
} catch (Throwable $e) {    
    echo '<h3>Błąd w aplikacji</h3>';
    debuging($e);
}    