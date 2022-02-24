<div>
    <div class="noteMessage">
        <?php if (!empty($viewParameters['before'])) {
            switch($viewParameters['before'])
            {
                case 'createdNote':
                    echo 'Utworzono notatkę';
                    break;
            }
        } ?>
    </div>
    
    <h3>lista notatek</h3>  
    <b><?php echo $viewParameters['resultListNotes'] ?? "" ?></b>
</div>
        