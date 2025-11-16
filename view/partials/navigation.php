<div id="myNav">
    <div id="siteMenu" class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="glyphicon glyphicon-th-list"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="<?= url('/home') ?>">Home</a></li>
            <li><a href="<?= url('/about') ?>">About</a></li>
            <li><a href="<?= url('/diagnostic') ?>">Diagnostic</a></li>
            <li><a href="<?= url('/about#contactBody') ?>">Contact</a></li>
        </ul>
    </div>
    <div id="inlineNav">
        <ul class="nav nav-pills">
            <li><a href="<?= url('/home') ?>">Home</a></li>
            <li><a href="<?= url('/about') ?>">About</a></li>
            <li><a href="<?= url('/diagnostic') ?>">Diagnostic</a></li>
            <li><a href="<?= url('/about#contactBody') ?>">Contact</a></li>
        </ul>
    </div>
</div>
