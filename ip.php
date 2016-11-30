<?php
$PassKey="XEEfnewyLDa2TqVU";
include('config.ini.php');
$ip = $bdd->prepare("Select DISTINCT(v.id_session),s.ip From vote v LEFT JOIN user_session s ON v.id_session = s.id_session ORDER by v.id_session");
$ip->execute();
while ($getip = $ip->fetch(PDO::FETCH_ASSOC)) {
	$tags = simplexml_load_file('http://freegeoip.net/xml/'.$getip[ip]);
	$tags->locationcode = $tags->CountryCode.$tags->RegionCode.$tags->City;
	echo("$getip[id_session];$getip[ip];$tags->City;$tags->RegionCode;$tags->CountryCode<br>");
}



?>