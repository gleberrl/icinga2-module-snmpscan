<div class="content">
    <h1>SNMP SCAN</h1>
<?php
        $SO = $_POST["SO"];
	$IP = $_POST["IP"];
        $COMMUNITY = $_POST["COMMUNITY"];
        echo "<pre>";
	echo "Host: ".$IP."\n";
        echo "Community: ".$COMMUNITY."\n";
	echo "SO: ".$SO;
        echo "</pre>";
?>
    <h2>Discos</h2>
<?php
	if ( $SO == "windows" ) {
	        echo "<pre>";
        	$snmp=system("snmpwalk -Ovq -c $COMMUNITY -v 2c $IP '1.3.6.1.2.1.25.2.3.1.3' | grep Label");
	        echo "</pre>";
	} elseif ( $SO == "linux" ) {
                echo "<pre>";
                $snmp=system("snmpwalk -Ovq -c $COMMUNITY -v 2c $IP '1.3.6.1.2.1.25.2.3.1.3' | grep /");
                echo "</pre>";
	}
?>
</div>
