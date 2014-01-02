<?php
        $presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
        <div class="pagination">
                <ul>
                        <?php echo $presenter->render(); ?>
                </ul>
                <br>
                Mostrando página <b><?php echo $paginator->getCurrentPage() ?></b> de <b><?php echo $paginator->getLastPage(); ?></b>
        </div>
<?php endif; ?>