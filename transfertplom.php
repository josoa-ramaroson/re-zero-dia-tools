 <?php
 
require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);

$sRequete ="INSERT INTO plombage (id, Police) SELECT id,Police FROM clienteda";
	$sresult1=mysqli_query($link, $sRequete);

?>

