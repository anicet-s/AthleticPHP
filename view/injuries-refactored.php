<?php 
$title = $title ?? 'Injuries - Athletic Trainer';
?>
<?php require __DIR__ . '/partials/header.php'; ?>

<?php require __DIR__ . '/partials/navigation.php'; ?>

<div id="navigationLink">
    <a href="<?= url('/home') ?>">Home</a>
    <span class="glyphicon glyphicon-chevron-right"></span>
    <a href="<?= url('/injuries') ?>">Injuries</a>   
</div>

<div id="myInjuryResult" class="white myBackground">
    <?php if (empty($name)): ?>
        <p>No keyword entered. Please go back to the home page to search for a keyword.</p>
    
    <?php elseif (empty($result)): ?>
        <p>
            No match found for <strong><?= htmlspecialchars($name) ?></strong>. 
            Our database is growing every day, so please check again later for that keyword.<br/>
            In the meantime, you can search for keywords such as groin, elbow, thighs, etc...
        </p>
    
    <?php else: ?>
        <p>Below are the results of your query:</p><br>
        
        <?php foreach ($result as $injury): ?>
            <div class="injury-result">
                <?php if (isset($injury[3]) && !empty($injury[3])): ?>
                    <a href="<?= url('/view/' . htmlspecialchars($injury[3])) ?>" class="blackLink">
                        <?= htmlspecialchars($injury[0] ?? 'Unknown') ?>
                    </a>
                <?php else: ?>
                    <span><?= htmlspecialchars($injury[0] ?? 'Unknown') ?></span>
                <?php endif; ?>
                <br><br>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div style="margin-top: 20px;">
    <p><strong>For further search on the web, please try again below:</strong></p><br/>
    <script>
    (function() {
        var cx = '011288881374594038238:aqap6ljnbem';
        var gcse = document.createElement('script');
        gcse.type = 'text/javascript';
        gcse.async = true;
        gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(gcse, s);
    })();
    </script>
    <gcse:searchbox-only></gcse:searchbox-only>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
