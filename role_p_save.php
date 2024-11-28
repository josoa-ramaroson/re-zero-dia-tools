<?php

$id_u=addslashes($_POST['id_u']);
$datetime=date("y/m/d H:i:s");  
$id_nom=addslashes($_POST['id_nom']);

require 'fonction.php';


echo $sqlcomp = "SELECT count(*) FROM $tb_role_user  WHERE  id_u='$id_u' ";  
$resultatcomp = mysqli_query($link,$sqlcomp) or die('Erreur SQL !<br />'.$sqlcomp.'<br />'.mysqli_error());  
$nb_total = mysqli_fetch_array($resultatcomp);  


if (($nb_total = $nb_total[0]) == 0) {   



    $sql="SELECT * FROM $tbl_utilisateur WHERE id_u='$id_u'" ;
	$resultat= mysqli_query($link,$sql);
    $row = mysqli_fetch_array($resultat);
	echo $u_niveau=$row['u_niveau'];
	
	$sqlu="SELECT * FROM $tb_role_type WHERE niveau='$u_niveau'" ;
	$resultatu= mysqli_query($link,$sqlu);
    $rowu = mysqli_fetch_array($resultatu);
	echo $id_role=$rowu['id_role'];
	
	$r_p=1;

$sqlp="INSERT INTO $tb_role_user ( id_nom   , id_role , id_u, r_p, datetime )
                    VALUES       ('$id_nom','$id_role' ,'$id_u',  '$r_p', '$datetime')";
					
													
$r=mysqli_query($link,$sqlp)or die(mysqli_error($link));
mysqli_close($link);



} 
  else 

{  
header("location: role.php");

}  



?>
<?php
header("location: role.php");
?>