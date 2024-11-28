 <?php
 
require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);

$sRequete ="update clienteda  SET   statut='7' WHERE CodeActivite!='Actif'";
	$sresult1=mysqli_query($link, $sRequete);

?>
