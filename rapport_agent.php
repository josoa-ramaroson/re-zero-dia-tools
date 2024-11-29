<?php
require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
?>
<html>
<head>
<title><?php include("titre.php"); ?></title>
<meta name="viewport" content="width=device-width, minimum-scale=0.25"/>

<!-- Bootstrap et jQuery UI pour un meilleur design -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style type="text/css">
.centrevaleur {
    text-align: center;
}
.centrevaleur td {
    text-align: center;
}
.taille16 {
    font-size: 16px;
}
</style>
</head>
<?php
require("bienvenue.php");
?>
<body>
<?php
require 'configuration.php';

// Vérification et conversion de la date
if(!isset($_POST['datec']) || !isset($_POST['agent'])) {
    die('Paramètres manquants');
}

// Conversion de la date du format dd-mm-yyyy vers yyyy-mm-dd
$dateInput = $_POST['datec'];
$dateParts = explode('-', $dateInput);
if(count($dateParts) == 3) {
    $date = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
} else {
    die('Format de date invalide');
}

$agent = mysqli_real_escape_string($linki, $_POST['agent']);
$date = mysqli_real_escape_string($linki, $date);

// Requête initiale
$sql = "SELECT count(*) FROM $tbl_paiement";  
$resultat = mysqli_query($linki, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
$nb_total = mysqli_fetch_array($resultat);  

if (($nb_total = $nb_total[0]) == 0) {  
    echo 'Aucune réponse trouvée';  
} else { 
    if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
    $nb_affichage_par_page = 10; 

    // Requête pour les données groupées par statut
    $sql = "SELECT SUM(paiement) AS Paie, SUM(ortc_dp) AS ortc_dp, SUM(tax_dp) AS tax_dp, 
            SUM(totalht_dp) AS totalht_dp, st, date, id_nom 
            FROM $tbl_paiement 
            WHERE id_nom='$agent' AND date='$date' 
            GROUP BY st 
            LIMIT ".$_GET['debut'].','.$nb_affichage_par_page;
    $req = mysqli_query($linki, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki)); 

    // Requête pour les totaux
    $sqlt = "SELECT SUM(paiement) AS Paie, SUM(ortc_dp) AS ortc_dp, SUM(tax_dp) AS tax_dp, 
             SUM(totalht_dp) AS totalht_dp, id_nom, date, st, nserie 
             FROM $tbl_paiement 
             WHERE id_nom='$agent' AND date='$date'";
    $reqt = mysqli_query($linki, $sqlt); 

    // Requête pour les paiements électriques
    $sqltE = "SELECT SUM(paiement) AS PaieE, id_nom, date, st, nserie 
              FROM $tbl_paiement 
              WHERE st='E' AND id_nom='$agent' AND date='$date'";
    $reqtE = mysqli_query($linki, $sqltE); 
    $datatE = mysqli_fetch_array($reqtE);
    ?>

    <div class="container-fluid">
        <a href="rapport_agentimp.php?datec=<?php echo md5(microtime()).$date;?>&agent=<?php echo md5(microtime()).$agent;?>" 
           class="btn btn-primary mb-3" target="_blank">
            <img src="images/imprimante.png" width="50" height="30" alt="Imprimer">
        </a>

        <!-- Premier tableau -->
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th class="text-center">AGENT (VENDEUR)</th>
                    <th class="text-center">DATE</th>
                    <th class="text-center">MONTANT TOTAL</th>
                    <th class="text-center">MONTANT ELEC</th>
                    <th class="text-center">TOTAL ORTC</th>
                    <th class="text-center">TOTAL TAX</th>
                    <th class="text-center">TOTAL M S ORTC/TAX</th>
                </tr>
            </thead>
            <tbody>
                <?php while($datat = mysqli_fetch_array($reqt)) { ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($datat['id_nom']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($datat['date']); ?></td>
                        <td class="text-center"><?php echo strrev(chunk_split(strrev($datat['Paie']), 3, " ")); ?></td>
                        <td class="text-center"><?php echo strrev(chunk_split(strrev($datatE['PaieE']), 3, " ")); ?></td>
                        <td class="text-center"><?php echo strrev(chunk_split(strrev($datat['ortc_dp']), 3, " ")); ?></td>
                        <td class="text-center">
                            <?php
                            $P2 = $datatE['PaieE'] - $datat['ortc_dp'];
                            $tax_dp = round(0.03 * ($P2), 0);
                            echo $tax_dp;
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            $P3 = $datatE['PaieE'] - $datat['ortc_dp'] - $tax_dp;
                            echo $P3;
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Deuxième tableau -->
        <table class="table table-bordered mt-4">
            <thead class="table-primary">
                <tr>
                    <th class="text-center">Activités</th>
                    <th class="text-center">MONTANT PAR ACTIVITE</th>
                    <th class="text-center">Par date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($data = mysqli_fetch_array($req)) { ?>
                    <tr>
                        <td>
                            <?php
                            $activities = [
                                'E' => 'FACTURATION',
                                'P' => 'POLICE D\'ABONNEMENT',
                                'D' => 'BRANCHEMENT',
                                'F' => 'FRAUDE',
                                'A' => 'Autre (Chang Nom/compteur/Activation/Transfert)'
                            ];
                            echo isset($activities[$data['st']]) ? $activities[$data['st']] : $data['st'];
                            ?>
                        </td>
                        <td class="text-center"><?php echo strrev(chunk_split(strrev($data['Paie']), 3, " ")); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($data['date']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php
    mysqli_free_result($req);
}

mysqli_free_result($resultat);
if(isset($reqtE)) mysqli_free_result($reqtE);
if(isset($reqt)) mysqli_free_result($reqt);
mysqli_close($linki);

include_once('pied.php');
?>
</body>
</html>