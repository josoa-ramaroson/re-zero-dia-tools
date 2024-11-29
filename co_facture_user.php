<?php
require 'session.php';
require 'fonction.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Clients</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            margin-bottom: 2rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .table-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .btn-print {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }
        .client-info {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-light">
<?php
require 'bienvenue.php';

$id = $_REQUEST['id'];
$sqlm = "SELECT * FROM $tbl_contact WHERE id='$id'";
$resultm = mysqli_query($linki, $sqlm);
$datam = mysqli_fetch_array($resultm);

$sqfac = "SELECT * FROM $tbl_fact WHERE id='$id' and st='E' ORDER BY idf desc";
$resultfac = mysqli_query($linki, $sqfac);

$sqpaie = "SELECT * FROM $tbl_paiement WHERE id='$id' and st='E' ORDER BY idp DESC";
$resultpaie = mysqli_query($linki, $sqpaie);
?>

<div class="container-fluid py-4">
    <!-- Bouton d'impression flottant -->
    <a href="co_facture_user_imp.php?id=<?php echo md5(microtime()).$id;?>" target="_blank" class="btn btn-primary btn-print">
        <i class="fas fa-print"></i> Imprimer
    </a>

    <!-- Information client -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Information du client</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="client-info">
                        <h6 class="mb-3">Information personnelle</h6>
                        <div class="row mb-2">
                            <div class="col-sm-4">ID Client:</div>
                            <div class="col-sm-8"><strong><?php echo $datam['id']; ?></strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Désignation:</div>
                            <div class="col-sm-8"><strong><?php echo $datam['Designation']; ?></strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Nom et Prénom:</div>
                            <div class="col-sm-8"><strong><?php echo $datam['nomprenom']; ?></strong></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="client-info">
                        <h6 class="mb-3">Information du compteur</h6>
                        <div class="row mb-2">
                            <div class="col-sm-4">Ville:</div>
                            <div class="col-sm-8"><strong><?php echo $datam['ville']; ?></strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Quartier:</div>
                            <div class="col-sm-8"><strong><?php echo $datam['quartier']; ?></strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">N° Compteur:</div>
                            <div class="col-sm-8"><strong><?php echo $datam['ncompteur']; ?></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historique des facturations -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Historique des facturations</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-header">
                    <tr>
                        <th>N° Facture</th>
                        <th>Facturation</th>
                        <th>Date facturé</th>
                        <th>Index J</th>
                        <th>Index N</th>
                        <th>Mont TTC</th>
                        <th>Impayé</th>
                        <th>Total net</th>
                        <th>Reste à payer</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($rowsfac = mysqli_fetch_array($resultfac)) { ?>
                        <tr>
                            <td><a href="<?php echo ($datam['Tarif']!=10) ? 'co_billimp.php' : 'co_billMTimp.php';?>?idf=<?php echo md5(microtime()).$rowsfac['idf'];?>" target="_blank" class="text-primary"><?php echo $rowsfac['nfacture'];?></a></td>
                            <td><?php echo $rowsfac['nserie'].'/'.$rowsfac['fannee'];?></td>
                            <td><?php echo $rowsfac['date'];?></td>
                            <td><?php echo $rowsfac['nf'];?></td>
                            <td><?php echo $rowsfac['nf2'];?></td>
                            <td><?php echo number_format($rowsfac['totalttc'], 2);?></td>
                            <td><?php echo number_format($rowsfac['impayee'], 2);?></td>
                            <td><?php echo number_format($rowsfac['totalnet'], 2);?></td>
                            <td><?php echo number_format($rowsfac['report'], 2);?></td>
                            <td>
                                <?php if (($rowsfac['etat']=="facture") && (($_SESSION['u_niveau']==8)||($_SESSION['u_niveau']==7))){ ?>
                                    <a href="<?php echo ($datam['Tarif']!=10) ? 'co_modification.php' : 'co_modificationMT.php';?>?idf=<?php echo md5(microtime()).$rowsfac['idf'];?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Historique des paiements -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Historique des paiements</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-header">
                    <tr>
                        <th>N° Reçu</th>
                        <th>N° Facture</th>
                        <th>Date Paiement</th>
                        <th>Nom du client</th>
                        <th>Total net</th>
                        <th>Payé</th>
                        <th>Reste à payer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($rowsp = mysqli_fetch_array($resultpaie)) { ?>
                        <tr>
                            <td><a href="paiement_billimp.php?idp=<?php echo md5(microtime()).$rowsp['idp'];?>" target="_blank" class="text-primary"><?php echo $rowsp['idp'];?></a></td>
                            <td><?php echo $rowsp['nfacture'];?></td>
                            <td><?php echo $rowsp['date'];?></td>
                            <td><?php echo $rowsp['Nomclient'];?></td>
                            <td><?php echo number_format($rowsp['montant'], 2);?></td>
                            <td><?php echo number_format($rowsp['paiement'], 2);?></td>
                            <td><?php echo number_format($rowsp['report'], 2);?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<?php include_once('pied.php'); ?>
</body>
</html>