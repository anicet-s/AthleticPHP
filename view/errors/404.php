<?php $title = '404 - Page Not Found'; ?>
<?php require __DIR__ . '/../partials/header.php'; ?>

<?php require __DIR__ . '/../partials/navigation.php'; ?>

<div class="container" style="margin-top: 100px; text-align: center;">
    <h1>404 - Page Not Found</h1>
    <p>The page you are looking for could not be found.</p>
    <a href="<?= url('/') ?>" class="btn btn-primary">Go to Home</a>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
