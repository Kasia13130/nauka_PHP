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
            if (is_array($viewParameter))
            {
                $clearViewParameters[$key] = $this->escapeHelper($viewParameter);
            }
            else if ($viewParameter)
            {
                $clearViewParameters[$key] = htmlentities($viewParameter);
            }
            else
            {
                $clearViewParameters[$key] = $viewParameter;
            }
            
        }

        return $clearViewParameters;
    }
}