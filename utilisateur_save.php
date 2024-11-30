<?php
require 'fonction.php';

// Nettoyage et préparation des données
$u_nom = addslashes(trim($_POST['u_nom']));
$u_prenom = addslashes(trim($_POST['u_prenom']));
$u_email = addslashes(trim($_POST['u_email']));
$u_login = strtolower(str_replace(' ', '', addslashes(trim($_POST['u_login']))));
$u_pwd = md5(trim($_POST['u_pwd']));
$u_niveau = addslashes(trim($_POST['u_niveau']));
$titre = addslashes(trim($_POST['titre']));
$mobile = addslashes(trim($_POST['mobile']));
$statut = addslashes(trim($_POST['statut']));
$agence = addslashes(trim($_POST['agence']));
$id_nom = addslashes(trim($_POST['id_nom']));
$datetime = date("y/m/d H:i:s");

// Inclusion du fichier qui définit probablement la variable $type
require 'fonction_niveau_save.php';

// Préparation de la requête SQL
$sqlp = "INSERT INTO $tbl_utilisateur (
    id_nom, 
    u_nom, 
    u_prenom, 
    u_email, 
    u_login, 
    u_pwd, 
    u_niveau, 
    type, 
    titre, 
    mobile, 
    statut, 
    agence, 
    datetime,
    privileges,
    session
) VALUES (
    '$id_nom',
    '$u_nom',
    '$u_prenom',
    '$u_email',
    '$u_login',
    '$u_pwd',
    '$u_niveau',
    '$type',
    '$titre',
    '$mobile',
    '$statut',
    '$agence',
    '$datetime',
    0,
    0
)";

// Exécution de la requête avec gestion d'erreur
if (!$r = mysqli_query($linki, $sqlp)) {
    die("Erreur SQL : " . mysqli_error($linki));
}

// Fermeture de la connexion
mysqli_close($linki);

// Redirection vers la page de liste des utilisateurs
header("Location: utilisateur.php");
exit;

?>