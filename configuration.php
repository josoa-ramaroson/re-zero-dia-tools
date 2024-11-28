<?php
//----------------parametre de configuration--------
$sqlconf = "SELECT * FROM $tbl_config";
$resultconf = mysqli_query($link, $sqlconf);
while ($rowconf = mysqli_fetch_assoc($resultconf)) {
$anneec=$rowconf['annee'];
$ci=$rowconf['ci'];
$nserie=$rowconf['nserie'];
$cserie=$rowconf['cserie'];
$datec=$rowconf['date'];
$datcoupure=$rowconf['datelimite'];
} 
//--------------------------------------------------- 
?>