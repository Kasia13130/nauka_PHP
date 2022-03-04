<div>
    <h4>Edytowanie notatki</h4>
    <div>
        <form class="note-form" action="./?action=editNote" method="post">
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
    </div>
</div>
