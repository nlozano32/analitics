<?php
		
		
	/*	$PassKey = "XEEfnewyLDa2TqVU";
		include ('config.ini.php');
		
		$arrayCamp = array();
		
		$qcampaign = $bdd -> prepare("SELECT `campaign`.`id_campaign`,`campaign`.`title` FROM `launchleap`.`campaign`");
		$qcampaign -> execute() or die("error : 0x00000006");
		
		$a = 0;
		while ($cam = $qcampaign-> fetch(PDO::FETCH_ASSOC)) {
			
		$arrayCamp = array($cam['title'], $cam['id_campaign']);
	
		$a++;
		
		

		}
		
		foreach ($arrayCamp as $key => $value) {
		
		echo $key;
		echo $value;
			
		}*/
	
?>
	
	<form action="analiticsForm.php" name="form1" method="get">
		<table align="center">

	    	<tr>
			 	<td nowrap="nowrap" align="right">Query statistics: </td>
			  	<td align="left">
			  		<select class="content" name="timeS" id="timeS" title='' tabindex="0" >
	                    <option label="All time" value="6">All time</option>
	                    <option label="Last month"value="2">Last month</option>
	                    <option label="Last week" value="1">Last week</option>
	                    <option label="Last day" value="3">Last day</option>
	                    <option label="Last hour" value="4">Last hour</option>
	                    <option label="Last 15 minutes" value="5">Last 15 minutes</option>
					</select>
				</td>
			</tr>
			
			<tr>
			 	<td nowrap="nowrap" align="right">Campaign statistics: </td>
			  	<td align="left">
			  		<select class="content" name="campaign" id="campaign" title='' tabindex="0" >
			  			<option label="All campaign" value="0">All campaign</option>
	                    <option label="Hot Dogs All Dressed" value="1">Hot Dogs All Dressed</option>
	                    <option label="Title"value="2">Title</option>
	                    <option label="My campaign" value="10">My campaign</option>
	                    
					</select>
				</td>
			</tr>
	    	
	    	<tr>
			  	<td align="right">
	            	<br />
	            	<input type="hidden" name="pag" value="1"/>
			 		<input class="form" type="submit" value="Consult" />
	            </td>
	            
			</tr>
		</table>
	</form>
	
		<?php
		
		
		if(isset($_GET['timeS'])){

			include("analitics.php");
			
		}
	
?>
	
