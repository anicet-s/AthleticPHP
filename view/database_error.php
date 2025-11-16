<?php $title = 'Database Error'; ?>
<?php require __DIR__ . '/partials/header.php'; ?>

<?php require __DIR__ . '/partials/navigation.php'; ?>

<div class="container" style="margin-top: 100px;">
    <h1>Database Error</h1>
    <p>There was an error connecting to the database.</p>
    <p>Please try again later or contact support if the problem persists.</p>
    <?php if (env('APP_DEBUG') === 'true' && isset($error_message)): ?>
        <div class="alert alert-danger">
            <strong>Debug Info:</strong> <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>
    <a href="<?= url('/') ?>" class="btn btn-primary">Go to Home</a>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
