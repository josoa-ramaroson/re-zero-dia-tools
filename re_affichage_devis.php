<?php
require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
?>
<?php
	if(($_SESSION['u_niveau'] != 1)&& ($_SESSION['u_niveau'] != 42)&& ($_SESSION['u_niveau'] != 42)
	    && ($_SESSION['u_niveau'] != 43) && ($_SESSION['u_niveau'] != 44)&& ($_SESSION['u_niveau'] != 90)&& ($_SESSION['u_niveau'] != 46)){
	header("location:index.php?error=false");
	exit;
 }
?>
<html>
<head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include 'titre.php' ?></title>
</head>
<?php
Require 'bienvenue.php';    // on appelle la page contenant la fonction
?>
<body>
 <p>
Demande de devis</p>
 <p>
  <?php
$sql = "SELECT count(*) FROM $tbl_contact  where statut='2'";  
$resultat = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
$nb_total = mysql_fetch_array($resultat);  
if (($nb_total = $nb_total[0]) == 0) {  
echo 'Aucune reponse trouvee';  
}  
else { 
if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
$nb_affichage_par_page = 50; 
$sql = "SELECT * FROM $tbl_contact  where statut='2' ORDER BY nomprenom ASC LIMIT ".$_GET['debut'].",".$nb_affichage_par_page;  
$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
?>
 </p>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
   <tr bgcolor="#3071AA">
     <td width="8%" align="center"><font color="#FFFFFF" size="4"><strong>ID </strong></font></td>
     <td width="25%" align="center"><font color="#FFFFFF" size="3"><strong>Nom et Prenom </strong></font></td>
     <td width="13%" align="center"><font color="#FFFFFF"><strong>Tel</strong> </font></td>
     <td width="21%" align="center"><font color="#FFFFFF"><strong>Ville</strong></font></td>
     <td width="13%" align="center"><font color="#FFFFFF"><strong>Quartier</strong></font></td>
     <td width="8%" align="center">&nbsp;</td>
  </tr>
   <?php
while($data=mysql_fetch_array($req)){ // Start looping table row 
?>
   <tr>
     <td align="center" bgcolor="#FFFFFF"><div align="left"><em><a href="re_affichage_user.php?id=<?php echo md5(microtime()).$data['id']; ?>" class="btn btn-sm btn-default" ><?php echo $data['id'];?></a></em></div></td>
     <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['nomprenom'];?></em></div></td>
     <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['tel'];?></em></div></td>
     <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['ville'];?></em></div></td>
     <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['quartier'];?></em></div></td>
     <td align="center" bgcolor="#FFFFFF"><a href="re_affichage_user.php?id=<?php echo md5(microtime()).$data['id']; ?>" class="btn btn-sm btn-warning" >Aperçu</a></td>
   </tr>
   <?php
}
mysql_free_result ($req); 
   echo '<span class="gras">'.barre_navigation($nb_total, $nb_affichage_par_page, $_GET['debut'], 10).'</span>';  
}  
mysql_free_result ($resultat);  
mysql_close ();  
?>
</table>
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
  </tr>
  <tr>
    <td height="21"><?php
include_once('pied.php');
?></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>