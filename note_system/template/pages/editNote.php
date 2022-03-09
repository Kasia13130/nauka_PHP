<div>
    <h4>Edytowanie notatki</h4>
    <div>
        <?php if (!empty($viewParameters)) : ?>
        <?php  $note = $viewParameters['note']; ?>
        <form class="note-form" action="./?action=editNote" method="post">
            <input name="id" type="hidden" value="<?php echo $note['id']; ?>">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" class="field-long" value="<?php echo $note['title']; ?>" />
                </li>
                <li>
                    <label>Zawartość notatki</label>
                    <textarea name="description" id="fields" class="field-long field-textarea" ><?php echo $note['description']; ?></textarea>
                </li>
                <li>
                    <input type="submit" value="Submit" />
                </li>
            </ul>
        </form>
        <?php else : ?>
        <div>
            Notatka nie zawiera danych do wyświetlenia
            <a href="./"><button>Powrót do listy notatek</button></a>
        </div>
        <?php endif; ?>
    </div>
</div>
