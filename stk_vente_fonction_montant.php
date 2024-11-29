<?Php
require "fonction.php";
@$idproduit = $_GET['idproduit'];

if(!is_numeric($idproduit)) {
    echo "Data Error";
    exit;
}

// Préparation de la requête avec mysqli
$sql = "SELECT * FROM $tbl_produit WHERE idproduit = ?";

if($stmt = mysqli_prepare($linki, $sql)) {
    // Liaison du paramètre
    mysqli_stmt_bind_param($stmt, "i", $idproduit);
    
    // Exécution de la requête
    mysqli_stmt_execute($stmt);
    
    // Récupération du résultat
    $result = mysqli_stmt_get_result($stmt);
    
    // Création du tableau de résultats
    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Formatage de la sortie
    $main = array('data' => $data);
    
    // Envoi du résultat en JSON
    echo json_encode($main);
    
    // Fermeture du statement
    mysqli_stmt_close($stmt);
} else {
    echo "Erreur de préparation de la requête";
}
?>