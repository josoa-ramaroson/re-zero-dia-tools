<?php
$idv=addslashes($_POST['idv']);
$id_nom=addslashes($_POST['id_nom']);
$niveau=addslashes($_POST['niveau']);
$nom=addslashes($_POST['nom']);
$dater=addslashes($_POST['date']);

$note='Envoie de l index ';

require 'fonction.php';
$sqlp="INSERT INTO $tb_echangreponse  (idv   , id_nom   ,niveau,  nom   , dater )
                    VALUES       ('$idv','$id_nom',  '$niveau' ,'$nom', '$dater')";
					
													
$r=mysqli_query($linki,$sqlp);
mysqli_close($linki);

?>
<?php
header("location: client_demande_suvi.php");
?>