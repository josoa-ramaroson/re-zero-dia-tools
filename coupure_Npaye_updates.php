<?php
    require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);

$idf=substr($_REQUEST["idf"],32);
$m1v=substr($_REQUEST["m1v"],32);
$m2q=substr($_REQUEST["m2q"],32);

#---------------------------------------------------3 
$sqlp="update  $tbl_fact  set   bstatut='couper' WHERE  idf='$idf'";
$resultp=mysqli_query($link, $sqlp);
if($resultp){
}
else {
}
mysqli_close($link);
?>
<?php
$m1vd=md5(microtime()).$m1v;
$m2qd=md5(microtime()).$m2q;
header("location: coupure_NPaye.php?m1v=$m1vd&m2q=$m2qd");
?>