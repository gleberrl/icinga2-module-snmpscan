<div class="content">
    <h1>SNMP SCAN</h1>
<?php
	$Select = $_POST["Select"];
        $OPERADORA = $_POST["OPERADORA"];
	if ($Select == "Disco") {
?>
    <h2>Discos</h2>

<form method="post" action="Disco.php">
<div id="SNMP">
IP:
<input type="text" name="IP" /><br>
<br> SNMP Version: <input type="radio" name="SNMP_V" value="1" onchange="show_comm()"> 1
    <input type="radio" name="SNMP_V" value="2c" onchange="show_comm()"> 2c
    <input type="radio" name="SNMP_V" value="3" onchange="show_v3()" > 3<br><br>
</div>

<div id="caixa1" style="display: none;">
Community: <select name="COMMUNITY"><br>
  <option value="cnsede">Sede - cnsede</option>
  <option value="infraero21ebt">Embratel - infraero21ebt</option>
  <option value="cn1nfr@CQMRGRC">Embratel - cn1nfr@CQMRGRC</option>
  <option value="cninfra">Embratel - cninfra</option>
  <option value="cn1nfr@TNL">OI - cn1nfr@TNL</option>
</select><br><br>
</div>

<div id="caixa2" style="display: none;">
<p>SNMP Authentication Protocol:
<input type="radio" name="protocol_security" checked="checked" value="MD5" > MD5
<input type="radio" name="protocol_security" value="SHA" > SHA <br>
SNMP Privacy Protocol:
<input type="radio" name="protocol_key" checked="checked" value="DES" > DES
<input type="radio" name="protocol_key" value="AES" > AES <br>
SNMP Security Level:
<input type="radio" name="security_level" value="noAuthNoPriv" > noAuthNoPriv
<input type="radio" name="security_level" value="authNoPriv" > authNoPriv
<input type="radio" name="security_level" checked="checked" value="authPriv" > authPriv </p>
Username:
<input type="text" name="username" /><br/><br>
Authentication Pass Phrase:
<input type="text" name="authentication_passphrase" /><br/><br>
Privacy Protocol Pass Phrase:
<input type="text" name="protocol_passphrase" /><br/><br>
</div>

<p><input type="submit" name="submit" /></p>
</form>
<?php
}
        else if ($Select == "Interface") {
?>
    <h2>Interfaces</h2>
<form method="post" action="Interface_read.php">
<div id="SNMP">
IP:
<input type="text" name="IP" /><br>
<br> SNMP Version: <input type="radio" name="SNMP_V" value="1" onchange="show_comm()"> 1
    <input type="radio" name="SNMP_V" value="2c" onchange="show_comm()"> 2c
    <input type="radio" name="SNMP_V" value="3" onchange="show_v3()" > 3<br><br>
</div>

<div id="caixa1" style="display: none;">
Community: <select name="COMMUNITY"><br>
  <option value="cnsede">Sede - cnsede</option>
  <option value="infraero21ebt">Embratel - infraero21ebt</option>
  <option value="cn1nfr@CQMRGRC">Embratel - cn1nfr@CQMRGRC</option>
  <option value="cninfra">Embratel - cninfra</option>
  <option value="cn1nfr@TNL">OI - cn1nfr@TNL</option>
</select><br><br>
</div>


<div id="caixa2" style="display: none;">
<p>SNMP Authentication Protocol:
<input type="radio" name="protocol_security" checked="checked" value="MD5" > MD5
<input type="radio" name="protocol_security" value="SHA" > SHA <br>
SNMP Privacy Protocol:
<input type="radio" name="protocol_key" checked="checked" value="DES" > DES
<input type="radio" name="protocol_key" value="AES" > AES <br>
SNMP Security Level:
<input type="radio" name="security_level" value="noAuthNoPriv" > noAuthNoPriv
<input type="radio" name="security_level" value="authNoPriv" > authNoPriv
<input type="radio" name="security_level" checked="checked" value="authPriv" > authPriv </p>
Username:
<input type="text" name="username" /><br/><br>
Authentication Pass Phrase:
<input type="text" name="authentication_passphrase" /><br/><br>
Privacy Protocol Pass Phrase:
<input type="text" name="protocol_passphrase" /><br/><br>
</div>

<p><input type="submit" name="submit" /></p>
</form>

<?php
}
        else if ($Select == "Processo") {
?>
    <h2>Processos</h2>
<form method="post" action="Processo.php">
<div id="SNMP">
IP:
<input type="text" name="IP" /><br>
<br> SNMP Version: <input type="radio" name="SNMP_V" value="1" onchange="show_comm()"> 1
    <input type="radio" name="SNMP_V" value="2c" onchange="show_comm()"> 2c
    <input type="radio" name="SNMP_V" value="3" onchange="show_v3()" > 3<br><br>
</div>

<div id="caixa1" style="display: none;">
Community: <select name="COMMUNITY"><br>
  <option value="cnsede">Sede - cnsede</option>
  <option value="infraero21ebt">Embratel - infraero21ebt</option>
  <option value="cn1nfr@CQMRGRC">Embratel - cn1nfr@CQMRGRC</option>
  <option value="cninfra">Embratel - cninfra</option>
  <option value="cn1nfr@TNL">OI - cn1nfr@TNL</option>
</select><br><br>
</div>


<div id="caixa2" style="display: none;">
<p>SNMP Authentication Protocol:
<input type="radio" name="protocol_security" checked="checked" value="MD5" > MD5
<input type="radio" name="protocol_security" value="SHA" > SHA <br>
SNMP Privacy Protocol:
<input type="radio" name="protocol_key" checked="checked" value="DES" > DES
<input type="radio" name="protocol_key" value="AES" > AES <br>
SNMP Security Level:
<input type="radio" name="security_level" value="noAuthNoPriv" > noAuthNoPriv
<input type="radio" name="security_level" value="authNoPriv" > authNoPriv
<input type="radio" name="security_level" checked="checked" value="authPriv" > authPriv </p>
Username:
<input type="text" name="username" /><br/><br>
Authentication Pass Phrase:
<input type="text" name="authentication_passphrase" /><br/><br>
Privacy Protocol Pass Phrase:
<input type="text" name="protocol_passphrase" /><br/><br>
</div>

<p><input type="submit" name="submit" /></p>
</form>
<?php
}
        else if ($Select == "Servico") {
?>
    <h2>Servicos</h2>
<form method="post" action="Servico.php">
<div id="SNMP">
IP:
<input type="text" name="IP" /><br>
<br> SNMP Version: <input type="radio" name="SNMP_V" value="1" onchange="show_comm()"> 1 
    <input type="radio" name="SNMP_V" value="2c" onchange="show_comm()"> 2c
    <input type="radio" name="SNMP_V" value="3" onchange="show_v3()" > 3<br><br>
</div>

<div id="caixa1" style="display: none;"> 
Community:
<select name="COMMUNITY"><br>
  <option value="cnsede">Sede - cnsede</option>
  <option value="infraero21ebt">Embratel - infraero21ebt</option>
  <option value="cn1nfr@CQMRGRC">Embratel - cn1nfr@CQMRGRC</option>
  <option value="cninfra">Embratel - cninfra</option>
  <option value="cn1nfr@TNL">OI - cn1nfr@TNL</option>
</select><br><br>
</div>

<div id="caixa2" style="display: none;">
<p>SNMP Authentication Protocol:
<input type="radio" name="protocol_security" checked="checked" value="MD5" > MD5
<input type="radio" name="protocol_security" value="SHA" > SHA <br>
SNMP Privacy Protocol:
<input type="radio" name="protocol_key" checked="checked" value="DES" > DES
<input type="radio" name="protocol_key" value="AES" > AES <br>
SNMP Security Level:
<input type="radio" name="security_level" value="noAuthNoPriv" > noAuthNoPriv
<input type="radio" name="security_level" value="authNoPriv" > authNoPriv
<input type="radio" name="security_level" checked="checked" value="authPriv" > authPriv </p>
Username:
<input type="text" name="username" /><br/><br>
Authentication Pass Phrase:
<input type="text" name="authentication_passphrase" /><br/><br>
Privacy Protocol Pass Phrase:
<input type="text" name="protocol_passphrase" /><br/><br>
</div>

<p><input type="submit" name="submit" /></p>
</form>

<?php
}
?>

<script type='text/javascript'>

function show_comm(str){ 
			document.getElementById('caixa1').style.display="block";  
			document.getElementById('caixa2').style.display="none";
}
function show_v3(str){ 
			document.getElementById('caixa1').style.display="none";  
			document.getElementById('caixa2').style.display="block"; 
}  
  
</script>

</div>
