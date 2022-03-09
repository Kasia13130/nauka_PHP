<?php

declare(strict_types=1);

namespace Note\Controller;

use Note\Exception\NotFoundException;

class ActivityNoteController extends AbstractActivityController
{
    public function createNoteAction(): void
    {

        if ($this->request->postData()) {
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

    public function showNoteAction(): void
    {
        $this->view->render('showNote', ['note' => $this->getNoteData()]);
    }

    public function listNoteAction(): void
    {
        $this->view->render('listNote', [
            'notes' => $this->pdoConnector->getNotes(),
            'before' => $this->request->getRequestParam('before'),
            'error' => $this->request->getRequestParam('error')
        ]);
    }

    public function editNoteAction(): void
    {
        if ($this->request->isPostDataServer()) {

            $idNote = (int) $this->request->postRequestParam('id');

            $noteData = [
                'title' => $this->request->postRequestParam('title'),
                'description' => $this->request->postRequestParam('description')
            ];
            $this->pdoConnector->editNote($idNote, $noteData);
            $this->pageRedirect('./', ['before' => 'editedNote']);
        }

        $this->view->render('editNote', ['note' => $this->getNoteData()]);
    }

    public function deleteNoteAction(): void
    {   
        if ($this->request->isPostDataServer())
        {
            $idNote = (int) $this->request->postRequestParam('id');
            $this->pdoConnector->deleteNote($idNote);

            $this->pageRedirect('./', ['before' => 'deletedNote']);
        }

        $this->view->render('deleteNote', ['note' => $this->getNoteData()]);
    }

    private function getNoteData(): array
    {
        $idNote = (int) $this->request->getRequestParam('id');

        if (!$idNote) {

            $this->pageRedirect('./', ['error' => 'missingNoteId']);
        }            

        try {
            $note = $this->pdoConnector->getNote($idNote);
        } 
        catch (NotFoundException $e) 
        {
            $this->pageRedirect('./', ['error' => 'noteNotFound']);
        }

        return $note;
    }
}
