<?php
    require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);
	
$TypeClts=addslashes($_POST['TypeClts']);
#---------------------------------------------------3 
$sqlp="INSERT INTO $tbl_client (TypeClts) VALUES ('$TypeClts')";
$resultp=mysqli_query($link, $sqlp);
if($resultp){
}
else {
echo "ERROR";
}
?>
<?php
header("location: categorie.php");
?>