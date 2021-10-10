<div>
    <h4>Nowa notatka</h4>
    <div>
        <?php if($viewParameters['created']): ?>
        <div>
            <div>Tytuł notatki: <?php echo $viewParameters['title'] ?></div>
            <div>Zawartość notatki: <?php echo $viewParameters['description'] ?></div>
        </div>
        <?php else: ?>
        <form class="note-form" action="./?action=createNote" method="post">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" class="field-long" />
                </li>
                <li>
                    <label>Zawartość notatki</label>
                    <textarea name="description" id="fields" class="field-long field-textarea"></textarea>
                </li>
                <li>
                    <input type="submit" value="Submit" />
                </li>
            </ul>
        </form>
        <?php endif; ?>
    </div>
</div>
