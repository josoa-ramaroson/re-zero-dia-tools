<?php
Require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
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
 <p>&nbsp;</p>
 <table width="99%" border="0">
   <tr>
     <td width="2%">&nbsp;</td>
     <td width="44%"><div class="panel panel-warning">
       <div class="panel-heading">
         <h3 class="panel-title">Historique des Ch.Nom , Transfert , Compteur </h3>
       </div>
       <div class="panel-body">
         <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
           <tr>
             <td width="47%"><table width="100%" border="0.5" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="52%"><form action="z_re_edit_modif_liste.php" method="post" name="form1" id="form1">
                   <label for="mr2"></label>
                   <font color="#000000">
                     <select name="annee" size="1" id="annee">
                       <?php
$sql81 = ("SELECT * FROM z_annee  ORDER BY annee ASC ");
$result81 = mysqli_query($linki,$sql81);

while ($row81 = mysqli_fetch_assoc($result81)) {
echo '<option> '.$row81['annee'].' </option>';
}
?>
                     </select>
                     </font>
                   <input type="submit" name="Cher" id="Cher" class="btn btn-sm btn-warning"value="Afficher" />
                 </form></td>
               </tr>
             </table></td>
           </tr>
         </table>
       </div>
     </div></td>
     <td width="5%">&nbsp;</td>
     <td width="49%"><div class="panel panel-primary">
       <div class="panel-heading">
         <h3 class="panel-title">Trie par Statut</h3>
       </div>
       <div class="panel-body">
         <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
           <tr>
             <td width="47%"><table width="100%" border="0.5" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="52%"><form action="re_edit_modif_liste_trie.php" method="post" name="form1" id="form1">
                   <label for="mr2"></label>
                   <font color="#000000">
                     <select name="etat" size="1" id="etat">
                       <option value="accompte">accompte</option>
                       <option value="facture">facture</option>
</select>
                     </font>
                   <input type="submit" name="Cher" id="Cher" class="btn btn-sm btn-primary"value="Afficher" />
                 </form></td>
               </tr>
             </table></td>
           </tr>
         </table>
       </div>
     </div></td>
   </tr>
 </table>
 <p>
   <?php
$sql = "SELECT count(*) FROM $tbl_fact where st='A' and libelle!='Gaz'  ";  
$resultat = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
$nb_total = mysqli_fetch_array($resultat);  
if (($nb_total = $nb_total[0]) == 0) {  
echo 'Aucune reponse trouvee';  
}  
else { 
if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
$nb_affichage_par_page = 50; 
$sql = "SELECT * FROM $tbl_fact where st='A' and libelle!='Gaz' ORDER BY idf desc LIMIT ".$nb_affichage_par_page." OFFSET ".$_GET['debut'];  
$req = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
?>
 </p>
 <table width="98%" border="1" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
   <tr bgcolor="#3071AA">
     <td width="10%" align="center">&nbsp;</td>
     <td width="7%" align="center"><font color="#FFFFFF" size="4"><strong>N°Facture </strong></font></td>
     <td width="12%" align="center"><font color="#FFFFFF" size="3"><strong>Vendeur</strong></font></td>
     <td width="12%" align="center" bgcolor="#3071AA"><font color="#FFFFFF" size="3"><strong>Date</strong></font></td>
     <td width="11%" align="center"><font color="#FFFFFF"><strong>Nom</strong></font></td>
     <td width="17%" align="center"><font color="#FFFFFF"><strong>Libelle</strong></font></td>
     <td width="10%" align="center"><font color="#FFFFFF"><strong>Montant</strong></font></td>
     <td width="12%" align="center"><font color="#FFFFFF"><strong>Reste à payer</strong></font></td>
     <td width="9%" align="center"><strong><font color="#FFFFFF">Statut</font></strong></td>
   </tr>
   <?php
while($data=mysqli_fetch_array($req)){ // Start looping table row 
   ?>
   <tr bgcolor="<?php gettatut($data['etat']); ?>">
     <td align="center" ><?php if (($data['etat']!="facture")and ($data['etat']!="Annuler")){?>
       <a href="paiement_penalite.php?idf=<?php echo md5(microtime()).$data['idf']; ?>" class="btn btn-sm btn-success"> les détails</a>
       <?php } else {} ?>
      
       </td>
     <td align="center" ><em><a href="re_affichage_user.php?id=<?php echo md5(microtime()).$data['id']; ?>" class="btn btn-sm btn-default" ><?php echo $data['idf'];?></a></em></td>
     <td align="center" ><em><?php echo $data['id_nom'];?></em></td>
     <td align="center" ><em><?php echo $data['date'];?></em></td>
     <td align="center" ><em><?php echo $data['bnom'];?></em></td>
     <td align="center"><em><?php echo $data['libelle'];?></em></td>
     <td align="center"><em><?php echo $data['totalnet'];?></em></td>
     <td align="center"><em><?php echo $data['report'];?></em></td>
     <td align="center"><em><?php echo $data['etat'];?></em></td>
   </tr>
   <?php

  }


mysqli_free_result ($req); 
   echo '<span class="gras">'.barre_navigation($nb_total, $nb_affichage_par_page, $_GET['debut'], 10).'</span>';  
}  
mysqli_free_result ($resultat);  
mysqli_close($linki);  
	function gettatut($fetat){
				 if ($fetat=='enregistre')    { echo $couleur="#87e385";}//jaune	
				 if ($fetat=='paye')          { echo $couleur="#87e385";}//vert fonce
				 if ($fetat=='accompte')      { echo $couleur="#fdff00";}//jaune
				 if ($fetat=='Annuler')       { echo $couleur="#ec9b9b";}//orange
				 }   
?>
 </table>
 <p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>