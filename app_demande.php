<?php 
require 'session.php';
require 'fonction.php';
require 'fc-affichage.php';
require_once('calendar/classes/tc_calendar.php');
?>
<?php 
	if($_SESSION['u_niveau'] != 40) {
	header("location:index.php?error=false");
	exit;
 }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include 'titre.php' ?></title>
<script language="javascript" src="calendar/calendar.js"></script>
<script language="JavaScript" src="js/validator.js" type="text/javascript" xml:space="preserve"></script>
<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function AjaxFunction() {
    var httpxml;
    
    // Création de l'objet XMLHttpRequest avec gestion des différents navigateurs
    try {
        // Firefox, Opera 8.0+, Safari
        httpxml = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            httpxml = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                httpxml = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("Your browser does not support AJAX!");
                return false;
            }
        }
    }

    // Fonction de callback
    httpxml.onreadystatechange = function() {
        if (httpxml.readyState == 4) {
            if (httpxml.status == 200) {
                try {
                    var myarray = JSON.parse(httpxml.responseText);
                    
                    // Récupération du select
                    var subcatSelect = document.testform.subcat;
                    
                    // Suppression des anciennes options
                    while (subcatSelect.options.length > 0) {
                        subcatSelect.remove(0);
                    }
                    
                    // Ajout des nouvelles options
                    myarray.data.forEach(function(item) {
                        var optn = document.createElement("OPTION");
                        optn.text = item.service;
                        optn.value = item.idser;
                        subcatSelect.add(optn);
                    });
                } catch (e) {
                    console.error("Erreur parsing JSON:", e);
                }
            } else {
                console.error("Erreur HTTP:", httpxml.status);
            }
        }
    };

    // Préparation et envoi de la requête
    var idrh = document.getElementById('s1').value;
    var url = "rh_fonction_direction.php?idrh=" + encodeURIComponent(idrh) + "&sid=" + Math.random();
    
    httpxml.open("GET", url, true);
    httpxml.send(null);
}
</script>
</head>
<?php
require 'bienvenue.php';  
	$sqldate="SELECT * FROM $tbl_app_caisse "; //DESC  ASC
	$resultldate=mysqli_query($linki, $sqldate);
	$datecaisse=mysqli_fetch_array($resultldate);
?>
<body>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Demande d'Achat </h3>
  </div>
  <div class="panel-body">
    <form action="app_demande_save.php" method="post" name="testform" id="form1">
      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
        <tr>
          <td width="11%">&nbsp;</td>
          <td width="1%">&nbsp;</td>
          <td width="35%">&nbsp;</td>
          <td width="1%">&nbsp;</td>
          <td width="12%">&nbsp;</td>
          <td width="40%"><font size="2"><strong><font size="2"><strong><font color="#FF0000">
            <input name="id_nom" type="hidden" id="id_nom" value="<?php echo $id_nom; ?>" />
          </font><font size="2"><strong><font size="2"><strong><font size="2"><strong><font color="#FF0000">
          </font></strong></font></strong></font></strong></font></strong></font></strong></font></td>
        </tr>
        <tr>
          <td><strong><font size="2">Date</font></strong></td>
          <td>&nbsp;</td>
          <td><input name="date_dem" type="text" id="date_dem" value="<?php echo $datecaisse['datecaisse'];?>" size="30" readonly /></td>
          <td>&nbsp;</td>
          <td><strong><font size="2">Direction</font></strong></td>
          <td><?Php
echo "<br><select name=direction id='s1' onchange=\"AjaxFunction()\";>
<option value=''>Choisissez une direction</option>";

$sql = "SELECT idrh,direction  FROM $tb_rhdirection";
$result = mysqli_query($linki, $sql);
while($row = mysqli_fetch_assoc($result)) {
    echo "<option value=" . $row['idrh'] . ">" . $row['direction'] . "</option>";
}
mysqli_free_result($result);
?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong><font size="2">Nom du demandeur </font></strong></td>
          <td>&nbsp;</td>
          <td><strong>
            <input name="nomprenom" type="text" id="nomprenom" size="40" />
          </strong></td>
          <td>&nbsp;</td>
          <td><strong><font size="2">Service</font></strong></td>
          <td><select name=subcat id='s2'>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><strong><span style="font-size:8.5pt;font-family:Arial">
            <input type="submit" name="Submit" value="Enregistrer" class="btn btn-sm btn-primary"/>
          </span></strong></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<p><font size="2"><font size="2"><font size="2">
<?php

$sql = "SELECT count(*) FROM $tbl_appdemande where statut='Traitement' ";  

$resultat = mysqli_query($linki, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
 
 
$nb_total = mysqli_fetch_array($resultat);  

if (($nb_total = $nb_total[0]) == 0) {  
echo 'Aucune reponse trouvee';  
}  
else { 

if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
    

   $nb_affichage_par_page = 10; 
   
 
$sql = "SELECT * FROM $tbl_appdemande  where statut='Traitement' ORDER BY id_dem DESC LIMIT ".$_GET['debut'].",".$nb_affichage_par_page;  //ASC
 

$req = mysqli_query($linki, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
?>
</font></strong></font></font></font></font></font></font></font></font></font></strong></font></font></font></font></font></font></font></font></font></font></p>
<form name="form2" method="post" action="produit_cancel.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
    <tr bgcolor="#FFFFFF">
      <td width="64" align="center" bgcolor="#3071AA" ><font color="#FFFFFF" size="4"><strong>N&deg;</strong></font></td>
      <td width="266" align="center" bgcolor="#3071AA"><font color="#FFFFFF">Date </font></td>
      <td width="313" align="center" bgcolor="#3071AA" ><font color="#FFFFFF">Nom du demandeur </font></td>
      <td width="192" align="center" bgcolor="#3071AA" ><font color="#FFFFFF">Direction </font></td>
      <td width="162" align="center" bgcolor="#3071AA" ><font color="#FFFFFF">Service </font></td>
      <td width="163" align="center" bgcolor="#3071AA" >&nbsp;</td>
      <td width="163" align="center" bgcolor="#3071AA" >&nbsp;</td>
    </tr>
    <?php
while($data=mysqli_fetch_array($req)){ // Start looping table row 
?>
    <tr>
      <td align="center" bgcolor="#FFFFFF"><div align="left"><?php echo $data['id_dem'];?></div>
        <div align="left"></div></td>
      <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['date_dem'];?></em></div></td>
      <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['nomprenom'];?></em></div></td>
      <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['direction'];?></em></div></td>
      <td width="162"   style="background-color:#FFF;"><div align="left"><em><?php echo $data['service'];?></em></div></td>
      <td width="163"   style="background-color:#FFF;"><a href="app_demande_produit.php?id=<?php echo md5(microtime()).$data['id_dem']; ?>" class="btn btn-xs btn-success">Ajouter des produits</a></td>
      <td width="163"   style="background-color:#FFF;"><a href="app_demande_archive.php?ID=<?php echo md5(microtime()).$data['id_dem']; ?>" onClick="return confirm('Etes-vous sûr de vouloir Archiver ')" ; style="margin:5px"   class="btn btn-xs btn-danger" >Archiver</a></td>
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
</form>
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
</body>
</html>
<script language="JavaScript" type="text/javascript" xml:space="preserve"> 
    var frmvalidator  = new Validator("form1");
	frmvalidator.EnableOnPageErrorDisplaySingleBox();
    frmvalidator.EnableMsgsTogether();


	frmvalidator.addValidation("nomprenom","req","nomprenom");
    frmvalidator.addValidation("direction","req","direction");
	
</script>