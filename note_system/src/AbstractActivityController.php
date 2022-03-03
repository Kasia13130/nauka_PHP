<?php

declare(strict_types=1);

namespace Note;

require_once("src/Exception/ConfigurationException.php");
require_once("PDOConnector.php");
require_once("View.php");

abstract class AbstractActivityController
{
    protected const DEFAULT_ACTION = 'listNote';

    private static array $config = [];

    protected PDOConnector $pdoConnector;
    protected Request $request;
    protected $view;

    public static function initConfig(array $config): void
    {
        self::$config = $config;
    }

    public function __construct(Request $request)
    {
        if (empty(self::$config['database'])) {
            throw new ConfigurationException('Configuration error');
        }
        $this->pdoConnector = new PDOConnector(self::$config['database']);
        
        $this->request = $request;
        $this->view = new View();
    }

    public function runApp(): void
    {
        $activitiesRecognition = $this->activitiesRecognition() . 'Action';

        if (!method_exists($this, $activitiesRecognition))
        {
            $activitiesRecognition = self::DEFAULT_ACTION . 'Action';
        }
        $this->$activitiesRecognition();
                
    }

    private function activitiesRecognition(): string
    {
        return $this->request->getRequestParam('action', self::DEFAULT_ACTION);
    }
}
