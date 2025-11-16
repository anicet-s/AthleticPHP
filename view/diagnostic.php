<?php 
// Load bootstrap if not already loaded (for direct access)
if (!function_exists('url')) {
    require_once __DIR__ . '/../bootstrap.php';
}
$title = $title ?? 'Diagnostic - Athletic Trainer'; 
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
    <body id="diagnosticBody">
        <div id="wrapper" class="container-fluid">
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
            <div id="navigationLink" class="downMenu">
                <a href="homePage.php">Home</a>
                <span class="glyphicon glyphicon-chevron-right"></span>
                <a href="diagnostic.php">Diagnostic</a>   
            </div >
            <div id="bodyPart">
                <h5>What part of the body is experiencing the condition?(Please select one at a time):</h5><br/><br/>
                <form id="myMessage">
                     <input type="radio" name="part" id="part1" value="Elbow" >Elbow<br>
                      <input type="radio" name="part" id="part2" value="Ankle" >Ankle<br>
                      <input type="radio"  name="part" id="part3" value="Groin" >Groin<br>
                      <input type="radio" name="part" id="part4" value="Thighs" >Thighs<br>
                      <input type="radio" name="part" id="part5" value="Knee" >Knee<br><br><br>
                      <button type="button" onclick="checkSelected()">Submit</button>
                      
                </form>
            </div>
         <section class="diseaseSection">     
          <div id="ankleInfo" class="white myBackground">
          <h4>Symptoms of an ankle sprain:</h4>
          <p>Immediate swell and bruising of the ankle, Severe pain, unstable feeling at the ankle</p>
          <h4>Severity:</h4>
          <p>Variable (3 degrees)</p>
          <h4>Treatment:</h4>
          <p>Rest,Ice, Compression</p>
                 
          <br/>
            <a href="<?= url("/diagnostic") ?>" class="blackLink">Back</a>
          </div>
            
          <div id="elbowInfo" class="blank">
           <h4>Symptoms of a tennis elbow:</h4>
           <p>Pain and tenderness in the bony knob on the outside of your elbow.<br/>
              Pain around the elbow that  may also radiate into the upper or lower arm.</p>
           <h4>Severity:</h4>
           <p>Could be severe.</p>
            <h4>Treatment:</h4><br>
            <p>Exercises for flexibility and arm muscle strength.</p>
            <br/>
            <a href="<?= url("/diagnostic") ?>">Back</a>
          </div>
            
          <div id="groinInfo" class="white alternateBack">
           <h4>Symptoms of a groin pull:</h4>
           <p>Pain and tenderness in the groin and the inside of the thigh.<br/>
             Pain when you bring your legs together.</p>
           <h4>Severity:</h4>
           <p>Variable (3 degrees).</p>
            <h4>Treatment:</h4><br>
            <p>Anti-inflammatory pain killers,Ice, Compression, active stretching and strengthening exercises.</p>
            <br/>
            <a href="<?= url("/diagnostic") ?>" class="blackLink">Back</a>
        </div>
            
          <div id="kneeInfo" class="blank">
           <h4>Symptoms of an ACL tear:</h4>
           <p>A loud "pop" or a "popping" sensation in the knee, Severe pain and inability to continue activity, Loss of range of motion</p>
           <h4>Severity:</h4>
           <p>severe.</p>
            <h4>Treatment:</h4><br>
            <p>Rest, Compression, Ice.</p>
            <br/>
            <a href="<?= url("/diagnostic") ?>">Back</a>
        </div>
            
        <div id="thighsInfo" class="white myBackground">
           <h4>Symptoms of a harmstring strain:</h4>
           <p>Sudden and severe pain during exercise, along with a snapping or popping feeling.<br/>
               Pain in the back of the thigh and lower buttock when walking, straightening the leg, or bending over.<br/>
               Tenderness and bruising</p>
           <h4>Severity:</h4>
           <p>Variable (3 degrees).</p>
            <h4>Treatment:</h4><br>
            <p>Usually heals on their own,Ice, Compression, Elevation - keep your leg slightly raised.</p>
            <br/>
            <a href="<?= url("/diagnostic") ?>" class="blackLink">Back</a>
        </div>
            
         </section >         
            
        </div> 
         
            
         <div class="modal fade" id="myElbowModal1" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">
                                            
                                            <div class="modal-body">
                                                 <p>Pain and tenderness in the bony knob on the outside of your elbow?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="elbowQ1y" class="btn alert-danger" data-dismiss="modal">Yes</a>
                                                  <a href="#" id="elbowQ1n" class="btn alert-success" data-dismiss="modal">No</a>
                                            </div>
                                        </div>    
                                 </div>
         </div>
        
        
        <div class="modal fade" id="myElbowModal2" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Pain around the elbow that  may also radiate into the upper or lower arm?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="elbowQ2y" class="btn alert-danger" data-dismiss="modal" value="Yes">Yes</a>
                                                  <a href="#" id="elbowQ2n" class="btn alert-success" data-dismiss="modal" value="No">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        
        
        
        
          <div class="modal fade" id="myAnkleModal1" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Immediate swell and bruising of the ankle?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="ankleQ1y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="ankleQ1n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        <div class="modal fade" id="myAnkleModal2" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Severe pain within the ankle?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="ankleQ2y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="ankleQ2n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        <div class="modal fade" id="myAnkleModal3" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Unstable feeling at the ankle?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="ankleQ3y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="ankleQ3n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
         <div class="modal fade" id="myGroinModal1" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Pain and tenderness in the groin and the inside of the thigh?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="groinQ1y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="groinQ1n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
         <div class="modal fade" id="myGroinModal2" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Pain when you bring your legs together?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="groinQ2y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="groinQ2n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        <div class="modal fade" id="myThighModal1" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Pain in the back of the thigh and lower buttock when walking, straightening the leg, or bending over?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="thighQ1y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="thighQ1n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        <div class="modal fade" id="myThighModal2" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Sudden and severe pain during exercise, along with a snapping or popping feeling?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="thighQ2y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="thighQ2n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        <div class="modal fade" id="myThighModal3" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Tenderness and bruising in thigh?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="thighQ3y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="thighQ3n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
            <div class="modal fade" id="myKneeModal1" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Does the knee have laxity?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="kneeQ1y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="kneeQ1n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        <div class="modal fade" id="myKneeModal2" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Any swelling, redness or heat?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="kneeQ2y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="kneeQ2n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        <div class="modal fade" id="myKneeModal3" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Does the knee give out or buckle?</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="kneeQ3y" class="btn alert-danger" data-dismiss="modal" >Yes</a>
                                                  <a href="#" id="kneeQ3n" class="btn alert-success" data-dismiss="modal">No</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        <div class="modal fade" id="elbowConfirm" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Looks like a tennis elbow. More information about this injury on the next page...;</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="elbowGo" class="btn alert-danger" data-dismiss="modal" >OK</a>
                                                  <a href="../view/Diagnostic.php" id="elbowNo" class="btn alert-success" data-dismiss="modal">No, thanks</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
         <div class="modal fade" id="okConfirm" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Sounds like a temporary discomfort</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="../view/Diagnostic.php" id="okButton" class="btn alert-success" data-dismiss="modal" >OK</a>
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
         <div class="modal fade" id="incomplete" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>You are probably OK. Not all symptoms were detected.</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="../view/Diagnostic.php" id="okButton" class="btn alert-success" data-dismiss="modal" >OK</a>
                                            </div>
                                        </div>    
                                 </div>
          </div>
           <div class="modal fade" id="sprainConfirm" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Looks like an ankle sprain. More information about this injury on the next page...</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="strainGo" class="btn alert-danger" data-dismiss="modal" >OK</a>
                                                  <a href="../view/Diagnostic.php" id="strainNo" class="btn alert-success" data-dismiss="modal">No, thanks</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
          <div class="modal fade" id="groinConfirm" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Looks like an groin pull injury. More information about it on the next page...</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="groinGo" class="btn alert-danger" data-dismiss="modal" >OK</a>
                                                  <a href="../view/Diagnostic.php" id="groinNo" class="btn alert-success" data-dismiss="modal">No, thanks</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
        <div class="modal fade" id="harmstringConfirm" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Looks like an harmstring strain. More information about this injury on the next page...</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="harmStringGo" class="btn alert-danger" data-dismiss="modal" >OK</a>
                                                  <a href="../view/Diagnostic.php" id="harmStringNo" class="btn alert-success" data-dismiss="modal">No, thanks</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
        
         <div class="modal fade" id="kneeConfirm" tabindex="-1">
                                 <div class="modial-dialog modal-sm">
                                       <div class="modal-content">                                        
                                            <div class="modal-body">
                                                 <p>Looks like an ACL tear. More information about this injury on the next page....</p>
                                            </div>
                                            <div class="modal-footer">
                                                  <a href="#" id="kneeGo" class="btn alert-danger" data-dismiss="modal" >OK</a>
                                                  <a href="../view/Diagnostic.php" id="kneeNo" class="btn alert-success" data-dismiss="modal">No, thanks</a>
                                        
                                            </div>
                                        </div>    
                                 </div>
          </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="<?= asset('js/Athletic.js') ?>"></script>
    </body>
</html>
