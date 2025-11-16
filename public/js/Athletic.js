/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 function checkSelected(){
              if((document.getElementById("part1").checked)=== true){
                showElbowQuestions();
                }
              else if ((document.getElementById("part2").checked)=== true){
                showAnkleQuestions();  
              }
             else if ((document.getElementById("part3").checked) === true){
                 showGroinQuestions();
             }
             
             else if ((document.getElementById("part4").checked) === true){
                 showThighQuestions();
             }
             else if ((document.getElementById("part5").checked) === true){
                 showKneeQuestions();
             }
             
              
 }
         
function showElbowQuestions(){
    $(document).ready(function(){          
           $('#myElbowModal1').modal('show');   
           $("#elbowQ1y").click(function(){
                 $('#myElbowModal2').modal('show');
                $("#elbowQ2y").click(function(){
                 $('#elbowConfirm').modal('show');
                  $("#elbowGo").click(function(){
                     window.open("../view/diagnostic.php#elbowInfo", "_self");
                  });
                 });
                 
                 $("#elbowQ2n").click(function(){
                 $('#okConfirm').modal('show'); 
                 });
           });
           
            $("#elbowQ1n").click(function(){
             $('#myElbowModal2').modal('show');
               $("#elbowQ2y").click(function(){
                 $('#incomplete').modal('show');
                 });
                 
                 $("#elbowQ2n").click(function(){
                 $('#incomplete').modal('show');
                 });
                
           });
    });
       
}

function showAnkleQuestions(){
    $(document).ready(function(){          
           $('#myAnkleModal1').modal('show');   
           $("#ankleQ1y").click(function(){
                 $('#myAnkleModal2').modal('show');
                 $("#ankleQ2y").click(function(){
                     $('#myAnkleModal3').modal('show');
                      $("#ankleQ3y").click(function(){
                       $('#sprainConfirm').modal('show'); 
                       $("strainGo").click(function(){
                          window.open("../view/diagnostic.php#ankleInfo", "_self");
                         });
                      });
                      $("#ankleQ3n").click(function(){
                        $('#okConfirm').modal('show');
                      });
                 });
                 
                 $("#ankleQ2n").click(function(){
                 $('#okConfirm').modal('show');
                 });
           });
           
            $("#ankleQ1n").click(function(){
             $('#myAnkleModal2').modal('show');
               $("#ankleQ2y").click(function(){
                 $('#incomplete').modal('show');
                 });
                 
                 $("#ankleQ2n").click(function(){
                $('#incomplete').modal('show'); 
                 });
                
           });
    });
       
}

function showGroinQuestions(){
    $(document).ready(function(){          
           $('#myGroinModal1').modal('show');   
           $("#groinQ1y").click(function(){
                 $('#myGroinModal2').modal('show');
                 $("#groinQ2y").click(function(){
                    $('#groinConfirm').modal('show');
                    $("#groinGo").click(function(){
                    window.open("../view/diagnostic.php#groinInfo", "_self");
                     });
                 });
                 
                 $("#groinQ2n").click(function(){
                 $('#okConfirm').modal('show');
                 });
           });
           
            $("#groinQ1n").click(function(){
             $('#myGroinModal2').modal('show');
               $("#groinQ2y").click(function(){
                 $('#incomplete').modal('show');
                 });
                 
                 $("#groinQ2n").click(function(){
                   $('#incomplete').modal('show');
                 });
                
           });
    });
       
}

function showThighQuestions(){
    $(document).ready(function(){          
           $('#myThighModal1').modal('show');   
           $("#thighQ1y").click(function(){
                 $('#myThighModal2').modal('show');
                 $("#thighQ2y").click(function(){
                     $('#myThighModal3').modal('show');
                      $("#thighQ3y").click(function(){
                         $('#harmstringConfirm').modal('show');
                         $("#harmStringGo").click(function(){
                            window.open("../view/diagnostic.php#thighsInfo", "_self");
                          });
                      });
                      $("#thighQ3n").click(function(){
                       $('#okConfirm').modal('show');
                      });
                 });
                 
                 $("#thighQ2n").click(function(){
                 $('#incomplete').modal('show');
                 });
           });
           
            $("#thighQ1n").click(function(){
             $('#myThighModal2').modal('show');
               $("#thighQ2y").click(function(){
                 $('#incomplete').modal('show');
                 });
                 
                 $("#thighQ2n").click(function(){
                 $('#incomplete').modal('show'); 
                 });
                
           });
    });
    
 }    
       
 function showKneeQuestions(){
    $(document).ready(function(){          
           $('#myKneeModal1').modal('show');   
           $("#kneeQ1y").click(function(){
                 $('#myKneeModal2').modal('show');
                 $("#kneeQ2y").click(function(){
                     $('#myKneeModal3').modal('show');
                      $("#kneeQ3y").click(function(){
                       $('#kneeConfirm').modal('show'); 
                         $("#kneeGo").click(function(){
                          window.open("../view/diagnostic.php#kneeInfo", "_self");
                         });
                      });
                       $("#KneeQ3n").click(function(){
                       $('#okConfirm').modal('show');
                       });
                 });
                 
                 $("#kneeQ2n").click(function(){
               $('#incomplete').modal('show');
                 });
           });
           
            
           
            $("#kneeQ1n").click(function(){
             $('#myKneeModal2').modal('show');
               $("#kneeQ2y").click(function(){
                 $('#incomplete').modal('show');
                 window.open("../view/diagnostic.php", "_self");
                 });
                 
                 $("#kneeQ2n").click(function(){
                 $('#incomplete').modal('show');
                 window.open("../view/diagnostic.php", "_self"); 
                 });
                
           });
    });
             
       
    
}

function reset(){
    document.getElementById("firstName").innerHTML ="";
    document.getElementById("lastName").innerHTML ="";
    document.getElementById("email").innerHTML ="";
}


function sendMessage(){
     document.getElementById("firstName").innerHTML ="";
    document.getElementById("lastName").innerHTML ="";
    document.getElementById("email").innerHTML ="";
    alert("Your message was successfully sent!") ;
}

var x = document.getElementById("demo");

/***function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}***/


var session;
$(window).load(function(){
if(session === undefined){
$('#myModal').modal('show');
session ="started";
 }
});


   
$("#contactBody").ready(function(){
var menuImage = document.getElementById("menuImage");
if ( menuImage != null)
{
var dish = new Array(6);
var curDish = 0;
dish[0] = "uniqueRunner1.jpg";
dish[1] = "uniqueRunner2.jpg";
dish[2] = "uniqueRunner3.jpg";
dish[3] = "uniqueRunner4.jpg";
dish[4] = "uniqueRunner5.jpg";
dish[5] = "uniqueRunner6.jpg";
function displayImage(){
    if (curDish == 5){
        curDish = 0;
        menuImage.src = "../images/" + dish[curDish];
    }
    else
    {
        curDish++;
         document.getElementById("menuImage").src = "../images/" + dish[curDish];         
    }
   }     
 setInterval(displayImage, 300);
 }
});

       
  //<![CDATA[
    function reset() 
    {
        document.getElementById("firstName").value = '';
        document.getElementById("lastName").value = '';
        document.getElementById("eMail").value = '';
    }
    




      
     
   // ]]> 

         
    