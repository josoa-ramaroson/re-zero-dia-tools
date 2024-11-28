 <?php
 
require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);

$sRequete ="INSERT INTO billing (id, Police , bnom , bquartier, nf, date ) SELECT id, Police, nomprenom, quartier , Indexinitial, '2015-08-12' FROM clienteda";
	$sresult1=mysqli_query($link, $sRequete);

?>

