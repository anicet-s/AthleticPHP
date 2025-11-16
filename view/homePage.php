<?php 
$title = $title ?? 'Home - Athletic Trainer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?= asset('style/athletic.css') ?>">
    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash|Pontano+Sans" rel="stylesheet">
</head>
<body class="container-fluid">
    <div id="myNav">
        <div id="siteMenu" class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                <span class="glyphicon glyphicon-th-list"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?= url('/') ?>">Home</a></li>
                <li><a href="<?= url('/about') ?>">About</a></li>
                <li><a href="<?= url('/diagnostic') ?>">Diagnostic</a></li>
                <li><a href="<?= url('/about#contactBody') ?>">Contact</a></li>
            </ul>
        </div>
        <div id="inlineNav">
            <ul class="nav nav-pills">
                <li><a href="<?= url('/') ?>">Home</a></li>
                <li><a href="<?= url('/about') ?>">About</a></li>
                <li><a href="<?= url('/diagnostic') ?>">Diagnostic</a></li>
                <li><a href="<?= url('/about#contactBody') ?>">Contact</a></li>
            </ul>
        </div>
    </div>
    
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
                <input type="search" id="searchBox" name="action" placeholder="Search Athletic Keyword"> &nbsp; &nbsp;
                <button class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>                   
        </div>
    </div>
    
    <footer class="footer">
        <small><i>Copyright &copy; <?= date('Y') ?> All rights reserved. The Athletic Trainer.
        <a href="mailto:webmaster@athletictrainer.com">webmaster@athletictrainer.com</a></i></small>
    </footer>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="<?= asset('js/Athletic.js') ?>"></script>
</body>
</html>


