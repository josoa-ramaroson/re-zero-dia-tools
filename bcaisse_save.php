<?php
require 'fonction.php';


require 'xbackup_caisse.php';


$date=addslashes($_POST['date']);
$blogin=addslashes($_POST['blogin']);
$verification=addslashes($_POST['verification']);
$valbsc=md5($date);
$valbsc=$valbsc.md5($CONTRATN.(date("Y", strtotime($date))).$CONSULTANT);
$valbsc=md5("y/m/d H:i:s").$valbsc.md5($valbsc);


$dfin = explode("-", $date); 
$debut = explode("-", $verification);

$dateverif = str_replace("/","-",$date);
$dateconf= strtotime($dateverif);

if ($dfin <= $debut)
{

header("location: bcaisse.php");
exit;
}
else
{
$valeur_existant = "SELECT COUNT(*) AS nb FROM $tbl_caisse ";
$sqLvaleur = mysqli_query($link,$valeur_existant)or exit(mysqli_error());
$nb = mysqli_fetch_assoc($sqLvaleur);

if($nb['nb'] == 1)
{
$sqlp="update  $tbl_caisse  set  datecaisse='$date' , blogin='$blogin' , valbsc='$valbsc' ";
$resultp=mysqli_query($link,$sqlp);


$sqlp2="update  $tbl_date  set  date='$date' ";
$resultp2=mysqli_query($link,$sqlp2);


header("location: bcaisse.php");
}
else 
{

$sqlp="INSERT INTO $tbl_caisse  ( blogin  ,  datecaisse , valbsc )
                    VALUES      ('$blogin','$date' , '$valbsc')";								
$r=mysqli_query($link,$sqlp)
or die(mysqli_error());



$sqldate="INSERT INTO $tbl_date  (date) VALUES ('$date')";								
$rdate=mysqli_query($link,$sqldate);
mysqli_close($link);

header("location: bcaisse.php");
}
}
?>