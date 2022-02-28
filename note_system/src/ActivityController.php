<?php

declare(strict_types=1);

namespace Note;

require_once("src/Exception/ConfigurationException.php");
require_once("PDOConnector.php");
require_once("View.php");

use Note\Request;
use Note\Exception\ConfigurationException;
use Note\Exception\NotFoundException;

class ActivityController
{
    private const DEFAULT_ACTION = 'listNote';

    private static array $config = [];

    private PDOConnector $pdoConnector;
    private Request $request;
    private $view;

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

    public function createNoteAction()
    {
                
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

        $this->view->render('createNote');
    }

    public function showNoteAction()
    {

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
        
        $this->view->render('showNote', ['note' => $note]);
    }

    public function listNoteAction()
    {
        $this->view->render('listNote', [
            'notes' => $this->pdoConnector->getNotes(),
            'before' => $this->request->getRequestParam('before'),
            'error' => $this->request->getRequestParam('error')
        ]);
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
