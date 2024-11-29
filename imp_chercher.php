<?php
Require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        /* [Les styles restent identiques] */
        span.surlign1 { font-style: italic; background-color: #fff3cd; }
        span.surlign2 { font-style: italic; background-color: #f8d7da; }
        span.surlign3 { font-style: italic; background-color: #cce5ff; }
        span.surlign4 { font-style: italic; background-color: #d4edda; }

        body {
            background-color: #f8f9fa;
            color: #000;
            padding: 20px;
        }

        .search-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .table-wrapper {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .table thead th {
            background-color: #3071AA;
            color: white;
            border: none;
            padding: 12px;
        }
    </style>
    <title>Gestion des contacts</title>
</head>

<body>
<?php
Require 'bienvenue.php';
?>

<div class="container">
    <!-- Champ de recherche modifié pour utiliser GET -->
    <div class="search-box">
        <form method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="mr1" class="form-control" placeholder="Rechercher..."
                       value="<?php echo isset($_GET['mr1']) ? htmlspecialchars($_GET['mr1']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Rechercher</button>
            </div>
        </form>
    </div>

    <?php
    if (isset($_GET['mr1'])) {
        $mr1 = addslashes($_GET['mr1']);
        $s = explode(" ", $mr1);

        $sql = "SELECT count(*) FROM $tbl_contact";
        $resultat = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));
        $nb_total = mysqli_fetch_array($resultat);

        if (($nb_total = $nb_total[0]) == 0) {
            echo '<div class="alert alert-info">Aucune réponse trouvée</div>';
        } else {
            // Pagination avec 200 éléments par page
            $nb_par_page = 200;
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $debut = ($page - 1) * $nb_par_page;

            $sql = "SELECT * FROM $tbl_contact where ";
            foreach($s as $mot) {
                if (strlen($mot)>0)
                    $sql.="nomprenom like '%".$mot."%' OR tel like '%".$mot."%' OR adresse like '%".$mot."%' OR ville like '%".$mot."%' OR quartier like '%".$mot."%' OR id like '%".$mot."%' OR Police like '%".$mot."%' OR ";
            }
            $sql.=" 0 ORDER BY nomprenom ASC LIMIT $debut, $nb_par_page";

            $req = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));
            ?>

            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <!-- [Le reste du tableau reste identique] -->
                        <thead>
                        <tr>
                            <th>Suivi</th>
                            <th>ID_client</th>
                            <th>Nom du client</th>
                            <th>Tel</th>
                            <th>Ville</th>
                            <th>Quartier</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while($data=mysqli_fetch_array($req)){
                            // [Le code de surlignage reste identique]
                            $id=$data['id'];
                            $i=0;
                            foreach($s as $mot){
                                if (strlen($mot)>0){
                                    $i++;
                                    if ($i>4){$i=1;}
                                    $id = str_replace($mot,'<span class="surlign'.$i.'">'.$mot.'</span>',$id);
                                }
                            }

                            $nomprenom=$data['nomprenom'];
                            $i=0;
                            foreach($s as $mot){
                                if (strlen($mot)>0){
                                    $i++;
                                    if ($i>4){$i=1;}
                                    $nomprenom = str_replace($mot,'<span class="surlign'.$i.'">'.$mot.'</span>',$nomprenom);
                                }
                            }

                            $tel=$data['tel'];
                            $i=0;
                            foreach($s as $mot){
                                if (strlen($mot)>0){
                                    $i++;
                                    if ($i>4){$i=1;}
                                    $tel = str_replace($mot,'<span class="surlign'.$i.'">'.$mot.'</span>',$tel);
                                }
                            }

                            $ville=$data['ville'];
                            $i=0;
                            foreach($s as $mot){
                                if (strlen($mot)>0){
                                    $i++;
                                    if ($i>4){$i=1;}
                                    $ville = str_replace($mot,'<span class="surlign'.$i.'">'.$mot.'</span>',$ville);
                                }
                            }

                            $quartier=$data['quartier'];
                            $i=0;
                            foreach($s as $mot){
                                if (strlen($mot)>0){
                                    $i++;
                                    if ($i>4){$i=1;}
                                    $quartier = str_replace($mot,'<span class="surlign'.$i.'">'.$mot.'</span>',$quartier);
                                }
                            }
                            ?>
                            <tr>
                                <td><em><?php echo $data['Police'];?></em></td>
                                <td><em><?php echo $id;?></em></td>
                                <td><em><?php echo $nomprenom;?></em></td>
                                <td><em><?php echo $tel;?></em></td>
                                <td><em><?php echo $ville;?></em></td>
                                <td><em><?php echo $quartier;?></em></td>
                                <td>
                                    <?php
                                    $n=$data['statut'];
                                    if ($n==1) $codecouleur='btn-secondary';
                                    if ($n==2) $codecouleur='btn-warning';
                                    if ($n==3) $codecouleur='btn-info';
                                    if ($n==4) $codecouleur='btn-success';
                                    if ($n==5) $codecouleur='btn-success';
                                    if ($n==6) $codecouleur='btn-success';
                                    if ($n==7) $codecouleur='btn-danger';
                                    ?>
                                    <a href="co_affichage_user.php?id=<?php echo md5(microtime()).$data['id']; ?>"
                                       class="btn btn-sm <?php echo $codecouleur; ?>">
                                        Aperçu
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination modifiée pour conserver la recherche -->
                <?php
                $total_pages = ceil($nb_total / $nb_par_page);
                if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo ($page-1); ?>&mr1=<?php echo urlencode($mr1); ?>">
                                        Précédent
                                    </a>
                                </li>
                            <?php endif;

                            for($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++): ?>
                                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>&mr1=<?php echo urlencode($mr1); ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor;

                            if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo ($page+1); ?>&mr1=<?php echo urlencode($mr1); ?>">
                                        Suivant
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
            <?php
            mysqli_free_result($req);
        }
        mysqli_free_result($resultat);
    } else {
        echo "<div class='alert alert-info'>Veuillez effectuer une recherche</div>";
    }
    ?>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>