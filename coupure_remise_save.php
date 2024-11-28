<?php
    require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);

$idf=substr($_REQUEST["idf"],32);

#---------------------------------------------------3 
$sqlp="update  $tbl_fact  set   bstatut='retablie' WHERE  idf='$idf'";
$resultp=mysqli_query($link, $sqlp);
if($resultp){
}
else {
}
mysqli_close($link);
?>
<?php
header("location: coupure_remise.php");
?>