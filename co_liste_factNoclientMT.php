<?php
require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
?>
<?php
if(($_SESSION['u_niveau'] != 2)) {
	header("location:index.php?error=false");
	exit;
 }
?>
<html>
<head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
</head>
<?php
Require 'bienvenue.php';    // on appelle la page contenant la fonction
?>
<body>
 <p>
<a href="co_liste_factNoimpMT.php" target="_blank"><img src="images/imprimante.png" width="50" height="30"></a>
<?php
require 'configuration.php';
$sql = "SELECT count(*) FROM  $tbl_contact where statut='6' and Tarif=10 and id NOT IN(SELECT id FROM $tbl_factsave where annee='$anneec'  and nserie='$nserie') ";  
$resultat = mysqli_query($link, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($link));
$nb_total = mysqli_fetch_array($resultat);
if (($nb_total = $nb_total[0]) == 0) {  
echo 'Aucune reponse trouvee';  
}  
else { 
if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
$nb_affichage_par_page = 50; 
$sql = "SELECT * FROM $tbl_contact where  statut='6' and Tarif=10 and id NOT IN(SELECT id FROM $tbl_factsave where annee='$anneec'  and nserie='$nserie' ) ORDER BY id  ASC LIMIT ".$_GET['debut'].",".$nb_affichage_par_page;  
$req = mysqli_query($link, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($link));
?>
 </p>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
   <tr bgcolor="#3071AA">
     <td width="14%" align="center"><font color="#FFFFFF" size="4"><strong>Id_Client </strong></font></td>
     <td width="28%" align="center"><font color="#FFFFFF" size="4"><strong>Nom Raison social </strong></font></td>
     <td width="18%" align="center"><font color="#FFFFFF" size="4"><strong>Ville</strong></font></td>
     <td width="13%" align="center"><font color="#FFFFFF" size="3"><strong>Quartier </strong></font></td>
     <td width="14%" align="center"><font color="#FFFFFF" size="4"><strong>Index Jour</strong></font></td>
     <td width="13%" align="center"><font color="#FFFFFF"><strong>Index Nuit </strong></font></td>
   </tr>
   <?php
while($data=mysqli_fetch_array($req)){ // Start looping table row
?>
   <tr>
     <td align="center" bgcolor="#FFFFFF"><strong>
       <?php $idcl=$data['id']; echo $data['id'];?>
     </strong></td>
     <td bgcolor="#FFFFFF"><font color="#000000"><?php echo $data['nomprenom'];?></font></td>
     <td bgcolor="#FFFFFF"><strong><?php echo $data['ville'];?></strong></td>
     <td bgcolor="#FFFFFF"><strong><?php echo $data['quartier'];?></strong></td>
     <td bgcolor="#FFFFFF">&nbsp;</td>
     <td bgcolor="#FFFFFF">&nbsp;</td>
   </tr>
   <?php
}
mysqli_free_result ($req); 
   echo '<span class="gras">'.barre_navigation($nb_total, $nb_affichage_par_page, $_GET['debut'], 10).'</span>';  
}  
mysqli_free_result ($resultat);  
mysqli_close($link);
?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>