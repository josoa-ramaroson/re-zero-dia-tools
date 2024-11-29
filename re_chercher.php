<?php
require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';

// Définition de la fonction de surlignage en dehors de toute boucle
function highlightWords($text, $keywords) {
    $i = 0;
    foreach($keywords as $keyword) {
        if (strlen($keyword) > 0) {
            $i++;
            if ($i > 4) $i = 1;
            $text = str_ireplace(
                $keyword,
                '<span class="surlign'.$i.'">'.$keyword.'</span>',
                $text
            );
        }
    }
    return $text;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php include 'titre.php' ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)),
            url(images/bg.jpg) no-repeat center center fixed;
            background-size: cover;
        }

        .search-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .results-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .surlign1 {
            background-color: #ffff00;
            font-style: italic;
            padding: 2px 4px;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .surlign2 {
            background-color: #ff99FF;
            font-style: italic;
            padding: 2px 4px;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .surlign3 {
            background-color: #ff9999;
            font-style: italic;
            padding: 2px 4px;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .surlign4 {
            background-color: #9999FF;
            font-style: italic;
            padding: 2px 4px;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #3071AA;
            color: white;
            border-bottom: 2px solid #2961AA;
        }

        .table td {
            vertical-align: middle;
            padding: 12px;
        }

        .search-input {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 8px 12px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .search-input:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
</head>

<body class="bg-light">
<?php require 'bienvenue.php'; ?>

<div class="container-fluid py-4">
    <!-- Barre de recherche -->
    <div class="search-container">
        <div class="row justify-content-between">
            <div class="col-md-5">
                <form method="post" action="re_chercherid.php" class="d-flex gap-2">
                    <input name="mr2" type="text" class="form-control search-input"
                           placeholder="Rechercher par ID..." aria-label="Rechercher par ID">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-search me-2"></i>Rechercher ID
                    </button>
                </form>
            </div>
            <div class="col-md-5">
                <form method="post" action="re_chercher.php" class="d-flex gap-2">
                    <input name="mr1" type="text" class="form-control search-input"
                           placeholder="Recherche générale..." aria-label="Recherche générale">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-search me-2"></i>Rechercher
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Résultats de recherche -->
    <?php
    if (isset($_POST['mr1'])) {
        $mr1 = addslashes($_POST['mr1']);
        $s = explode(" ", $mr1);

        $sql = "SELECT count(*) FROM $tbl_contact";
        $resultat = mysqli_query($linki, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error($linki));
        $nb_total = mysqli_fetch_array($resultat);

        if (($nb_total = $nb_total[0]) == 0) {
            echo '<div class="alert alert-info">Aucune réponse trouvée</div>';
        } else {
            if (!isset($_GET['debut'])) $_GET['debut'] = 0;

            $sql = "SELECT * FROM $tbl_contact where ";
            foreach($s as $mot) {
                if (strlen($mot) > 0)
                    $sql .= "nomprenom like '%".$mot."%' OR tel like '%".$mot."%' OR adresse like '%".$mot."%' 
                            OR ville like '%".$mot."%' OR quartier like '%".$mot."%' OR surnom like '%".$mot."%' 
                            OR Police like '%".$mot."%' OR id like '%".$mot."%' OR ";
            }
            $sql .= " 0 ORDER BY nomprenom ASC";

            $req = mysqli_query($linki, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error($linki));
            ?>

            <div class="results-container">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom / Raison Sociale</th>
                            <th>Police</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>Quartier</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($data = mysqli_fetch_array($req)) {
                            // Application du surlignage pour chaque champ
                            $id = highlightWords($data['id'], $s);
                            $nomprenom = highlightWords($data['nomprenom'], $s);
                            $Police = highlightWords($data['Police'], $s);
                            $adresse = highlightWords($data['adresse'], $s);
                            $ville = highlightWords($data['ville'], $s);
                            $quartier = highlightWords($data['quartier'], $s);
                            ?>
                            <tr>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $nomprenom; ?></td>
                                <td><?php echo $Police; ?></td>
                                <td><?php echo $adresse; ?></td>
                                <td><?php echo $ville; ?></td>
                                <td><?php echo $quartier; ?></td>
                                <td class="text-center">
                                    <?php
                                    $btnClass = 'btn-secondary';
                                    $btnIcon = 'eye';
                                    switch($data['statut']) {
                                        case 2: $btnClass = 'btn-warning'; break;
                                        case 3: $btnClass = 'btn-info'; break;
                                        case 4:
                                        case 5:
                                        case 6: $btnClass = 'btn-success'; break;
                                        case 7: $btnClass = 'btn-danger'; break;
                                    }
                                    ?>
                                    <a href="re_affichage_user.php?id=<?php echo md5(microtime()).$data['id']; ?>"
                                       class="btn btn-sm <?php echo $btnClass; ?>">
                                        <i class="fas fa-<?php echo $btnIcon; ?> me-1"></i> Aperçu
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        }
        mysqli_free_result($resultat);
    } else {
        echo '<div class="alert alert-secondary text-center">
                <i class="fas fa-search fa-2x mb-3"></i><br>
                Utilisez les champs de recherche ci-dessus pour trouver des résultats
              </div>';
    }
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>