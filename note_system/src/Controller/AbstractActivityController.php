<?php

declare(strict_types=1);

namespace Note\Controller;

use Note\Request;
use Note\Model\PDONoteModel;
use Note\View;
use Note\Exception\ConfigurationException;
use Note\Exception\StorageException;

abstract class AbstractActivityController
{
    protected const DEFAULT_ACTION = 'listNote';

    private static array $config = [];

    protected PDONoteModel $pdoNoteModel;
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
        $this->pdoNoteModel = new PDONoteModel(self::$config['database']);
        
        $this->request = $request;
        $this->view = new View();
    }

    final public function runApp(): void
    {
        try {
            $activitiesRecognition = $this->activitiesRecognition() . 'Action';

            if (!method_exists($this, $activitiesRecognition))
            {
                $activitiesRecognition = self::DEFAULT_ACTION . 'Action';
            }
            $this->$activitiesRecognition();
            }

        catch (StorageException $e)
        {
            $this->view->render('errorNote', ['message' => $e->getMessage()]
            );
        }
        catch (NotFoundException $e) 
        {
            $this->pageRedirect('./', ['error' => 'noteNotFound']);
        }
    }

    final protected function pageRedirect(string $toPage, array $viewParameters): void
    {
        $locationPage = $toPage;

        if (count($viewParameters))
        {
            $queryParameters = [];

            foreach($viewParameters as $key => $viewParameter)
            {
                $queryParameters[] = urlencode($key) . '=' . urlencode($viewParameter);
            }

            $queryParameters = implode('&', $queryParameters);
            $locationPage .= '?' . $queryParameters;
        }

        header("Location: $locationPage");
        exit;
    }

    private function activitiesRecognition(): string
    {
        return $this->request->getRequestParam('action', self::DEFAULT_ACTION);
    }    
}
