<?php

declare(strict_types=1);

namespace Note\Controller;

class ActivityNoteController extends AbstractActivityController
{
    private const PAGE_SIZE = 15;

    public function createNoteAction(): void
    {

        if ($this->request->postData()) {
            $noteData = [
                'title' => $this->request->postRequestParam('title'),
                'description' => $this->request->postRequestParam('description')
            ];
            $this->pdoNoteModel->create($noteData);
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
        $searchPhrase = $this->request->getRequestParam('searchPhrase');
        $pageNumber = (int) $this->request->getRequestParam('page', 1);
        $pageSize = (int) $this->request->getRequestParam('pageSize', self::PAGE_SIZE);
        $bySort = $this->request->getRequestParam('sortby', 'title');
        $orderSort = $this->request->getRequestParam('sortorder', 'desc');

        if (!in_array($pageSize, [1, 5, 10, 15]))
        {
            $pageSize = self::PAGE_SIZE;
        }

        if ($searchPhrase)
        {
            $notesToDisplay = $this->pdoNoteModel->search($searchPhrase, $pageNumber, $pageSize, $bySort, $orderSort);
            $allNotesCount = $this->pdoNoteModel->searchCount($searchPhrase);
        }
        else
        {
            $notesToDisplay = $this->pdoNoteModel->list($pageNumber, $pageSize, $bySort, $orderSort);
            $allNotesCount = $this->pdoNoteModel->count();
        }  
        
        $this->view->render('listNote', [
            'page' => [
                'pageNumber' => $pageNumber, 
                'pageSize' => $pageSize, 
                'numberOfPages' => (int) ceil($allNotesCount / $pageSize)
            ],
            'searchPhrase' => $searchPhrase,
            'sort' => ['by' => $bySort, 'order' => $orderSort],
            'notes' => $notesToDisplay,
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
            $this->pdoNoteModel->edit($idNote, $noteData);
            $this->pageRedirect('./', ['before' => 'editedNote']);
        }

        $this->view->render('editNote', ['note' => $this->getNoteData()]);
    }

    public function deleteNoteAction(): void
    {   
        if ($this->request->isPostDataServer())
        {
            $idNote = (int) $this->request->postRequestParam('id');
            $this->pdoNoteModel->delete($idNote);

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

        return $this->pdoNoteModel->get($idNote);       
    }
}
