<?php
/**
 * Function to detect the Date and Time, operating system , browser and version browser.
 */

$PassKey = "XEEfnewyLDa2TqVU";
include ('config.ini.php');

date_default_timezone_set("America/Montreal");

$nowtime = time();
$oldtime = timeV($_GET['timeS']);
$campaign = $_GET['campaign'];
$stadisticA = array();
$stadisticB = array();
$stadisticC = array();
$stadisticD = array();
$stadisticP = array();
$arraycam = array();



if ($campaign!=0) {
	
	$result = $bdd -> prepare("SELECT b.`useragent`, c.`where` 
		FROM `launchleap`.`campaign_visite` a LEFT JOIN `launchleap`.`user_session` b ON (a.id_session = b.id_session)
		LEFT JOIN `launchleap`.`tracker` c ON (a.id_session = c.id_session) 
		where b.time between :oldtime AND :nowtime AND a.id_campaign = :campaign");
			//$result = $bdd -> prepare("SELECT * FROM `launchleap`.`user_session` where time between :oldtime and :nowtime");
			$result -> bindParam(':oldtime', $oldtime);
			$result -> bindParam(':nowtime', $nowtime);
			$result -> bindParam(':campaign', $campaign);
			$result -> execute() or die("error : 0x00000006");
	
		}else{
				
			$result = $bdd -> prepare("SELECT b.`useragent`, c.`where` 
			FROM `launchleap`.`campaign_visite` a LEFT JOIN `launchleap`.`user_session` b ON (a.id_session = b.id_session)
			LEFT JOIN `launchleap`.`tracker` c ON (a.id_session = c.id_session) 
			where b.time between :oldtime AND :nowtime");
			//$result = $bdd -> prepare("SELECT * FROM `launchleap`.`user_session` where time between :oldtime and :nowtime");
			$result -> bindParam(':oldtime', $oldtime);
			$result -> bindParam(':nowtime', $nowtime);
			$result -> execute() or die("error : 0x00000006");
		
		}

$a = 0;

while ($est = $result -> fetch(PDO::FETCH_ASSOC)) {

	$info = detect($est['useragent']);

	$stadisticP[$a] = ($est['where']);
	$stadisticA[$a] = ($info["os"]);
	$stadisticB[$a] = ($info["browser"]);
	$stadisticC[$a] = array('browser' => $info['browser'], 'version' => $info['version']);
	$stadisticD[$a] = array('page' => $est['where'], 'op' => $info["os"]);

	$a++;

}
echo "<br/>";
echo "<br/>";

//print_r($stadisticD);
echo "<br/>";
echo "<br/>";

$arreglo = (browserVersion($stadisticC));
$arreglospg = (opsyspg($stadisticD));
statistics($stadisticA, $stadisticB, $arreglo, $stadisticP, $arreglospg);

//This counts of elements for array 

function recorrer($array, $brow) {

	$arr2 = array();

	foreach ($array as $variable) {

		if (in_array($brow, $variable)) {

			if (is_array($variable)) {

				foreach ($variable as $key => $value) {

					if (is_array($value)) {

						$arr2 = array_icount_values($value);
						/*echo "Prueba";
						 print_r($arr2);*/
					}
				}

			}

		}

	}

	return $arr2;

}

//This brings the elements in an array (browser - version)

function browserVersion($stadisticC) {

	$grupo = array();
	$directorios = array();

	foreach ($stadisticC as $valor => $valor_) {

		//GET THE CURRENT VALUE
		$directorio_ = ucwords(strtolower($valor_['browser']));

		//CHECK IF THE VALUE IS REPEATED
		if (!in_array($directorio_, $directorios)) {
			//IF THERE IS ADDED TO THE NEW ARRAY
			$directorios[] = $directorio_;
		}

		//Called the current value
		$directorio_u = array_search($directorio_, $directorios);

		//I ADD NEW RECORD FOR THE CONTAINER OF VALUE
		$grupo[$directorio_u][] = $valor_;
	}
	$directorio_ = array();
	foreach ($grupo as $uno) {
		foreach ($uno as $dos) {
			$archivo_[] = $dos['version'];
		}
		$directorio_[] = array_filter(array('browser' => $uno[0]['browser'], 'version' => array_filter($archivo_)));
		unset($archivo_);

	}

	return $directorio_;

}

//This brings the elements in an array (Page - operative system)

function opsyspg($stadisticD) {

	$grupo = array();
	$directorios = array();

	foreach ($stadisticD as $valor => $valor_) {

		//GET THE CURRENT VALUE
		$directorio_ = ucwords(strtolower($valor_['page']));

		//CHECK IF THE VALUE IS REPEATED
		if (!in_array($directorio_, $directorios)) {
			//IF THERE IS ADDED TO THE NEW ARRAY
			$directorios[] = $directorio_;
		}

		//Called the current value
		$directorio_u = array_search($directorio_, $directorios);

		//I ADD NEW RECORD FOR THE CONTAINER OF VALUE
		$grupo[$directorio_u][] = $valor_;
	}
	$directorio_ = array();
	foreach ($grupo as $uno) {
		foreach ($uno as $dos) {
			$archivo_[] = $dos['op'];
		}
		$directorio_[] = array_filter(array('page' => $uno[0]['page'], 'os' => array_filter($archivo_)));
		unset($archivo_);

	}

	return $directorio_;

}

/*
 * This function returns the chosen time
 * */

function timeV($tiempo) {

	echo "<br/>";
	echo "<br/>";

	$nowtime = time();
	$time = 0;

	if ($tiempo == 1) {

		//Last week

		$lastWeek = $nowtime - (7 * 24 * 60 * 60);
		$time = $lastWeek;
		echo "<FONT FACE='arial' SIZE=5 COLOR=red>Last week</FONT>";

	}

	if ($tiempo == 2) {

		//30 last days

		$lastMonth = $nowtime - (30 * 24 * 60 * 60);
		$time = $lastMonth;

		echo "<FONT FACE='arial' SIZE=5 COLOR=red>Last month</FONT>";

	}

	//last days

	if ($tiempo == 3) {

		$lastDay = $nowtime - (24 * 60 * 60);
		$time = $lastDay;

		echo "<FONT FACE='arial' SIZE=5 COLOR=red>last days</FONT>";

	}

	// last hour

	if ($tiempo == 4) {

		$lastHour = $nowtime - (60 * 60);
		$time = $lastHour;

		echo "<FONT FACE='arial' SIZE=5 COLOR=red>last hour</FONT>";

	}

	//15 last minutes

	if ($tiempo == 5) {

		$lastMinute = $nowtime - (15 * 60);
		$time = $lastMinute;

		echo "<FONT FACE='arial' SIZE=5 COLOR=red>15 last minutes</FONT>";

	}

	//All time

	if ($tiempo == 6) {

		$allTime = 0;
		$time = $allTime;

		echo "<FONT FACE='arial' SIZE=5 COLOR=red>All record</FONT>";
	}

	return $time;

}

/*
 * 
 *  This function paints the statistical information*/

function statistics($op, $bro, $brover, $page, $oppg) {

	$arrayPage = array();

	if (count($op) != null) {

		$opsys = array_icount_values($op);

		echo "OPERATIVE SYSTEM: ";

		echo "<br/>";
		echo "<br/>";
		//print_r($opsys);
		//echo "<br/>";

		echo "AVERAGE OPERATIVE SYSTEM: ";
		echo "<br/>";
		echo "<br/>";

		$arrayData = array();

		echo "<table border='1' cellpadding='1' cellspacing='1'>";
		
		echo "<tr>";

		foreach ($opsys AS $ope => $var) {

			echo("<td width='200' bgcolor='#CCCCCC'>" . $ope . "</td>");

		}

		echo "</tr>";

		echo "<tr>";

		foreach ($opsys AS $ope => $var) {

			echo("<td>" . $var . "</td>");
		}

		echo "</tr>";

		echo "<tr>";

		foreach ($opsys AS $ope => $var) {

			$arrayData = array($var);
			$size = count($arrayData);

			$arrayFinal = array_sum($arrayData);

			echo("<td>" . (($arrayFinal / array_sum($opsys)) * 100) . " %</td>");

		}

		echo "</tr>";

		echo "</table>";

		echo "<br/>";
		echo "<br/>";

		echo "AVERAGE PAGE: ";

		echo "<br/>";
		echo "<br/>";

		echo "<table border='1' cellpadding='1' cellspacing='1'>";
		echo "<tr>";
		echo("<td width='400' bgcolor='#CCCCCC'>" . "PAGE" . "</td>");
		echo("<td width='150' bgcolor='#CCCCCC'>" . "VIEWS" . "</td>");
		/*	foreach ($opsys AS $ope => $var) {

		 echo("<td width='400' bgcolor='#CCCCCC'>" . $ope . "</td>");
		 }*/
		echo "</tr>";

		$arrayPage = array_icount_values($page);

		echo "<td>";

		foreach ($arrayPage as $key => $value) {

			echo("<p align='left'>" . $key . "</p>");
		}

		echo "</td>";

		echo "<td>";

		foreach ($arrayPage as $key => $value) {

			echo("<p align='left'>" . $value . "</p>");

		}

		echo "</td>";

		echo "</table>";

	} else {

		echo "OPERATIVE SYSTEM: ";

		echo "<br/>";
		echo "<br/>";

		echo "No records exist";
	}

	echo "<br/>";
	echo "<br/>";

	if (count($bro) != null) {

		$aaraybro = array();

		$browser = array_icount_values($bro);
		echo "BROWSER - VERSION: ";

		echo "<br/>";
		echo "<br/>";
		//print_r($browser);
		echo "<br/>";

		echo "<br/>";
		echo "<br/>";

		echo "AVERAGE BROWSER: ";

		echo "<br/>";
		echo "<br/>";

		echo "<table border='1' cellpadding='1' cellspacing='1'>";

		echo "<tr>";

		echo "<td width='250' bgcolor='#CCCCCC'>Browser</td>";
		echo "<td width='250' bgcolor='#CCCCCC'>Users</td>";
		echo "<td width='250' bgcolor='#CCCCCC'>% Users</td>";
		echo "<td width='250' bgcolor='#CCCCCC'>Version</td>";
		echo "<td width='250' bgcolor='#CCCCCC'>Users Version</td>";
		echo "<td width='250' bgcolor='#CCCCCC'>% Users Version</td>";

		echo "</tr>";

		echo "<tr>";

		foreach ($browser AS $br => $var) {

			$arrayData = array($var);
			$size = count($arrayData);

			$arrayFinal = array_sum($arrayData);

			$aaraybro = recorrer($brover, strtoupper($br));

			echo "<tr>";

			echo("<td>" . $br . "</td>");
			echo("<td>" . $var . "</td>");
			echo("<td>" . (($arrayFinal / array_sum($browser)) * 100) . " % </td>");
			echo("<td>");
			foreach ($aaraybro as $key => $value) {
				echo("<p align='center'>" . $key . "</p>");
				//echo($value);
			}
			echo "</td>";
			echo("<td>");
			foreach ($aaraybro as $key => $value) {
				echo("<p align='center'>" . $value . "</p>");
				//echo($value);
			}
			echo "</td>";
			echo("<td>");
			foreach ($aaraybro as $key => $value) {

				$arrayDataA = array($var);
				$sizeA = count($value);

				$arrayFinalA = array_sum($arrayDataA);

				echo("<p align='center'>" . (($value / $arrayFinalA) * 100) . " % </p>");

			}
			echo "</td>";

			echo "</tr>";
		}

		echo "</tr>";

		echo "</table>";

	} else {

		echo "BROWSER - VERSION: ";
		echo "<br/>";
		echo "<br/>";
		echo "No record exist";
	}

}

/**
 * FUNCTION TO RETURN NUMBER OF ELEMENTS POSITION ARRAY
 */

function array_icount_values($arr, $lower = true) {

	$arr2 = array();

	if (!is_array($arr['0'])) {

		$arr = array($arr);

	}
	foreach ($arr as $k => $v) {

		foreach ($v as $v2) {

			if ($lower == true) {

				$v2 = strtolower($v2);
			}
			if (!isset($arr2[$v2])) {

				$arr2[$v2] = 1;

			} else {

				$arr2[$v2]++;

			}
		}

	}

	return $arr2;
}

/**
 * Function that returns an array with the values ​​:
 *	os => Operating system
 *	browser => Browser
 *	version => Browser version
 */

function detect($userAgent) {
	$browser = array("IE", "OPERA", "MOZILLA", "NETSCAPE", "FIREFOX", "SAFARI", "CHROME");
	$os = array('Windows 8.1' => 'Windows NT 6.3', 'Windows 8' => 'Windows NT 6.2', 'Windows 7' => 'Windows NT 6.1', 'Windows Vista' => 'Windows NT 6.0', 'Windows XP' => 'Windows NT 5.1', 'Windows 2003' => 'Windows NT 5.2', 'Windows' => 'Other windows', 'Open BSD' => 'OpenBSD', 'Sun OS' => 'SunOS', 'iPhone' => 'iPhone', 'iPad' => 'iPad', 'Android' => 'Android', 'BlackBerry' => 'BlackBerry', 'Linux' => '(Linux)|(X11)', 'Mac OS' => '(Mac_PowerPC)|(Macintosh)', 'QNX' => 'QNX', 'BeOS' => 'BeOS', 'OS/2' => 'OS/2', 'Search Bot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)');

	# define default values ​​for the browser and operating system
	$info['browser'] = "OTHER BROWSER";
	$info['os'] = "OTHER OP";
	$info['version'] = "OTHER VERSION";

	# search the browser with its operating system
	foreach ($browser as $parent) {

		$s = strpos(strtoupper($userAgent), $parent);
		$f = $s + strlen($parent);
		$version = substr($userAgent, $f, 15);
		$version = preg_replace('/[^0-9,.]/', '', $version);
		if ($s) {
			$info['browser'] = $parent;
			$info['version'] = $version;
		}
	}

	# get the OS

	foreach ($os as $val => $pattern) {
		if (eregi($pattern, $userAgent))
			$info['os'] = $val;

	}

	# return the array of values
	return $info;

}
?>

