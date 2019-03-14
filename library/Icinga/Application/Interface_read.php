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
$_SESSION['SNMP_MODEL'] = $_POST['SNMP_MODEL'];
$_SESSION['SNMP_HOSTNAME'] = $_POST['SNMP_HOSTNAME'];
/*
$SNMP_V = 3;
$IP = "10.0.97.254";
$protocol_security = "MD5";
$protocol_key = "DES";
$security_level = "authPriv";
$username = "TIST";
$authentication_passphrase = "CNSEDESU";
$protocol_passphrase = "CNSEDERW";
*/

if ( $SNMP_V == 1 || $SNMP_V == "2c" ) {
echo "<script>";
$SNMP_MODEL_T=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP '.1.3.6.1.2.1.1.1.0' -t 1 -r 3");
echo "</script>";
	if ($SNMP_MODEL_T != "") {
		echo "<script>";
	        $SNMP_MODEL=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP '.1.3.6.1.2.1.1.1.0' | sed -n 1p");
	        $SNMP_HOSTNAME=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP '.1.3.6.1.2.1.1.5.0'");
	        $SNMP_INT_NUMBER=system("snmpwalk -Ovq -c $COMMUNITY -v $SNMP_V $IP '.1.3.6.1.2.1.2.2.1.1' | wc -l");
                $snmp_ifindex[1]=system("snmpgetnext -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.2.2.1.1");
                $i=2;
		while ( $i <= $SNMP_INT_NUMBER ) {
			$snmp_ifindex[$i]=system("snmpgetnext -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.2.2.1.1.${snmp_ifindex[$i-1]}");
			if ( $snmp_ifindex[$i] == "No Such Object available on this agent at this OID" ) {
				$snmp_ifindex[$i] = "";
			}
		$i++;
		}

                $i=1;
                while ( $i <= $SNMP_INT_NUMBER ) {
			$snmp_ifname[$i]=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.31.1.1.1.1.${snmp_ifindex[$i]}"); //ifname
                        if ( $snmp_ifname[$i] == "No Such Object available on this agent at this OID" ) {
                                $snmp_ifname[$i] = "";
                        }
		$i++;
		}

                $i=1;
                while ( $i <= $SNMP_INT_NUMBER ) {
                        $snmp_ifdescr[$i]=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.2.2.1.2.${snmp_ifindex[$i]}"); //ifdescr
                        if ( $snmp_ifdescr[$i] == "No Such Object available on this agent at this OID" ) {
                                $snmp_ifdescr[$i] = "";
                        }
                $i++;
                }

                $i=1;
                while ( $i <= $SNMP_INT_NUMBER ) {
                        $snmp_ifalias[$i]=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.31.1.1.1.18.${snmp_ifindex[$i]}"); //ifalias
                        if ( $snmp_ifalias[$i] == "No Such Object available on this agent at this OID" ) {
                                $snmp_ifalias[$i] = "";
                        }
                $i++;
                }

                $i=1;
                while ( $i <= $SNMP_INT_NUMBER ) {
                        $snmp_ifstatus[$i]=system("snmpget -Ovq -c $COMMUNITY -v $SNMP_V $IP .1.3.6.1.2.1.2.2.1.7.${snmp_ifindex[$i]}"); //ifadminstatus
                        if ( $snmp_ifstatus[$i] == "No Such Object available on this agent at this OID" ) {
                                $snmp_ifstatus[$i] = "";
                        }
                $i++;
                }
     		echo "</script>";
	        echo "<pre>";
        	echo "<strong>Host: </strong>".$IP."\n";
	        echo "<strong>Community: </strong>".$COMMUNITY."\n";
        	echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
	        echo "<strong>Hostname: </strong>".$SNMP_HOSTNAME."\n";
        	echo "<strong>SO/Equipamento: </strong>".$SNMP_MODEL."\n";
	        echo "</pre>";
		echo   "<h2>Interfaces</h2>";
		echo "<pre>";
		echo '<form action="Cadastro_int.php" method="post">';
		echo '<table><tr><th>Select |</th><th>Interface Name |</th><th>Interface Full Name |</th><th>Interface Description |</th><th>Interface Admin Status</th>';
                $enterasys=strpos($SNMP_MODEL, "Enterasys");
                $extreme=strpos($SNMP_MODEL, "Extreme");
                if ($extreme !== false || $enterasys !== false) {
	                $i=1;   
        	        while ( $i <= $SNMP_INT_NUMBER ) {
                                $snmp_ifdescr[$i]=$snmp_ifname[$i];				
	        	        echo '<tr><td><input type="checkbox" name="interface[]" value="'.$snmp_ifdescr[$i].'"></td><td>'.$snmp_ifname[$i].'</td><td>'.$snmp_ifdescr[$i].'</td><td>'.$snmp_ifalias[$i].'</td><td>'.$snmp_ifstatus[$i].'</td></tr>';
				$i++;
			}
		} else {
                        $i=1;
                        while ( $i <= $SNMP_INT_NUMBER ) {
                                echo '<tr><td><input type="checkbox" name="interface[]" value="'.$snmp_ifdescr[$i].'"></td><td>'.$snmp_ifname[$i].'</td><td>'.$snmp_ifdescr[$i].'</td><td>'.$snmp_ifalias[$i].'</td><td>'.$snmp_ifstatus[$i].'</td></tr>';
                                $i++;
                        }
		}
		echo '</table>';
                echo "\n";
                echo '<p><input type="submit" name="submit" value="Cadastrar Interfaces" /></p>';
                echo "</form>";
		echo "</pre>";
        }
	else {
        	echo "<pre>";
	        echo "<strong>Host: </strong>".$IP."\n";
	        echo "<strong>Community: </strong>".$COMMUNITY."\n";
	        echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
	        echo "</pre>";
	        echo "<h2>Favor Verificar o SNMP!</h2>";
	}
}

else if ( $SNMP_V == 3 ) {
echo "<script>";
$SNMP_MODEL_T=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '.1.3.6.1.2.1.1.1.0' -t 1 -r 3");
echo "</script>";
        if ($SNMP_MODEL_T != "") {
                echo "<script>";
                $SNMP_MODEL=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '.1.3.6.1.2.1.1.1.0' | sed -n 1p");
                $SNMP_HOSTNAME=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '.1.3.6.1.2.1.1.5.0'");
                $SNMP_INT_NUMBER=system("snmpwalk -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP '.1.3.6.1.2.1.2.2.1.1' | wc -l");
		$snmp_ifindex[1]=system("snmpgetnext -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.2.2.1.1");
                $i=2;
                while ( $i <= $SNMP_INT_NUMBER ) {
                        $snmp_ifindex[$i]=system("snmpgetnext -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.2.2.1.1.${snmp_ifindex[$i-1]}");
                        if ( $snmp_ifindex[$i] == "No Such Object available on this agent at this OID" ) {
                                $snmp_ifindex[$i] = "";
                        }
                $i++;
                }

                $i=1;
                while ( $i <= $SNMP_INT_NUMBER ) {
                        $snmp_ifname[$i]=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.31.1.1.1.1.${snmp_ifindex[$i]}"); //ifname
                        if ( $snmp_ifname[$i] == "No Such Object available on this agent at this OID" ) {
                                $snmp_ifname[$i] = "";
                        }
                $i++;
                }

                $i=1;
                while ( $i <= $SNMP_INT_NUMBER ) {
                        $snmp_ifdescr[$i]=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.2.2.1.2.${snmp_ifindex[$i]}"); //ifdescr
                        if ( $snmp_ifdescr[$i] == "No Such Object available on this agent at this OID" ) {
                                $snmp_ifdescr[$i] = "";
                        }
                $i++;
                }

                $i=1;
                while ( $i <= $SNMP_INT_NUMBER ) {
                        $snmp_ifalias[$i]=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.31.1.1.1.18.${snmp_ifindex[$i]}"); //ifalias
                        if ( $snmp_ifalias[$i] == "No Such Object available on this agent at this OID" ) {
                                $snmp_ifalias[$i] = "";
                        }
                $i++;
                }

                $i=1;
                while ( $i <= $SNMP_INT_NUMBER ) {
                        $snmp_ifstatus[$i]=system("snmpget -Ovq -a $protocol_security -A $authentication_passphrase -l $security_level -x $protocol_key -X $protocol_passphrase -u $username -v $SNMP_V $IP .1.3.6.1.2.1.2.2.1.7.${snmp_ifindex[$i]}"); //ifadminstatus
                        if ( $snmp_ifstatus[$i] == "No Such Object available on this agent at this OID" ) {
                                $snmp_ifstatus[$i] = "";
                        }
                $i++;
                }
                echo "</script>";
                echo "<pre>";
                echo "<strong>Host: </strong>".$IP."\n";
                echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
                echo "<strong>Hostname: </strong>".$SNMP_HOSTNAME."\n";
                echo "<strong>SO/Equipamento: </strong>".$SNMP_MODEL."\n";
                echo "</pre>";
                echo   "<h2>Interfaces</h2>";
                echo "<pre>";
		echo '<form action="Cadastro_int.php" method="post">';
                echo '<table><tr><th>Select |</th><th>Interface Name |</th><th>Interface Full Name |</th><th>Interface Description |</th><th>Interface Admin Status</th>';
		$enterasys=strpos($SNMP_MODEL, "Enterasys");
		$extreme=strpos($SNMP_MODEL, "Extreme");
		if ($extreme !== false || $enterasys !== false) {
	                $i=1;
       		        while ( $i <= $SNMP_INT_NUMBER ) {
				$snmp_ifdescr[$i]=$snmp_ifname[$i];
				echo '<tr><td><input type="checkbox" name="interface[]" value="'.$snmp_ifdescr[$i].'"></td><td>'.$snmp_ifname[$i].'</td><td>'.$snmp_ifdescr[$i].'</td><td>'.$snmp_ifalias[$i].'</td><td>'.$snmp_ifstatus[$i].'</td></tr>';
                        	$i++;
	                }
		}
		else {
                        $i=1;
                        while ( $i <= $SNMP_INT_NUMBER ) {
                                echo '<tr><td><input type="checkbox" name="interface[]" value="'.$snmp_ifdescr[$i].'"></td><td>'.$snmp_ifname[$i].'</td><td>'.$snmp_ifdescr[$i].'</td><td>'.$snmp_ifalias[$i].'</td><td>'.$snmp_ifstatus[$i].'</td></tr>';
                                $i++;
                        }
		}
                echo '</table>';
                echo "\n";
                echo '<p><input type="submit" name="submit" value="Cadastrar Interfaces" /></p>';
                echo "</form>";
                echo "</pre>";
        }
        else {
                echo "<pre>";
                echo "<strong>Host: </strong>".$IP."\n";
                echo "<strong>Community: </strong>".$COMMUNITY."\n";
                echo "<strong>SNMP Version: </strong>".$SNMP_V."\n";
                echo "</pre>";
                echo "<h2>Favor Verificar o SNMP!</h2>";
        }
}
?>
