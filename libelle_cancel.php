<?php
    session_start();
    require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);
	$id=substr($_REQUEST["ID"],32);
	$sql5="DELETE FROM $tbl_libelle WHERE idL='$id'";
    $result5=mysqli_query($link, $sql5);
    if($result5){
    //echo " cancel ";
    }
    else {
    echo "ERROR";
    }
    ?>
<?php
header("location: libelle.php");
?>