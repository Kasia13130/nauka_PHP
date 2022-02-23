<?php

declare(strict_types=1);

namespace Note;

require_once("src/Exception/ConfigurationException.php");

use App\Exception\ConfigurationException;

require_once("PDOConnector.php");
require_once("View.php");

class ActivityController
{
    private const DEFAULT_ACTION = 'noteList';

    private static array $config = [];

    private $request;
    private $view;

    // utworzenie metody statycznej
    public static function initConfig(array $config): void
    {
        // do wlasciwosci statycznych odwolujemy sie przez self
        self::$config = $config;
    }

    public function __construct(array $request)
    {
        if (empty(self::$config['database'])) {
            throw new ConfigurationException('Configuration error');
        }
        $database = new PDOConnector(self::$config['database']);
        
        $this->request = $request;
        $this->view = new View();

        // debuging(self::$config);
    }

    public function runApp(): void
    {
                
        $arrayViewParameters = [];        

        switch ($this->activitiesRecognition())
        {
            case 'createNote':
                $page = 'createNote';
                $noteCreated = false;
        
                $postData = $this->getRequestPost();
                if (!empty($postData))
                {   
                    $noteCreated = true;
                    $arrayViewParameters = [
                        'title' => $postData['title'],
                        'description' => $postData['description']
                    ];
                }
                $arrayViewParameters['created'] = $noteCreated;
                break;
        
            case 'showNote':
                $arrayViewParameters = [
                    'title' => 'Utworzona notatka',
                    'description' => 'Treść notatki'
                ];
                break;
                
            default:
                $page = 'noteList';
                $arrayViewParameters['resultListNotes'] = "wyświetlona lista notatek";
                break;
        }

        $this->view->render($page, $arrayViewParameters);
    }

    // metoda dostepowa do post
    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }

    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }

    // rozpozanie czynnosci 
    private function activitiesRecognition(): string
    {
        $getData = $this->getRequestGet();
        return $getData['action'] ?? self::DEFAULT_ACTION;
    }
}
