<?php $title = '500 - Server Error'; ?>
<?php require __DIR__ . '/../partials/header.php'; ?>

<?php require __DIR__ . '/../partials/navigation.php'; ?>

<div class="container" style="margin-top: 100px; text-align: center;">
    <h1>500 - Server Error</h1>
    <p><?= htmlspecialchars($message ?? 'An unexpected error occurred.') ?></p>
    <a href="<?= url('/') ?>" class="btn btn-primary">Go to Home</a>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
