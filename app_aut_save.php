<?php
$date=addslashes($_POST['date']);
$service=addslashes($_POST['service']);
$Nature=addslashes($_POST['Nature']);
$Motif=addslashes($_POST['Motif']);
$Montant=addslashes($_POST['Montant']);
$id_nom=addslashes($_POST['id_nom']);

require 'fonction.php';
$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);

$sqlp="INSERT INTO $tbl_appaut   ( id_nom   , service    ,  Nature   , Motif  , Montant ,date )
                    VALUES       ('$id_nom','$service',  '$Nature' ,'$Motif' ,'$Montant','$date')";
					
													
$r=mysqli_query($link, $sqlp)
or die(mysql_error());
mysql_close($link);

?>
<?php
header("location: app_aut.php");
?>