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
	echo   "<h2>Discoss</h2>";
	echo "<pre>";
/*        echo "<script>";
	$FIND="Windows";
	$pos = strpos($SO, $FIND);
	if ($pos == false) {
		$SO_T="linux";
	}
	else {
		$SO_T="windows";
	}
	echo "</script>";*/
        if ($host == "") {
                echo "<strong>Host nao cadastrado com IP da consulta. Favor refazer a consulta com IP correto.</strong>";
        }
        else {
	echo "<script>";
	if(!empty($_POST['disk'])) {
//		if ($SO_T == "windows") {
		        foreach($_POST['disk'] as $check) {
				system('icingacli director service create "'.$check.'" --imports "Disco" --vars.snmp_disk_unit "'.$check.'" --vars.snmp_disk_noregexp true --host "'.$host.'"');
                		echo $i." - ".$check."\n";
				$i++;
	        	}
//		}
/*		else if ($SO_T == "linux") {
                        foreach($_POST['process'] as $check) {
                                system('icingacli director service create "'.$check.'" --imports "Serviços Linux" --vars.linux_serv_service "'.$check.'" --host "'.$host.'"');
                                echo $i." - ".$check."\n";
                                $i++;
                        }
                }*/
	}
	system('icingacli director config deploy');
	echo "</script>";
	$i=1;
	echo "<pre>";
	if(!empty($_POST['disk'])) {
        	foreach($_POST['disk'] as $check) {
                	echo "Disco ".$i." - ".$check." cadastrado com sucesso no Host: ".$host.".\n";
	                $i++;
        	}
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
        echo "<strong>SNMP Hostname: </strong>".$SNMP_HOSTNAME."\n";
        echo "<strong>SO: </strong>".$SO."\n";
	echo "<strong>Host Director: </strong>".$host."\n";
	echo "</pre>";
	echo   "<h2></h2>";
	echo "<pre>";
	if ($host == "") {
		echo "<strong>Host nãcadastrado com IP da consulta. Favor refazer a consulta com IP correto.</strong>";
	}
	else {
        echo "<script>";
	if(!empty($_POST['disk'])) {
	        foreach($_POST['disk'] as $check) {
        	        system('icingacli director service create "'.$check.'" --imports "Disco" --vars.snmp_disk_unit "'.$check.'" --vars.snmp_disk_noregexp true --host "'.$host.'"');
                	echo $i." - ".$check."\n";
	                $i++;
        	}
	}
	system('icingacli director config deploy');
	echo "</script>";
	$i=1;
	echo "<pre>";
	if(!empty($_POST['disk'])) {
        	foreach($_POST['disk'] as $check) {
                	echo "Disco ".$i." - ".$check." cadastrado com sucesso no Host: ".$host.".\n";
	                $i++;
        	}
	}
	}
	echo "</pre>";
}
?>
