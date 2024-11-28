<?php
    session_start();
	require 'fonction.php';

	$id=substr($_REQUEST["ID"],32);
	
	$sq="DELETE FROM $tbl_appproduit_sortie WHERE idcsortie='$id'";
	$r=mysqli_query($link,$sq);

	
	$sql5="DELETE FROM $tbl_apptransfert WHERE idcsortie='$id'";
    $result5=mysqli_query($link,$sql5);
	

	
?>
<?php
header("location: app_transfert_etape1.php");
?>