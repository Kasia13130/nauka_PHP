<?php

declare(strict_types=1);

namespace Note;

require_once("AbstractActivityController.php");

use Note\Exception\NotFoundException;

class ActivityNoteController extends AbstractActivityController
{
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
}
