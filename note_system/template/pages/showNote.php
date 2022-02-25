<div class="showNote">
    <?php $note = $viewParameters['note'] ?? null; ?>
    <?php if ($note) : ?>
        <ul>
            <li>Nr notatki: <?php echo htmlentities($note['id']) ?></li>
            <li>Tytuł: <?php echo htmlentities($note['title']) ?></li>
            <?php echo htmlentities($note['description']) ?>
            <li>Data utworzenia: <?php echo htmlentities($note['create_date']) ?></li>
        </ul>

    <?php else : ?>
        <div>Brak wskazanej notatki do wyświetlenia</div>
    <?php endif; ?>
    <a href="./">
        <button>Powrót do notatek</button>
    </a>
</div>