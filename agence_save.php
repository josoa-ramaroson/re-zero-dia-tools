<?php
$a_nom=addslashes($_POST['a_nom']);
$a_adresse=addslashes($_POST['a_adresse']);
$a_tel=addslashes($_POST['a_tel']);
$a_statut=addslashes($_POST['a_statut']);
$datetime=date("y/m/d H:i:s");  
$id_nom=addslashes($_POST['id_nom']);
require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);

$sqlp="INSERT INTO $tbl_agence  ( id_nom   , a_nom   ,a_adresse,   a_tel   , a_statut   ,datetime )
                    VALUES       ('$id_nom','$a_nom', '$a_adresse', '$a_tel' ,'$a_statut' ,'$datetime')";
					
													
$r=mysqli_query($link, $sqlp)
or die(mysqli_error($link));
mysql_close($link);

?>
<?php
header("location: agence.php");
?>