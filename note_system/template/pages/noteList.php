<div class="listNotes">
    <section>
        <div class="noteMessage">
            <?php if (!empty($viewParameters['before'])) {
                switch ($viewParameters['before']) {
                    case 'createdNote':
                        echo 'Utworzono notatkę';
                        break;
                }
            } ?>
        </div>

        <div class="tbl-header">
            <table cellpadding="1" cellspacing="1" border="0.5">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tytuł</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="1" cellspacing="1" border="0.5">
                <tbody>

                </tbody>
            </table>

        </div>
    </section>
</div>