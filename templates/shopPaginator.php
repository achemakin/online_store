<li>
    <a class="paginator__item" 
        <?php
        if ($var != getPageNumber()): ?>
            href="<?=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)?>?page=<?= $var+1 .
                (isset($_GET['category']) ? ('&category=' . $_GET['category']) : '') .
                (isset($_GET['minPrice']) ? ('&minPrice=' . $_GET['minPrice']) : '') .
                (isset($_GET['maxPrice']) ? ('&maxPrice=' . $_GET['maxPrice']) : '') .
                (isset($_GET['new']) ? ('&new=' . $_GET['new']) : '') .
                (isset($_GET['sale']) ? ('&sale=' . $_GET['sale']) : '')
            ?>"
        <?php endif; ?>
    >
        <?= $var+1 ?>
    </a>
</li>