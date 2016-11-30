<?php
$PassKey="XEEfnewyLDa2TqVU";
include('config.ini.php');
//$jslog = true;

	//Begining of the HTML headers
//include('header.php');
$landingPage = true;

	//Display the top menu bar
//include('topnav.php');

//get Time


      $checkTime = $bdd->prepare("SELECT`user_session`.`time` FROM `launchleap`.`user_session` where `user_session`.`id_session` = :time");
      $checkTime->bindParam(':id_session',$_POST['id_session']);
      $checkTime->execute() or die('marche pasx87');
	  
	  //echo $checkTime;
	  $obj = $checkTime->fetch();
	  $id_date = $obj['time'];
	  echo date("Y-m-d H:i:s", $id_date);
	  //echo $id_date
  
//$conn = null;
?>

       <div id="logme" style="padding:2em 20% 2em 20%;border:none;background-color:#f0f0f0;border-radius:15px;">
            <div class="panel" style="border:none;">
                <form id="register" method="post" action="analiticsTest.php">
            
                    <h3>Test date</h3>
                    <div><input type="text" name="time" value="" size="32" /></div>
                    <div><input type="Submit" name="Get Time" class="signmein" style="margin-top:2em"></div>
					
					<?php

	 if($checkTime->rowcount() > 0){
                //$error = true;
                echo('<div class="wrapper">Date</p></div>'.$id_date);
            
        }
        else{
            $error = true;
            echo('<div class="wrapper"><p class="error">Cant date</p></div>');
        }
//include('footer.php');
?>
    
                </form>
            </div>
        </div>
    </div`>



