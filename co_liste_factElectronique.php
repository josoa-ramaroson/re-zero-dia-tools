<?php
Require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
?>
<?
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
  <?php
require 'configuration.php';
$sql = "SELECT count(*) FROM $tbl_contact c , $tbl_fact f  where c.email!='' and f.id=c.id  ";  
$resultat = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
$nb_total = mysqli_fetch_array($resultat);  
if (($nb_total = $nb_total[0]) == 0) {  
echo 'Aucune reponse trouvee';  
}  
else { 
if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
$nb_affichage_par_page = 50; 
$sql = " SELECT * FROM $tbl_fact f , $tbl_contact c  where  c.email!='' and f.id=c.id and f.nserie=$nserie and f.fannee=$anneec ORDER BY f.id ASC  LIMIT ".$_GET['debut'].",".$nb_affichage_par_page;  
$req = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
?>
</p>
<H1>ENVOI DES COURRIELS : <a href="#?&<?php echo md5(microtime()); ?>" onClick="return !window.open(this.href, 'pop',  'width=600,height=370,left=120,top=120');" class="btn btn-sm btn-success"  target=_blank  >MASS-EMAIL </a></H1>
<p>&nbsp; </p>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
   <tr bgcolor="#3071AA">
     <td width="6%" align="center"><font color="#FFFFFF">ID Client</font></td>
     <td width="17%" align="center"><font color="#FFFFFF" size="4"><strong>Nom du client </strong></font></td>
     <td width="14%" align="center" bgcolor="#3071AA"><font color="#FFFFFF" size="4"><strong>Ville</strong></font></td>
     <td width="10%" align="center"><font color="#FFFFFF" size="3"><strong>Quartier </strong></font></td>
     <td width="10%" align="center"><font color="#FFFFFF"><strong>N°F</strong></font></td>
     <td width="12%" align="center"><font color="#FFFFFF"><strong>email</strong></font></td>
     <td width="11%" align="center"><font color="#FFFFFF"><strong>Montant Total</strong></font></td>
   </tr>
   <?php
while($datafact=mysqli_fetch_array($req)){ // Start looping table row 
?>
   <tr>
     <td align="center" bgcolor="#FFFFFF"><font color="#000000">
	   
    
  <a href="http://client.sonelecanjouan.com/email_envoi.php?id=<?php echo md5(microtime());?>&nomclient=<?php echo $datafact['nomprenom'];?>&email=<?php echo $datafact['email'];?>&montant=<?php echo $datafact['totalnet'];?>&date=<?php echo $datcoupure;?>" 
  onclick="return !window.open(this.href, 'pop',  'width=600,height=370,left=120,top=120');"
  class="btn btn-sm btn-default" target="_blank" >
   
     <img src="images/email.gif" width="20" height="20"></a></font></td>
     
     <td  bgcolor="#FFFFFF"><font color="#000000"><?php echo $datafact['nomprenom'];?></font></td>
     <td align="center" bgcolor="#FFFFFF"><font color="#000000"><?php echo $datafact['ville'];?></font></td>
     <td align="center" bgcolor="#FFFFFF"><font color="#000000"><?php echo $datafact['quartier'];?></font></td>
     <td align="center" bgcolor="#FFFFFF"><font color="#000000"><?php echo $datafact['idf'];?></font></td>
     <td align="center" bgcolor="#FFFFFF"><em><font color="#000000"><?php echo $datafact['email'];?></font></em></td>
     <td align="center" bgcolor="#FFFFFF"><font color="#000000"><?php echo $datafact['totalnet'];?></font></td>
   </tr>
   <?php
}
mysqli_free_result ($req); 
   echo '<span class="gras">'.barre_navigation($nb_total, $nb_affichage_par_page, $_GET['debut'], 10).'</span>';  
}  
mysqli_free_result ($resultat);  
mysqli_close($linki);  
?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>