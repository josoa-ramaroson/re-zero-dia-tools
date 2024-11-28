<?php
require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
require_once('calendar/classes/tc_calendar.php');
?>

<html>
<head>
<title><?php include("titre.php"); ?></title>
<meta name="viewport" content="width=device-width, minimum-scale=0.25"/>
<script language="JavaScript" src="js/validator.js" type="text/javascript" xml:space="preserve"></script>
<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.centrevaleur {
	text-align: center;
}
.centrevaleur td {
	text-align: center;
}
.taille16 {	font-size: 16px;
}
</style>
<script language="javascript" src="calendar/calendar.js"></script>
</head>
<?php
?>
<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
<p><font size="2"><font size="2"><font size="2">
  <?php
 $date=substr($_REQUEST["date"],32);
  $ARCH=date("Y", strtotime("$date"));
 
// Connect to server and select databse.

  
$sql = "SELECT count(*) FROM $dbbk.z_"."$ARCH"."_$tbl_paiement";  

$resultat = mysqli_query($linkibk,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());  
 
 
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
   $nb_affichage_par_page = 100; 
   

$sql = "SELECT SUM(paiement) AS Paie, st, date FROM $dbbk.z_"."$ARCH"."_$tbl_paiement where date='$date' GROUP BY  st  LIMIT ".$_GET['debut'].','.$nb_affichage_par_page;  //ASC  DESC

// on ex?cute la requ?te  
$req = mysqli_query($linkibk,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error()); 

?>
  </font></strong></font></font></font></font></font></font></font></font></font></strong></font></font></font></font></font></font></font></font></font></font></p>

  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#0000FF"> 
      <td width="28" align="center" bgcolor="#3071AA">&nbsp;</td>
      <td width="572" align="center" bgcolor="#3071AA"><font color="#FFFFFF" size="4"><strong>Activités</strong></font></td>
      <td width="287" align="center" bgcolor="#3071AA"><font color="#FFFFFF" size="4"><strong>Les recouvrements par date </strong></font></td>
      <td width="210" align="center" bgcolor="#3071AA"><font color="#FFFFFF" size="4"><strong>Par date</strong></font></td>
    </tr>
    <?php
while($data=mysqli_fetch_array($req)){ // Start looping table row 
?>
    <tr bgcolor="#FFFFFF">
      <td align="center">&nbsp;</td>
      <td> <?php $n=$data['st'];
                  if ($n=='E') echo 'FACTURATION CYCLIQUE';
                  if ($n=='P') echo 'POLICE D ABONNEMENT'; 
                  if ($n=='D') echo 'BRANCHEMENT';
                  if ($n=='F') echo 'FRAUDE'; 
				  if ($n=='A') echo 'Autre (Chang Nom/compteur/Activation/Transfert)'; 
                  ?></td>
      <td align="center"><?php $P=strrev(chunk_split(strrev($data['Paie']),3," "));   echo $P;?></td>
      <td align="center"><?php echo $data['date'];?></td>
    </tr>
    <?php

}

mysqli_free_result ($req); 
   //echo '<span class="gras">'.barre_navigation($nb_total, $nb_affichage_par_page, $_GET['debut'], 10).'</span>';  
}  
mysqli_free_result ($resultat);  


mysqli_close ($linkibk);  
?>
  </table>
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
