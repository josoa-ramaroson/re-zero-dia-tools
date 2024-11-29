<?php
@$nameproduit = $_GET['nameproduit'];

if(is_numeric($nameproduit)) {
    echo "Data Error";
    exit;
}

require "fonction.php";
$sql = "SELECT DISTINCT(Validite) FROM $tbl_appproduit_entre WHERE titre=?";

$stmt = mysqli_prepare($linki, $sql);
mysqli_stmt_bind_param($stmt, "s", $nameproduit);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = array();
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode(array('data' => $data));
?>