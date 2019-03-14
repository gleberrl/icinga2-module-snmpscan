<div class="content">
    <h1>SNMP SCAN</h1>
<?php

$SNMP_V = $_POST["SNMP_V"];
$IP = $_POST["IP"];
$COMMUNITY = $_POST["COMMUNITY"];
$protocol_security = $_POST["protocol_security"];
$protocol_key = $_POST["protocol_key"];
$security_level = $_POST["security_level"];
$username = $_POST["username"];
$authentication_passphrase = $_POST["authentication_passphrase"];
$protocol_passphrase = $_POST["protocol_passphrase"];
/*
$SNMP_V="2c";
$IP="10.0.19.38";
$COMMUNITY="cnsede";
*/
session_start();
$_SESSION['IP'] = $_POST['IP'];
$_SESSION['COMMUNITY'] = $_POST['COMMUNITY'];
$_SESSION['SNMP_V'] = $_POST['SNMP_V'];

if ($SNMP_V = 1 || $SNMP_V == "2c" ) {

	echo "<script>";
	$SO=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP '.1.3.6.1.2.1.1.1.0'");
        $SNMP_HOSTNAME=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.1.5.0");
        $_SESSION['SNMP_HOSTNAME'] = $SNMP_HOSTNAME;
        $_SESSION['SO'] = $SO;
	echo "</script>";
	if ( $SO != "") {
	        echo "<pre>";
	        echo "<strong>Host: </strong>".$IP."\n";
	        echo "<strong>Community: </strong>".$COMMUNITY."\n";
	        echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
                echo "<strong>SNMP Hostname: </strong>".$SNMP_HOSTNAME."\n";
	        echo "<strong>SO: </strong>".$SO;
	        echo "</pre>";
		echo "<script>";
		$disk_count=system("snmpwalk -Ovq -c $COMMUNITY -v $SNMP_V $IP '1.3.6.1.2.1.25.2.3.1.3' | wc -l");
		$i=2;
		$disk_index[1]=system("snmpgetnext -c $COMMUNITY -v $SNMP_V $IP '1.3.6.1.2.1.25.2.3.1.1' -Ovq");
		while ($i <= $disk_count) {
			$disk_index[$i]=system("snmpgetnext -c $COMMUNITY -v $SNMP_V $IP '1.3.6.1.2.1.25.2.3.1.1.${disk_index[$i-1]}' -Ovq");
			$i++;
		}
		$i=1;
		while ($i <= $disk_count) {
			$disk_unit[$i]=system("snmpget -c $COMMUNITY -v $SNMP_V $IP '1.3.6.1.2.1.25.2.3.1.3.${disk_index[$i]}' -Ovq");
			$i++;
		}
		echo "</script>";
                echo "<h2>Discos</h2>";
		echo "<pre>";
                echo '<form action="Cadastro_disco.php" method="post">';
                echo '<table><tr><th>Select |</th><th>ID |</th><th>Disk Unit</th>';
                $i=1;
                sort($disk_unit);
                while ( $i < $disk_count ) {
 			echo '<tr><td><input type="checkbox" name="disk[]" value="'.$disk_unit[$i].'"></td><td>'.$i.'</td><td>'.$disk_unit[$i].'</td>';
			$i++;
		}
		echo '</table>';
		echo "\n";
		echo '<p><input type="submit" name="submit" value="Cadastrar Discos" /></p>';
		echo "</form>";
		echo "</pre>";
        }
	else {
        	echo "<h2>Discos</h2>";
	        echo "<pre>";
        	echo "<strong>Host: </strong>".$IP."\n";
	        echo "<strong>Community: </strong>".$COMMUNITY."\n";
        	echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
	        echo "</pre>";
	        echo "<h2>Favor Verificar SNMP!</h2>";
	}
}
else if ($SNMP_V == 3) {

        echo "<script>";
        $SO=system("snmpget -Ovq $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '.1.3.6.1.2.1.1.1.0'");
        $SNMP_HOSTNAME=system("snmpget -Ovq $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.1.5.0");
        $_SESSION['SNMP_HOSTNAME'] = $SNMP_HOSTNAME;
        $_SESSION['SO'] = $SO;
        echo "</script>";
        if ( $SO != "") {
                echo "<pre>";
                echo "<strong>Host: </strong>".$IP."\n";
                echo "<strong>Community: </strong>".$COMMUNITY."\n";
                echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
                echo "<strong>SNMP Hostname: </strong>".$SNMP_HOSTNAME."\n";
                echo "<strong>SO: </strong>".$SO;
                echo "</pre>";
                echo "<script>";
                $disk_count=system("snmpwalk -Ovq $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '1.3.6.1.2.1.25.2.3.1.3' | wc -l");
                $i=2;
                $disk_index[1]=system("snmpgetnext $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '1.3.6.1.2.1.25.2.3.1.1' -Ovq");
                while ($i <= $disk_count) {
                        $disk_index[$i]=system("snmpgetnext $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '1.3.6.1.2.1.25.2.3.1.1.${disk_index[$i-1]}' -Ovq");
                        $i++;
                }
                $i=1;
                while ($i <= $disk_count) {
                        $disk_unit[$i]=system("snmpget $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '1.3.6.1.2.1.25.2.3.1.3.${disk_index[$i]}' -Ovq");
                        $i++;
                }
                echo "</script>";
                echo "<h2>Discos</h2>";
                echo "<pre>";
                echo '<form action="Cadastro_disco.php" method="post">';
                echo '<table><tr><th>Select |</th><th>ID |</th><th>Disk Unit</th>';
                $i=1;
                sort($disk_unit);
                while ( $i < $disk_count ) {
                        echo '<tr><td><input type="checkbox" name="disk[]" value="'.$disk_unit[$i].'"></td><td>'.$i.'</td><td>'.$disk_unit[$i].'</td>';
                        $i++;
                }
                echo '</table>';
                echo "\n";
                echo '<p><input type="submit" name="submit" value="Cadastrar Discos" /></p>';
                echo "</form>";
                echo "</pre>";
        }
        else {
                echo "<h2>Discos</h2>";
                echo "<pre>";
                echo "<strong>Host: </strong>".$IP."\n";
                echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
                echo "</pre>";
                echo "<h2>Favor Verificar SNMP!</h2>";
        }
}
?>
