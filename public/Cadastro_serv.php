<?php

session_start();
$IP = $_SESSION['IP'];
$COMMUNITY = $_SESSION['COMMUNITY'];
$SNMP_V = $_SESSION['SNMP_V'];
$SNMP_HOSTNAME = $_SESSION['SNMP_HOSTNAME'];
$SO = $_SESSION['SO'];

$i=1;
if ($SNMP_V == "1" | $SNMP_V == "2c") {
	echo "<script>";
	$host=system('curl -k -s -u director:infraero@wan "https://icinga-master.noc.infranet.gov.br:5665/v1/objects/hosts?filter=match(%22'.$IP.'%22,host.address)&attrs=name&pretty=1" | grep name | sed -n 1p | cut -d"\"" -f4');
	echo "</script>";
	echo "<h1>SNMP Scan</h1>";
	echo "<pre>";
	echo "<strong>Host: </strong>".$IP."\n";
	echo "<strong>Community: </strong>".$COMMUNITY."\n";
	echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
        echo "<strong>SO: </strong>".$SO."\n";
        echo "<strong>Hostname: </strong>".$SNMP_HOSTNAME."\n";
	echo "<strong>Host Director: </strong>".$host."\n";
	echo "</pre>";
	echo   "<h2>Servicos</h2>";
	echo "<pre>";
	echo "<script>";
	if(!empty($_POST['service'])) {
	        foreach($_POST['service'] as $check) {
			system('icingacli director service create "'.$check.'" --imports "Serviços Windows" --vars.winserv_service "'.$check.'" --host "'.$host.'"');
                	echo $i." - ".$check."\n";
			$i++;
        	}
	}
	system('icingacli director config deploy');
	echo "</script>";
	$i=1;
	echo "<pre>";
	if(!empty($_POST['service'])) {
        	foreach($_POST['service'] as $check) {
                	echo "Servico ".$i." - ".$check." cadastrada com sucesso no Host: ".$host.".\n";
	                $i++;
        	}
	}
	echo "</pre>";
} else {
	echo "<script>";
	$host=system('curl -k -s -u director:infraero@wan "https://icinga-master.noc.infranet.gov.br:5665/v1/objects/hosts?filter=match(%22'.$IP.'%22,host.address)&attrs=name&pretty=1" | grep name | sed -n 1p | cut -d"\"" -f4');
	echo "</script>";
	echo "<h1>SNMP Scan</h1>";
	echo "<pre>";
	echo "<strong>Host: </strong>".$IP."\n";
	echo "<strong>Community: </strong>".$COMMUNITY."\n";
	echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
	echo "<strong>Host Director: </strong>".$host."\n";
	echo "</pre>";
	echo   "<h2>Interfaces</h2>";
	echo "<pre>";
	echo "<script>";
	if(!empty($_POST['interface'])) {
	        foreach($_POST['interface'] as $check) {
        	        system('icingacli director service create "'.$check.'" --imports "Interface" --vars.int_v3 "'.$check.'" --host "'.$host.'"');
                	echo $i." - ".$check."\n";
	                $i++;
        	}
	}
	system('icingacli director config deploy');
	echo "</script>";
	$i=1;
	echo "<pre>";
	if(!empty($_POST['interface'])) {
        	foreach($_POST['interface'] as $check) {
                	echo "Interface ".$i." - ".$check." cadastrada com sucesso no Host: ".$host.".\n";
	                $i++;
        	}
	}
	echo "</pre>";
}
?>
