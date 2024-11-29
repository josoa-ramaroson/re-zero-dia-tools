<?php
require_once "fonction.php";
require "configuration.php"; // Pour avoir accès à $linki

// Vérification de la présence du paramètre
if(!isset($_GET['refville'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Paramètre refville manquant']);
    exit;
}

$refville = $_GET['refville'];

// Validation plus stricte
if(!is_numeric($refville) || $refville < 0) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Paramètre refville invalide']);
    exit;
}

// Échappement pour prévenir les injections SQL
$refville = mysqli_real_escape_string($linki, $refville);

// Requête pour récupérer les quartiers de la ville sélectionnée
$sql = "SELECT quartier, id_quartier FROM quartier WHERE refville = '$refville' ORDER BY quartier ASC";
$result = mysqli_query($linki, $sql) or die(json_encode(['error' => mysqli_error($linki)]));

// Construction du tableau des résultats
$result_array = array();
while($row = mysqli_fetch_assoc($result)) {
    $result_array[] = $row;
}

// Libération des ressources
mysqli_free_result($result);
mysqli_close($linki);

// Envoi de la réponse JSON
header('Content-Type: application/json');
echo json_encode(['data' => $result_array]);