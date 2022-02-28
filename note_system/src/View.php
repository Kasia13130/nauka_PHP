<?php 

declare(strict_types=1);

namespace Note;

class View
{
    public function render(string $page, array $viewParameters = []): void
    {
        require_once("template/layout.php");    
    }
}