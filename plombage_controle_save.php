<?php
$id_nom=addslashes($_POST['id_nom']);
$idclient=addslashes($_POST['idclient']);
$agents=addslashes($_POST['agents']);
$obs=addslashes($_POST['obs']);
$datep=addslashes($_POST['date']);

$sql="SELECT MAX(nombre) AS Maxa_n FROM $tbl_plombcont WHERE idclient='$idclient'";
$result=mysqli_query($link, $sql);
$rows=mysqli_fetch_array($result);
if ($rows) {
$Max_n = $rows['Maxa_n']+1;
}
else {
$Max_n = 1;
}

require 'fonction.php';

$sqlp="INSERT INTO $tbl_plombcont  ( id_nom   , idclient   ,agents,   obs   , datep, nombre)
                    VALUES       ('$id_nom','$idclient', '$agents', '$obs' ,'$datep', '$Max_n')";
					
													
$r=mysqli_query($link, $sqlp);
mysql_close($link);

?>
<?php
$idg=md5(microtime()).md5(microtime($id_nom)).$agents;
header("location: plombage_re_chercherid.php?$idg&mr2=$idclient");
?>