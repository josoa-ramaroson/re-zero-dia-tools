 <?php
 
require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);

$sRequete ="INSERT INTO billingsave (id, ci, st , nserie, annee , nfacture) SELECT id, ci, st, nserie, fannee, nfacture FROM billing";
	$sresult1=mysqli_query($link, $sRequete);


?>

