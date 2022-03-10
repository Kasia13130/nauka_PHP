<?php 

declare(strict_types=1);

namespace Note;

class View
{
    public function render(string $page, array $viewParameters = []): void
    {
        $viewParameters = $this->escapeHelper($viewParameters);
        require_once("template/layout.php");    
    }

    private function escapeHelper(array $viewParameters): array
    {
        $clearViewParameters = [];        

        foreach ($viewParameters as $key => $viewParameter)
        {
            switch (true)
            {
                case is_array($viewParameter):
                    $clearViewParameters[$key] = $this->escapeHelper($viewParameter);
                    break;
                case is_int($viewParameter):
                    $clearViewParameters[$key] = $viewParameter;
                    break;
                case $viewParameter:
                    $clearViewParameters[$key] = htmlentities($viewParameter);
                    break;
                default:
                    $clearViewParameters[$key] = $viewParameter;
                    break;
            }            
        }

        return $clearViewParameters;
    }
}