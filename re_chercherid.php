<?php
require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php include 'titre.php' ?> - Résultat de recherche</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)),
            url(images/bg.jpg) no-repeat center center fixed;
            background-size: cover;
        }
        .search-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .table {
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        .status-highlight-1 { background-color: #ffff00; }
        .status-highlight-2 { background-color: #ff99FF; }
        .status-highlight-3 { background-color: #ff9999; }
        .status-highlight-4 { background-color: #9999FF; }
    </style>
</head>

<body class="bg-light">
<?php require 'bienvenue.php'; ?>

<div class="container-fluid py-4">
    <!-- Search Section -->
    <div class="row justify-content-between mb-4">
        <div class="col-md-5">
            <div class="search-box p-3">
                <form method="post" action="re_chercherid.php" class="d-flex gap-2">
                    <input name="mr2" type="text" class="form-control" placeholder="Rechercher par ID..."
                           aria-label="Rechercher par ID">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Rechercher ID
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-5">
            <div class="search-box p-3">
                <form method="post" action="re_chercher.php" class="d-flex gap-2">
                    <input name="mr1" type="text" class="form-control" placeholder="Recherche générale..."
                           aria-label="Recherche générale">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-search me-1"></i> Rechercher
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <?php
    if (isset($_POST['mr2'])) {
        $mr2 = addslashes($_POST['mr2']);

        $sql = "SELECT count(*) FROM $tbl_contact";
        $resultat = mysqli_query($linki, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error($linki));
        $nb_total = mysqli_fetch_array($resultat);

        if (($nb_total = $nb_total[0]) == 0) {
            echo '<div class="alert alert-info">Aucune réponse trouvée</div>';
        } else {
            if (!isset($_GET['debut'])) $_GET['debut'] = 0;
            $nb_affichage_par_page = 2;

            $sql = "SELECT * FROM $tbl_contact where id='$mr2' ORDER BY nomprenom ASC";
            $req = mysqli_query($linki, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error($linki));
            ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nom / Raison Sociale</th>
                                <th>Police</th>
                                <th>Adresse</th>
                                <th>Ville</th>
                                <th>Quartier</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while($data = mysqli_fetch_array($req)) { ?>
                                <tr>
                                    <td><?php echo $data['id']; ?></td>
                                    <td><?php echo $data['nomprenom']; ?></td>
                                    <td><?php echo $data['Police']; ?></td>
                                    <td><?php echo $data['adresse']; ?></td>
                                    <td><?php echo $data['ville']; ?></td>
                                    <td><?php echo $data['quartier']; ?></td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        switch($data['statut']) {
                                            case 1: $statusClass = 'btn-secondary'; break;
                                            case 2: $statusClass = 'btn-warning'; break;
                                            case 3: $statusClass = 'btn-info'; break;
                                            case 4:
                                            case 5:
                                            case 6: $statusClass = 'btn-success'; break;
                                            case 7: $statusClass = 'btn-danger'; break;
                                        }
                                        ?>
                                        <a href="re_affichage_user.php?id=<?php echo md5(microtime()).$data['id']; ?>"
                                           class="btn btn-sm <?php echo $statusClass; ?>">
                                            <i class="fas fa-eye me-1"></i> Aperçu
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php
        }
        mysqli_free_result($resultat);
        mysqli_close($linki);
    } else {
        echo '<div class="alert alert-secondary">Utilisez les champs de recherche ci-dessus pour trouver des résultats.</div>';
    }
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>