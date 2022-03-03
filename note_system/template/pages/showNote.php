<div class="showNote">
    <?php $note = $viewParameters['note'] ?? null; ?>
    <?php if ($note) : ?>
        <ul>
            <li>Nr notatki: <?php echo $note['id'] ?></li>
            <li>Tytuł: <?php echo $note['title'] ?></li>
            <?php echo $note['description'] ?>
            <li>Data utworzenia: <?php echo $note['create_date'] ?></li>
        </ul>

    <?php else : ?>
        <div>Brak wskazanej notatki do wyświetlenia</div>
    <?php endif; ?>
    <a href="./">
        <button>Powrót do notatek</button>
    </a>
</div>