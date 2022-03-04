<?php

declare(strict_types=1);

namespace Note\Controller;

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
            $this->pageRedirect('./', ['before' => 'createdNote']);
            exit;
        }

        $this->view->render('createNote');
    }

    public function showNoteAction()
    {

        $noteId = (int) $this->request->getRequestParam('id');
      
        if (!$noteId)
        {
            $this->pageRedirect('./', ['error' => 'missingNoteId']);
            exit;
        }

        try
        {
            $note = $this->pdoConnector->getNote($noteId);
        }
        catch (NotFoundException $e)
        {
            $this->pageRedirect('./', ['error' => 'noteNotFound']);
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
    
    public function editNoteAction()
    {
        $idNote = (int) $this->request->getRequestParam('id');
        if (!$idNote)
        {
            $this->pageRedirect('./', ['error' => 'missingNoteId']);
        }
        $this->view->render('editNote');
    }
}
