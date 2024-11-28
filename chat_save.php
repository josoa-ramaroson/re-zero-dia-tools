<?php
// Enregistrer des informations
$SID1=addslashes($_POST['SID1']);
$SID2=addslashes($_POST['SID2']);
$SID3=addslashes($_POST['SID3']);
$message=addslashes($_POST['message']);
require 'chat_smileys.php';
$nbligne=addslashes($_POST['nbligne']);
$datetime=date("y/m/d h:i:s"); 
	require 'fonction.php';

$link = mysqli_connect ($host,$user,$pass);
mysqli_select_db($link, $db);
$sql="INSERT INTO $tbl_message (SID1,SID2,message,datetime) VALUES('$SID1','$SID2','$message','$datetime')";
$result=mysqli_query($link, $sql);

$sqlnb = "SELECT count(*) FROM $tbl_ind where sid1=$SID1 and   sid2=$SID2 ";
$reqnb = mysqli_query($link, $sqlnb);
$datanb = mysqli_fetch_array($reqnb);
mysqli_free_result($reqnb);
 
if ($datanb[0]) { 
   $sqlnb="UPDATE  $tbl_ind SET nbligne= $nbligne WHERE sid1=$SID1 and sid2=$SID2";
    $reqnb = mysqli_query($link, $sqlnb);
}  
else {  
   $sqlnb="INSERT INTO $tbl_ind (SID1,SID2,nbligne) VALUES('$SID1','$SID2','$nbligne')";
   $reqnb = mysqli_query($link, $sqlnb);
}  


mysqli_close($link);
header("location:chat.php?sid1=$SID1&sid2=$SID2");
?>
