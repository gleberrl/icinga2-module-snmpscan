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

if ($SNMP_V == 1 || $SNMP_V == "2c") {
	echo "<script>";
	$SO=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.1.1.0");
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
		if ( $SNMP_V == 1 || $SNMP_V == "2c" ) {
			$process_count=system("snmpwalk -Ovq -c $COMMUNITY -v $SNMP_V $IP 1.3.6.1.2.1.25.4.2.1.1 | wc -l");
			$i=2;
			$process_index_i[1]=1;
	                while ( $i <= $process_count ) {
				$process_index_i[$i]=system("snmpgetnext -Ovq -c $COMMUNITY -v $SNMP_V $IP 1.3.6.1.2.1.25.4.2.1.1.${process_index_i[$i-1]}");
				$i++;
			}
        	        $i=1;
			while ( $i <= $process_count ) {
				$process_name[$i]=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP 1.3.6.1.2.1.25.4.2.1.2.${process_index_i[$i]} | cut -d'\"' -f2");
				$i++;
			}
	        	echo "</script>";
	                echo "<h2>Processos</h2>";
        	        echo "<pre>";
	                echo '<form action="Cadastro_proc.php" method="post">';
	                echo '<table><tr><th>Select |</th><th>ID |</th><th>Process</th>';
                	$i=1;
			sort($process_name);
        	        while ( $i < $process_count ) {
	                echo '<tr><td><input type="checkbox" name="process[]" value="'.$process_name[$i].'"></td><td>'.$i.'</td><td>'.$process_name[$i].'</td>';
                        	$i++;
	                }
	                echo '</table>';
        	        echo "\n";
                	echo '<p><input type="submit" name="submit" value="Cadastrar Processos" /></p>';
	                echo "</form>";
			echo "</pre>";
	        }
	}
	else {
        	echo "<h2>Processos</h2>";
	        echo "<pre>";
        	echo "<strong>Host: </strong>".$IP."\n";
	        echo "<strong>Community: </strong>".$COMMUNITY."\n";
        	echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
	        echo "</pre>";
        	echo "<h2>Favor Verificar SNMP!</h2>";
	}
}
if ($SNMP_V == 3) {
        echo "<script>";
        $SO=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.1.1.0");
	$SNMP_HOSTNAME=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.1.5.0");
        $_SESSION['SNMP_HOSTNAME'] = $SNMP_HOSTNAME;
        $_SESSION['SO'] = $SO;
        echo "</script>";

        if ( $SO != "") {
                echo "<pre>";
                echo "<strong>Host: </strong>".$IP."\n";
                echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
                echo "<strong>SNMP Hostname: </strong>".$SNMP_HOSTNAME."\n";
                echo "<strong>SO: </strong>".$SO;
                echo "</pre>";
                echo "<script>";
                if ( $SNMP_V == 3 ) {
                        $process_count=system("snmpwalk -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP 1.3.6.1.2.1.25.4.2.1.1 | wc -l");
                        $i=2;
                        $process_index_i[1]=1;
                        while ( $i <= $process_count ) {
                                $process_index_i[$i]=system("snmpgetnext -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP 1.3.6.1.2.1.25.4.2.1.1.${process_index_i[$i-1]}");
                                $i++;
                        }
                        $i=1;
                        while ( $i <= $process_count ) {
                                $process_name[$i]=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP 1.3.6.1.2.1.25.4.2.1.2.${process_index_i[$i]} | cut -d'\"' -f2");
                                $i++;
                        }
                        echo "</script>";
                        echo "<h2>Processos</h2>";
                        echo "<pre>";
                        echo '<form action="Cadastro_proc.php" method="post">';
                        echo '<table><tr><th>Select |</th><th>ID |</th><th>Process</th>';
                        $i=1;
                        sort($process_name);
                        while ( $i < $process_count ) {
				echo '<tr><td><input type="checkbox" name="process[]" value="'.$process_name[$i].'"></td><td>'.$i.'</td><td>'.$process_name[$i].'</td>';
                                $i++;
                        }
                        echo '</table>';
                        echo "\n";
                        echo '<p><input type="submit" name="submit" value="Cadastrar Processos" /></p>';
                        echo "</form>";
                        echo "</pre>";
                }
        }
        else {
                echo "<h2>Processos</h2>";
                echo "<pre>";
                echo "<strong>Host: </strong>".$IP."\n";
                echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
                echo "</pre>";
                echo "<h2>Favor Verificar SNMP!</h2>";
        }
}
?>
