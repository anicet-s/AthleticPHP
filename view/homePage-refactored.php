<?php 
// Set default title if not provided
$title = $title ?? 'Home - Athletic Trainer';
?>
<?php require __DIR__ . '/partials/header.php'; ?>

<?php require __DIR__ . '/partials/navigation.php'; ?>

<div id="infoDiv">	  
    <div id="searchSection">
        <div>
            <p id="headerWord">Learn about athletic training</p>
            <p id="headDetails">
                Use the diagnostic page to provide a possible diagnostic to your symptoms.<br>
                You can also try to search for an athletic term you may not be familiar with<br/>
                using the search box below.
            </p><br/>
        </div>
        <form action="<?= url('/injuries/search') ?>" method="post" class="blank">
            <?= csrf_field() ?>
            <input type="search" 
                   id="searchBox" 
                   name="action" 
                   placeholder="Search Athletic Keyword"
                   aria-label="Search Athletic Keyword"> &nbsp; &nbsp;
            <button class="btn btn-default" type="submit" aria-label="Search">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </form>                   
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
