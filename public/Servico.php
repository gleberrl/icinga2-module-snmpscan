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

session_start();
$_SESSION['IP'] = $_POST['IP'];
$_SESSION['COMMUNITY'] = $_POST['COMMUNITY'];
$_SESSION['SNMP_V'] = $_POST['SNMP_V'];
$_SESSION['SO'] = $_POST['SO'];
$_SESSION['SNMP_HOSTNAME'] = $_POST['SNMP_HOSTNAME'];

if ($SNMP_V == 1 || $SNMP_V == "2c") {
	echo "<script>";
	$SNMP_HOSTNAME=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.1.5.0");
	$SO=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.1.1.0");
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
		$service_count=system("snmpwalk -Ovq -c $COMMUNITY -v $SNMP_V $IP 1.3.6.1.4.1.77.1.2.3.1.1 | wc -l");
       	        $i=2;
		$service_index[1]=system("snmpgetnext -On -c $COMMUNITY -v $SNMP_V $IP '1.3.6.1.4.1.77.1.2.3.1.1' | cut -d'.' -f14- | cut -d' ' -f1 | sed -n 1p");
		while ( $i <= $service_count ) {
			$service_index[$i]=system("snmpgetnext -OnT -c $COMMUNITY -v $SNMP_V $IP 1.3.6.1.4.1.77.1.2.3.1.1.${service_index[$i-1]} | cut -d'.' -f14- | cut -d' ' -f1 | sed -n 1p");
			$i++;
		}
		$i=1;
                while ( $i <= $service_count ) {
                        $service_name[$i]=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP 1.3.6.1.4.1.77.1.2.3.1.1.${service_index[$i]} | cut -d'\"' -f2");
                        $i++;
                }
	        echo "</script>";
                echo "<h2>Servicos</h2>";
                echo "<pre>";
		echo '<form action="Cadastro_serv.php" method="post">';
		echo '<table><tr><th>Select |</th><th>ID |</th><th>Service</th>';
                $i=1;
		sort($service_name);

                while ( $i < $service_count ) {
		echo '<tr><td><input type="checkbox" name="service[]" value="'.$service_name[$i].'"></td><td>'.$i.'</td><td>'.$service_name[$i].'</td>';
                        $i++;
                }
		echo '</table>';
                echo "\n";
                echo '<p><input type="submit" name="submit" value="Cadastrar Servicos" /></p>';
                echo "</form>";
		echo "</pre>";
        }
	else {
	        echo "<h2>Servicos</h2>";
	        echo "<pre>";
	        echo "<strong>Host: </strong>".$IP."\n";
	        echo "<strong>Community: </strong>".$COMMUNITY."\n";
        	echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
	        echo "</pre>";
	        echo "<h2>Favor Verificar SNMP!</h2>";
	}
}
else if ($SNMP_V == 3 ) {
        echo "<script>";
        $SNMP_HOSTNAME=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.1.5.0");
        $SO=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.1.1.0");
        echo "</script>";

        if ( $SO != "") {
                echo "<pre>";
                echo "<strong>Host: </strong>".$IP."\n";
                echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
                echo "<strong>SNMP Hostname: </strong>".$SNMP_HOSTNAME."\n";
                echo "<strong>SO: </strong>".$SO;
                echo "</pre>";
                echo "<script>";
                $service_count=system("snmpwalk -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP 1.3.6.1.4.1.77.1.2.3.1.1 | wc -l");
                $i=2;   
                $service_index[1]=system("snmpgetnext -On -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '1.3.6.1.4.1.77.1.2.3.1.1' | cut -d'.' -f14- | cut -d' ' -f1 | sed -n 1p");
                while ( $i <= $service_count ) {
                        $service_index[$i]=system("snmpgetnext -OnT -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP 1.3.6.1.4.1.77.1.2.3.1.1.${service_index[$i-1]} | cut -d'.' -f14- | cut -d' ' -f1 | sed -n 1p");
                        $i++;
                }
                $i=1;
                while ( $i <= $service_count ) {
                        $service_name[$i]=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP 1.3.6.1.4.1.77.1.2.3.1.1.${service_index[$i]} | cut -d'\"' -f2");
                        $i++;
                }
                echo "</script>";
                echo "<h2>Servicos</h2>";
                echo "<pre>";
                echo '<form action="Cadastro_serv.php" method="post">';
                echo '<table><tr><th>Select |</th><th>ID |</th><th>Service</th>';
                $i=1;
                sort($service_name);
                while ( $i < $service_count ) {
                echo '<tr><td><input type="checkbox" name="service[]" value="'.$service_name[$i].'"></td><td>'.$i.'</td><td>'.$service_name[$i].'</td>';
                        $i++;
                }
                echo '</table>';
                echo "\n";
                echo '<p><input type="submit" name="submit" value="Cadastrar Servicos" /></p>';
                echo "</form>";
                echo "</pre>";
        }
        else {
                echo "<h2>Servicos</h2>";
                echo "<pre>";
                echo "<strong>Host: </strong>".$IP."\n";
                echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
                echo "</pre>";
                echo "<h2>Favor Verificar SNMP!</h2>";
        }
}
?>
