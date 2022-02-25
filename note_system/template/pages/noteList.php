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
                        <th>Data</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="1" cellspacing="1" border="0.5">
                <tbody>
                    <?php foreach ($viewParameters['notes'] ?? [] as $note) : ?>
                        <tr>
                            <td><?php echo (int) $note['id']; ?></td>
                            <td><?php echo htmlentities($note['title']); ?></td>
                            <td><?php echo htmlentities($note['create_date']); ?></td>
                            <td>
                                <a href="./?action=showNote&id=<?php echo (int) $note['id']; ?>">Wyświetl notatkę</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </section>
</div>