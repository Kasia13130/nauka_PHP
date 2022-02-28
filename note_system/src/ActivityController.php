<?php

declare(strict_types=1);

namespace Note;

require_once("src/Exception/ConfigurationException.php");

use Note\Request;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

require_once("PDOConnector.php");
require_once("View.php");

class ActivityController
{
    private const DEFAULT_ACTION = 'noteList';

    private static array $config = [];

    private PDOConnector $pdoConnector;
    private Request $request;
    private $view;

    // utworzenie metody statycznej
    public static function initConfig(array $config): void
    {
        // do wlasciwosci statycznych odwolujemy sie przez self
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
                
        $arrayViewParameters = [];        

        switch ($this->activitiesRecognition())
        {
            case 'createNote':
                $page = 'createNote';     
                
                if ($this->request->postData())
                {   
                    $noteData = [
                        'title' => $this->request->postRequestParam('title'),
                        'description' => $this->request->postRequestParam('description')
                    ];
                    $this->pdoConnector->createNote($noteData);
                    header("Location: ./?before=createdNote");
                    exit;
                }

                break;
        
            case 'showNote':
                $page = 'showNote';

                $noteId = (int) $this->request->getRequestParam('id');
              
                if (!$noteId)
                {
                    header("Location: ./?error=missingNoteId");
                    exit;
                }

                try
                {
                    $note = $this->pdoConnector->getNote($noteId);
                }
                catch (NotFoundException $e)
                {
                    header("Location: ./?error=noteNotFound");
                    exit;
                }
                
                $arrayViewParameters = [
                    'note' => $note
                ];
                break;
                
            default:

                $page = 'noteList';

                $arrayViewParameters = [
                    'notes' => $this->pdoConnector->getNotes(),
                    'before' => $this->request->getRequestParam('before'),
                    'error' => $this->request->getRequestParam('error')
                ];
                break;
        }

        $this->view->render($page, $arrayViewParameters ?? []);
    }

    // rozpozanie czynnosci 
    private function activitiesRecognition(): string
    {
        return $this->request->getRequestParam('action', self::DEFAULT_ACTION);
    }
   
}
