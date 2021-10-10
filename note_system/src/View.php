<?php 

declare(strict_types=1);

namespace Note;

class View
{
    public function render(string $page, array $viewParameters): void
    {
        // debuging($viewParameters);
        // echo 'xxxxxxx';
        require_once("template/layout.php");                // to co znajduje sie w pliku jest wstrzykiwane do wnetrza metody
        
            
    }
}