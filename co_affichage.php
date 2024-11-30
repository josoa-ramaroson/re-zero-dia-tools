<?php
require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php include "titre.php" ?> - Liste des clients</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .search-panel {
            margin-bottom: 2rem;
        }
        .table-container {
            margin-top: 2rem;
        }
        .client-table th {
            background-color: #0d6efd;
            color: white;
            font-weight: 500;
        }
        .search-form {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            padding: 1rem;
        }
        .error-message {
            display: none;
            color: red;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        .form-group {
            flex: 1;
        }
        .card-body *{
          font-size: 14px;
        }
    </style>
</head>
<body class="bg-light">
<?php require 'bienvenue.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Panneau de recherche par ID -->
        <div class="col-md-6">
            <div class="card search-panel">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Recherche par ID Client</h5>
                </div>
                <div class="card-body">
                    <form action="re_chercherid.php" method="post" class="search-form" onsubmit="return validateForm('mr2')">
                        <div class="form-group">
                            <input type="text" name="mr2" id="mr2" class="form-control" placeholder="Entrez l'ID client">
                            <div id="error-mr2" class="error-message">Veuillez saisir un ID client</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panneau de recherche détaillée -->
        <div class="col-md-6">
            <div class="card search-panel">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Recherche détaillée</h5>
                </div>
                <div class="card-body">
                    <form action="imp_chercher.php" method="post" class="search-form" onsubmit="return validateForm('mr1')">
                        <div class="form-group">
                            <input type="text" name="mr1" id="mr1" class="form-control" placeholder="Rechercher par nom, ville, etc.">
                            <div id="error-mr1" class="error-message">Veuillez saisir un terme de recherche</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Historique client -->
        <div class="col-md-6">
            <div class="card search-panel">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Historique Client</h5>
                </div>
                <div class="card-body">
                    <form action="co_facture_user.php" method="post" class="search-form" onsubmit="return validateForm('history-id')">
                        <div class="form-group">
                            <input type="text" name="id" id="history-id" class="form-control" placeholder="ID Client">
                            <div id="error-history-id" class="error-message">Veuillez saisir un ID client</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Consulter les factures</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Archives -->
        <div class="col-md-6">
            <div class="card search-panel">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">Archives</h5>
                </div>
                <div class="card-body">
                    <form action="z_co_facture_user.php" method="post" class="search-form" onsubmit="return validateForm('archive-id')">
                        <div class="form-group">
                            <select name="annee" class="form-select mb-2">
                                <?php
                                $sql81 = "SELECT * FROM z_annee ORDER BY annee ASC";
                                $result81 = mysqli_query($linki, $sql81);
                                if ($result81) {
                                    while ($row81 = mysqli_fetch_assoc($result81)) {
                                        echo '<option value="' . htmlspecialchars($row81['annee']) . '">' .
                                            htmlspecialchars($row81['annee']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <input type="text" name="id" id="archive-id" class="form-control" placeholder="ID Client">
                            <div id="error-archive-id" class="error-message">Veuillez saisir un ID client</div>
                        </div>
                        <button type="submit" class="btn btn-warning">Consulter les archives</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton Documents -->
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <a href="client_document_chercher.php" class="btn btn-secondary">
                <i class="fas fa-file-alt"></i> Rechercher un document
            </a>
        </div>
    </div>

    <!-- Table des clients -->
    <div class="table-container">
        <?php
        $sql = "SELECT count(*) FROM $tbl_contact WHERE statut='6'";
        $resultat = mysqli_query($linki, $sql);
        $nb_total = mysqli_fetch_array($resultat)[0];

        if ($nb_total == 0) {
            echo '<div class="alert alert-info">Aucun résultat trouvé</div>';
        } else {
            if (!isset($_GET['debut'])) $_GET['debut'] = 0;
            $nb_affichage_par_page = 50;
            $sql = "SELECT * FROM $tbl_contact WHERE statut='6' ORDER BY nomprenom ASC LIMIT ".$_GET['debut']." OFFSET ".$nb_affichage_par_page;
            $req = mysqli_query($linki, $sql);
            ?>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Liste des clients</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped client-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Police</th>
                                <th>Nom et Prénom</th>
                                <th>Téléphone</th>
                                <th>Ville</th>
                                <th>Quartier</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while($data = mysqli_fetch_array($req)) { ?>
                                <tr>
                                    <td>
                                        <a href="co_affichage_user.php?id=<?php echo md5(microtime()).$data['id']; ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            <?php echo htmlspecialchars($data['id']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($data['Police']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nomprenom']); ?></td>
                                    <td><?php echo htmlspecialchars($data['tel']); ?></td>
                                    <td><?php echo htmlspecialchars($data['ville']); ?></td>
                                    <td><?php echo htmlspecialchars($data['quartier']); ?></td>
                                    <td>
                                        <a href="co_affichage_user.php?id=<?php echo md5(microtime()).$data['id']; ?>"
                                           class="btn btn-sm btn-success">
                                            <i class="fas fa-eye"></i> Aperçu
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <?php echo barre_navigation($nb_total, $nb_affichage_par_page, $_GET['debut'], 10); ?>
                    </div>
                </div>
            </div>
            <?php
        }
        mysqli_free_result($req);
        mysqli_free_result($resultat);
        mysqli_close($linki);
        ?>
    </div>
</div>

<!-- Script de validation -->
<script>
    function validateForm(inputId) {
        const input = document.getElementById(inputId);
        const errorDiv = document.getElementById('error-' + inputId);

        if (!input.value.trim()) {
            errorDiv.style.display = 'block';
            input.focus();
            return false;
        }

        errorDiv.style.display = 'none';
        return true;
    }

    // Masquer les messages d'erreur lors de la saisie
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const errorDiv = document.getElementById('error-' + this.id);
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            });
        });
    });
</script>

<!-- Bootstrap JS et Font Awesome -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>