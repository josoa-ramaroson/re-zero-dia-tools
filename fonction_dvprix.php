<?php
@$idproduit = $_GET['idproduit'];

if(!is_numeric($idproduit)) {
   echo "Data Error";
   exit;
}

require "fonction.php";
$sql = "SELECT prix, idproduit FROM ginv_produit WHERE idproduit=?";

$stmt = mysqli_prepare($linki, $sql);
mysqli_stmt_bind_param($stmt, "i", $idproduit);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = array();
while($row = mysqli_fetch_assoc($result)) {
   $data[] = $row;
}

echo json_encode(array('data' => $data));
?>