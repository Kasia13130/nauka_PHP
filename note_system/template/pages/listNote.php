<div class="listNotes">
    <section>
        <div class="noteMessage">
            <?php if (!empty($viewParameters['error'])) {
                switch ($viewParameters['error']) {
                    case 'missingNoteId':
                        echo 'Brakuje identyfikatora notatki';
                        break;
                    case 'noteNotFound':
                        echo 'Nie znaleziono notatki';
                        break;
                }
            } ?>
        </div>

        <div class="noteMessage">
            <?php if (!empty($viewParameters['before'])) {
                switch ($viewParameters['before']) {
                    case 'createdNote':
                        echo 'Utworzono notatkę';
                        break;
                    case 'editedNote':
                        echo 'Notatka została zaktualizowana';
                        break;
                    case 'deletedNote':
                        echo 'Notatka została usunięta';
                        break;
                }
            } ?>
        </div>

        <?php  
            $sortType = $viewParameters['sort'] ?? [];
            $bySort = $sortType['by'] ?? 'title';
            $orderSort = $sortType['order'] ?? 'create_date';

            $page = $viewParameters['page'] ?? [];
            $pageSize = $page['pageSize'] ?? 10;
            $pageNumber = $page['pageNumber'] ?? 1;
        ?>

        <div>
            <form class="settings-form" action="./" method="GET">
                <div>
                    <div>Sortuj według: </div>
                    <label><input name="sortby" type="radio" value="title" <?php echo $bySort === 'title' ? 'checked' : '' ?> />Tytułu </label>
                    <label><input name="sortby" type="radio" value="create_date" <?php echo $bySort === 'create_date' ? 'checked' : '' ?> />Daty utworzenia </label>

                    <div>Typ sortowania</div>
                    <label><input name="sortorder" type="radio" value="asc" <?php echo $orderSort === 'asc' ? 'checked' : '' ?> />Rosnąco </label>
                    <label><input name="sortorder" type="radio" value="desc" <?php echo $orderSort === 'desc' ? 'checked' : '' ?> />Malejąco </label>
                </div>
                <div>
                    <div>Rozmiar notatki</div>
                    <label><input name="pageSize" type="radio" value="1" <?php echo $pageSize === 1 ? 'checked' : '' ?> /> 1  </label>
                    <label><input name="pageSize" type="radio" value="5" <?php echo $pageSize === 5 ? 'checked' : '' ?> /> 5  </label>
                    <label><input name="pageSize" type="radio" value="10" <?php echo $pageSize === 10 ? 'checked' : '' ?> /> 10  </label>
                    <label><input name="pageSize" type="radio" value="15" <?php echo $pageSize === 15 ? 'checked' : '' ?> />15  </label>
                </div>
                <input type="submit" value="Wybierz" />
            </form>
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
                            <td><?php echo $note['id']; ?></td>
                            <td><?php echo $note['title']; ?></td>
                            <td><?php echo $note['create_date']; ?></td>
                            <td>
                                <a href="./?action=showNote&id=<?php echo $note['id']; ?>">
                                    <button>Wyświetl notatkę</button>
                                </a>
                                <a href="./?action=deleteNote&id=<?php echo $note['id']; ?>">
                                    <button>Usuń notatkę</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </section>
</div>