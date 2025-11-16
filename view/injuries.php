<?php 
// Load bootstrap if not already loaded (for direct access)
if (!function_exists('url')) {
    require_once __DIR__ . '/../bootstrap.php';
}
$title = $title ?? 'Injuries - Athletic Trainer'; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($title) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="<?= asset('style/athletic-modern.css') ?>">
        <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet">
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
        <div id="navigationLink">
            <a href="../view/homePage.php">Home</a><span class="glyphicon glyphicon-chevron-right"></span><a href="../view/homePage.php">Injuries</a>   
        </div>
        <div id="myInjuryResult" class="white myBackground">
        <?php
        
          if ($name ==  null){
             echo("No keyword entered. Please go back to the home page to search for a keyword.");   
            }
        
        
       else if (empty($result)){
                  echo ("No match found for ".$name.".   Our database is growing every day, so please check again later for that keyword.<br/>"
                          . "In the meantime, you can search for keywords such as groin, elbow, thighs etc...  ");
                }
                
       else if (is_array($result) || is_object($result))
        {
           foreach ($result as $injury) {  
                echo ("Below are the results of your query:<br><br>  ");
                
        ?>
            <form action="#" method="post" >
                <a href=" <?php echo ("../view/".$injury[3]);?>" class="blackLink"><?php echo($injury[0]);?></a>	
              <br><br>
            </form>
          
         <?php   
              }
              
          }
        
              
        
        
        
        ?>
        </div>
        <div>
            <br/>
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
        <footer class="footer">
            <small><i>Copyright &copy; <?= date('Y') ?> All rights reserved. The Athletic Trainer.
            <a href="mailto:webmaster@athletictrainer.com">webmaster@athletictrainer.com</a></i></small>
        </footer>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="<?= asset('js/Athletic.js') ?>"></script>
    </body>
</html>
