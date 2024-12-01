<?php
Require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
require 'configuration.php';
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

$sqlu = "SELECT * FROM $tbl_saisie where blogin='$id_nom'";
$resultu = mysqli_query($linki,$sqlu);

while ($rowu = mysqli_fetch_assoc($resultu)) {
$bville=$rowu['bville'];
$bquartier=$rowu['bquartier'];
global $bville;
global $bquartier;
}  

?>
<body>
 <table width="100%" border="0">
   <tr>
     <td width="42%"><a href="co_facturation_listeFacT.php" class="btn btn-sm btn-success" > LISTE DES FACTURATIONS BT  triphase  </a> | <a href="co_facturation_listeNoFacT.php" class="btn btn-sm btn-success" > LISTE DES  BT NON FACTURE  BT  triphase </a> </td>
     <td width="13%"><?php echo  $bville ?> </td>
     <td width="16%"><?php echo  $bquartier ?> </td>
     <td width="29%"><form name="form1" method="post" action="co_facturationuser.php">
                   <label for="mr1"></label>
                   <input name="mr1" type="text" id="mr1" size="30">
                   <input type="submit" name="Cherchez " id="Cherchez " class="btn btn-sm btn-default"value="Chercher par ID">
                 </form></td>
   </tr>
 </table>
 <p>
   <?php

$sql = "SELECT count(*) FROM $tbl_contact where ville='$bville'  and quartier='$bquartier' and statut='6' and  (Tarif='1' or Tarif='5'  or Tarif='12') and id NOT IN(SELECT id FROM $tbl_factsave where annee='$anneec' and nserie='$nserie')";  
$resultat = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
$nb_total = mysqli_fetch_array($resultat);  
if (($nb_total = $nb_total[0]) == 0) {  
echo '</br>';
echo 'Veuillez choisir la Ville et le quartier pour debuter la saisie des factures';  
}  
else { 
if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
$nb_affichage_par_page = 1; 
$sql = "SELECT * FROM $tbl_contact where  ville='$bville'  and quartier='$bquartier' and statut='6' and  (Tarif='1' or Tarif='5'  or Tarif='12') and id NOT IN(SELECT id FROM $tbl_factsave where annee='$anneec'  and nserie='$nserie') ORDER BY id ASC LIMIT ".$nb_affichage_par_page." OFFSET ".$_GET['debut'];  
$req = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  

	//recherche du repport 
?>
 </p>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
   <tr bgcolor="#3071AA">
     <td width="47%" align="center">&nbsp;</td>
     <td width="53%" align="center">&nbsp;</td>
  </tr>
   <?php
while($data=mysqli_fetch_array($req)){ // Start looping table row 
?>
   <tr>
     <td align="center" bgcolor="#FFFFFF"><form name="form1" method="post" action="">
       <table width="100%" height="201" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
         <tr>
           <td width="34%">ID_CLIENT</td>
           <td width="2%">&nbsp;</td>
           <td width="64%"><strong> <?php $idcl=$data['id']; echo $data['id'];?></strong></td>
         </tr>
         <tr>
           <td>Police </td>
           <td>&nbsp;</td>
           <td><strong><?php echo $data['Police'];?></strong></td>
         </tr>
         <tr>
           <td><strong><font color="#000000" size="2">Reference géographique</font></strong></td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>Coefficient TI</td>
           <td>&nbsp;</td>
           <td><?php echo $data['coefTi'];?></td>
         </tr>
         <tr>
           <td><strong><font size="2">Nom et Prénom <font size="2"><font color="#FF0000"> *</font></font></font></strong></td>
           <td>&nbsp;</td>
           <td><?php echo $data['nomprenom'];?></td>
         </tr>
         <tr>
           <td><strong><font size="2">Ville</font></strong></td>
           <td>&nbsp;</td>
           <td><strong><?php echo $data['ville'];?></strong></td>
         </tr>
         <tr>
           <td><strong><font size="2"><font size="2">Quartier</font></font></strong></td>
           <td>&nbsp;</td>
           <td><strong><?php echo $data['quartier'];?></strong></td>
         </tr>
       </table>
       <?php
   
	 //recherche du repport 
	 $sqlp = "SELECT * FROM $tbl_fact WHERE id='$idcl' and st='E' ORDER BY idf desc limit 0,1";  
	 $resultp=mysqli_query($linki,$sqlp);
	 $datap=mysqli_fetch_array($resultp);
			
	//affichage des facturations
	$sqfac="SELECT * FROM $tbl_fact  WHERE id='$idcl' and  st='E' ORDER BY idf desc limit 0,1";
	$resultfac=mysqli_query($linki,$sqfac);
	$datindex=mysqli_fetch_array($resultfac);
			?>
     </form></td>
     <td align="center" bgcolor="#FFFFFF"><form name="form2" method="post" action="co_facturation_saveT.php">
       <table width="100%" height="201" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
         <tr>
           <td width="23%">&nbsp;</td>
           <td width="2%">&nbsp;</td>
           <td width="25%">&nbsp;</td>
           <td width="50%">&nbsp;</td>
         </tr>
         <tr>
           <td>Index Actuel</td>
           <td>&nbsp;</td>
           <td><strong>
             <input class="form-control" name="nf" type="text" id="nf" size="20" />
           </strong></td>
           <td>S.I</td>
         </tr>
         <tr>
           <td>Nouveau Index</td>
           <td>&nbsp;</td>
           <td><strong>
             <input name="n" type="text" class="form-control" id="n" value="<?php
  	  if(!isset($datindex['nf'])|| empty($datindex['nf'])){ echo 0;} else { echo $datindex['nf'];} ?>" size="20" readonly />
           </strong></td>
           <td>S.I</td>
         </tr>
         <tr>
           <td>Ancien Index</td>
           <td>&nbsp;</td>
           <td><strong>
             <input name="a" type="text" class="form-control" id="a" value="<?php
  	  if(!isset($datindex['n'])|| empty($datindex['n'])){ echo 0;} else { echo $datindex['n'];} ?>" size="20" readonly />
           </strong></td>
           <td>S.I</td>
         </tr>
         <tr>
           <td>Impayé</td>
           <td>&nbsp;</td>
           <td><strong>
             <input name="impayee" type="text" class="form-control" id="impayee" value="<?php
  	  if(!isset($datap['report'])|| empty($datap['report'])){ echo 0;} else { echo $datap['report'];} ?>" size="20" readonly />
           </strong></td>
           <td>KMF<font color="#FF0000">
           <input name="idf" type="hidden" id="idf" value="<?php echo $datap['idf']; ?>" />
           <input name="Tarif" type="hidden" id="Tarif" value="<?php echo $data['Tarif']; ?>" />
           <input name="amperage" type="hidden" id="amperage" value="<?php echo $data['amperage']; ?>" />
           <input name="chtaxe" type="hidden" id="chtaxe" value="<?php echo $data['chtaxe']; ?>" />
           <input name="Police" type="hidden" id="Police" value="<?php echo $data['Police']; ?>" />
           </font></td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td><input type="submit" name="button" id="button" value="Enregistre le montant " /></td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td><input name="id" type="hidden" id="id" value="<?php echo $data['id']; ?>" />
             <input name="st" type="hidden" value="E" />
             <font color="#FF0000">
             <input name="id_nom" type="hidden" id="id_nom" value="<?php echo $id_nom; ?>" />
             </font><font color="#FF0000">
             <input name="libelle" type="hidden" id="libelle" value="Facture" />
             </font><font color="#FF0000">
             <input name="bstatut" type="hidden" id="bstatut" value="saisie" />
             </font><font color="#FF0000">
             <input name="bnom" type="hidden" id="bnom" value="<?php echo $data['nomprenom']; ?>" />
             </font><font color="#FF0000">
             <input name="bquartier" type="hidden" id="bquartier" value="<?php echo $data['quartier']; ?>" />
             </font><strong>
             <input name="coefTi" type="hidden" class="form-control" id="coefTi" value="<?php echo $data['coefTi'];?>" size="20" />
             </strong><font color="#FF0000">
             <input name="id_user" type="hidden" id="id_user" value="<?php echo $id_user; ?>" />
             </font><strong><font color="#FF0000"></td>
         </tr>
       </table>
     </form></td>
   </tr>
   <?php
}
mysqli_free_result ($req); 
   echo '<span class="gras">'.barre_navigation($nb_total, $nb_affichage_par_page, $_GET['debut'], 10).'</span>';  
}  
mysqli_free_result ($resultat);  
mysqli_close ($linki);  
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