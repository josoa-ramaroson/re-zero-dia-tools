<?php
Require("session.php"); 
require"fc-affichage.php";
?>
<?php
if(($_SESSION['u_niveau'] != 40)) {
	header("location:index.php?error=false");
	exit;
 }
?>
<html>
<head>
<title><?php include("titre.php"); ?></title>
<meta name="viewport" content="width=device-width, minimum-scale=0.25"/>
<script language="JavaScript" src="js/validator.js" type="text/javascript" xml:space="preserve"></script>

</head>
<?php
Require("bienvenue.php"); 
//$_SESSION['niveau'];
?>
<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
<div class="panel panel-primary">
<div class="panel-heading">
  <h3 class="panel-title">Ajouter le nom du produit </h3>
</div>
 <div class="panel-body">
 
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="47%"><form name="form1" method="post" action="app_produit_liste_save.php">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32%">&nbsp;</td>
          <td width="68%">&nbsp;</td>
          </tr>
        <tr> 
          <td><strong>NOM DU PRODUIT</strong></td>
          <td><input class="form-control" name="titre" type="text" id="titre" value="" size="40"></td>
          </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr> 
          <td><strong>PRIX </strong></td>
          <td><input class="form-control" name="prix" type="text" id="prix" value="" size="40" readonly></td>
          </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td><strong>
            <select name="type" id="type">
              <option value="2">MAGASIN</option>
            </select>
          </strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><font size="2"><strong><font size="2"><strong><font color="#FF0000">
            <input name="id_nom" type="hidden" id="id_nom" value="<?php echo $id_nom; ?>">
          </font></strong></font></strong></font></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="Submit" value="Enregistrer"></td>
        </tr>
        </table>
      </form></td>
    <td width="53%">&nbsp;</td>
  </tr>
</table>
</div>
</div>
<p><font size="2"><font size="2"><font size="2">
  <?php
require 'fonction.php';

// Connect to server and select databse.
mysqli_connect ($host,$user,$pass)or die("cannot connect"); 
mysqli_select_db($db)or die("cannot select DB");

// on pr?pare une requ?te permettant de calculer le nombre total d'?l?ments qu'il faudra afficher sur nos diff?rentes pages  
$sql = "SELECT count(*) FROM $tbl_appproduit_liste";  

// on ex?cute cette requ?te  
$resultat = mysqli_query($link, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($link));
 
// on r?cup?re le nombre d'?l?ments ? afficher  
$nb_total = mysqli_fetch_array($resultat);
 // on teste si ce nombre de vaut pas 0  
if (($nb_total = $nb_total[0]) == 0) {  
echo 'Aucune reponse trouvee';  
}  
else { 
        // premi?re ligne on affiche les titres pr?nom et surnom dans 2 colonnes
  
    
   
// sinon, on regarde si la variable $debut (le x de notre LIMIT) n'a pas d?j? ?t? d?clar?e, et dans ce cas, on l'initialise ? 0  
if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
    
	// 6 maroufchangement 1 par 5
   $nb_affichage_par_page = 40; 
   
// Pr?paration de la requ?te avec le LIMIT  
$sql = "SELECT * FROM $tbl_appproduit_liste  ORDER BY idproduit DESC LIMIT ".$_GET['debut'].",".$nb_affichage_par_page;  //ASC
 
// on ex?cute la requ?te  
$req = mysqli_query($link, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($link));
?>
  </font></strong></font></font></font></font></font></font></font></font></font></strong></font></font></font></font></font></font></font></font></font></font></p>
<form name="form2" method="post" action="app_produit_liste_cancel.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
    <tr bgcolor="#000000"> 
      <td width="15%" align="center" bgcolor="#0033FF"><font color="#CCCCCC" size="4"><strong>N&deg; Enregistrement</strong></font></td>
      <td width="35%" align="center" bgcolor="#0033FF"><font color="#CCCCCC" size="3"><strong> 
        Produit </strong></font></td>
      <td width="8%" align="center" bgcolor="#0033FF"><font color="#CCCCCC" size="3">&nbsp;</font></td>
      <td width="19%" align="center" bgcolor="#0033FF">&nbsp;</td>
      <td width="23%" align="center" bgcolor="#0033FF">&nbsp;</td>
    </tr>
    <?php
while($data=mysqli_fetch_array($req)){ // Start looping table row
?>
    <tr> 
      <td height="29" align="center" bgcolor="#FFFFFF"> <div align="left"><?php echo $data['idproduit'];?></div>
        <div align="left"></div></td>
      <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['titre'];?></em></div></td>
      <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['prix'];?></em></div></td>
      <td align="center" bgcolor="#FFFFFF"><a href="app_produit_liste_modifie.php?id=<?php echo $data['idproduit']; ?>" class="btn btn-xs btn-success"><?php echo 'Modifier' ?></a></td>
      <td width="50"   style="background-color:#FFF;"> <?php /* <a href="stk_produit_cancel.php?ID=<?php echo $data['idproduit']; ?>" onClick="return confirm('Etes-vous s�r de vouloir supprimer')" ; style="margin:5px" class="btn btn-xs btn-danger">
        Supprimer <a> */ ?> </td> 
    </tr>
    <?php
// Exit looping and close connection 
}
// on lib?re l'espace m?moire allou? pour cette requ?te  
mysqli_free_result ($req); 
 
   // on affiche enfin notre barre 20 avant de passer a l autre page
   echo '<span class="gras">'.barre_navigation($nb_total, $nb_affichage_par_page, $_GET['debut'], 10).'</span>';  
}  
// on lib?re l'espace m?moire allou? pour cette requ?te  
mysqli_free_result ($resultat);  
// on ferme la connexion ? la base de donn?es.  
mysqli_close($link);  
?>
  </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td> <div align="center"></div></td>
  </tr>
  <tr> 
    <td height="21">&nbsp; </td>
  </tr>
  <tr> 
    <td height="21"> 
      <?php
include_once('pied.php');
?>
    </td>
  </tr>
</table>
<p>&nbsp; </p>
</body>
</html>
<script language="JavaScript" type="text/javascript" xml:space="preserve">//<![CDATA[
  var frmvalidator  = new Validator("form1");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("titre","req","SVP enregistre le libelle");
//]]></script>