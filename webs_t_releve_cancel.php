<?php
    session_start();
    require 'fonction.php';
	$id=substr($_REQUEST["ID"],32);
	$sql5="DELETE FROM $tbl_releve_bach WHERE idpb='$id'";
    $result5=mysqli_query($link,$sql5);
    if($result5){
    //echo " cancel ";
    }
    else {
    echo "ERROR";
    }
	mysqli_close($link);
    ?>
<?php
header("location: webs_t_releve.php");
?>