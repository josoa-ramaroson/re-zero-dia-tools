<?php
require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
require 'rh_configuration_fonction.php';
?>
<?php
if(($_SESSION['u_niveau'] != 50)) {
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
require 'bienvenue.php';    // on appelle la page contenant la fonction
?>
<body>
<table width="100%" border="0">
  <tr>
    <td width="42%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="16%">&nbsp;</td>
    <td width="39%"><div class="panel panel-danger">
      <div class="panel-heading">
        <h3 class="panel-title">Procedez aux modifications d'un bulletin</h3>
      </div>
      <div class="panel-body">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="47%"><table width="100%" border="0.5" cellspacing="0" cellpadding="0">
              <tr>
                <td width="52%"><form name="form1" method="post" action="rh_employer_paie_user.php">
                  <label for="mr1"></label>
                  <input name="mr1" type="text" id="mr1" size="30">
                  <input type="submit" name="Cherchez " id="Cherchez " class="btn btn-sm btn-default"value="Chercher par Matricule">
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

$mr1=addslashes($_POST['mr1']);
 
$sql = "SELECT * FROM  $tb_rhpaie where matricule='$mr1' and  anneepaie='$anneepaie' and moispaie='$moispaie'";  
$req = mysqli_query($link, $sql);  

	//recherche du repport 
?>
 </p>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
   <?php
while($datam=mysqli_fetch_array($req)){ // Start looping table row 
?>
   <tr>
   
     <td width="47%" align="center" bgcolor="#FFFFFF"><form name="form1" method="post" action="rh_employer_paie_user_save.php">
     
     <div class="panel panel-primary">
  <div class="panel-heading"><h3 class="panel-title">Informations personnelles de l'employés
    </h3>
  </div>
  <div class="panel-body">
    
      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
        <tr>
          <td width="18%"><span class="panel-title">
            <input name="ipaie" type="hidden" id="ipaie" value="<?php echo $datam['ipaie']; ?>" />
            <input name="idrh" type="hidden" id="idrh" value="<?php echo $datam['idrh']; ?>" />
            <font size="2"><strong><font size="2"><strong><font color="#FF0000">
            <input name="id_nom" type="hidden" id="id_nom" value="<?php echo $id_nom; ?>" />
            </font></strong></font></strong></font></span></td>
          <td width="2%">&nbsp;</td>
          <td width="30%">&nbsp;</td>
          <td width="3%">&nbsp;</td>
          <td width="22%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
          </tr>
        <tr>
          <td><strong><font size="2">Designation</font></strong></td>
          <td>&nbsp;</td>
          <td><strong>
            <input name="Designation" type="text" class="form-control" id="Designation" value="<?php echo $datam['Designation'];?>" size="10" readonly />
          </strong></td>
          <td>&nbsp;</td>
          <td><strong><font size="2">Matricule</font></strong></td>
          <td><strong>
            <input name="matricule" type="text" class="form-control" id="matricule" value="<?php echo $datam['matricule'];?>" size="10" readonly />
          </strong></td>
          </tr>
        <tr>
          <td><strong><font size="2">Nom et Prénom <font size="2"><font color="#FF0000"> *</font></font></font></strong></td>
          <td>&nbsp;</td>
          <td><strong>
            <input name="nomprenom" type="text" class="form-control" id="nomprenom" value="<?php echo $datam['nomprenom'];?>" size="40" readonly />
          </strong>&nbsp;</td>
          <td>&nbsp;</td>
          <td><strong><font size="2">Date d'embauche</font></strong></td>
          <td><strong>
            <input name="dembauche" type="text" class="form-control" id="dembauche" value="<?php echo $datam['dembauche'];?>" size="40" readonly />
          </strong></td>
          </tr>
        <tr>
          <td><strong>Titre </strong></td>
          <td>&nbsp;</td>
          <td><strong>
            <input name="titre" type="text"  class="form-control" id="titre" value="<?php echo $datam['titre'];?>" size="40" readonly />
          </strong></td>
          <td>&nbsp;</td>
          <td><strong><font size="2">Direction</font></strong></td>
          <td><strong>
            <input name="direction" type="text" class="form-control" id="direction" value="<?phpecho $datam['direction'];?>" size="40" readonly />
          </strong></td>
          </tr>
        <tr>
          <td><strong><font size="2">Ville</font></strong></td>
          <td>&nbsp;</td>
          <td><strong>
            <input name="ville" type="text"  class="form-control" id="ville" value="<?php echo $datam['ville'];?>" size="40" readonly />
          </strong></td>
          <td>&nbsp;</td>
          <td><strong><font size="2">Service</font></strong></td>
          <td><strong>
            <input name="service" type="text" class="form-control" id="service" value="<?phpecho $datam['service'];?>" size="40" readonly />
          </strong></td>
          </tr>
        <tr>
          <td>Congé</td>
          <td>&nbsp;</td>
          <td><strong>
            <input name="nconge" type="text"  class="form-control" id="nconge" value="<?php echo $datam['nconge'];?>" size="40" />
          </strong></td>
          <td>&nbsp;</td>
          <td><strong><font size="2">Taux de paiement</font></strong></td>
          <td><strong>
            <select name="Tin" id="Tin">
              <option selected="selected"><?php echo $datam['Tin'];?></option>
              <option>100</option>
              <option>90</option>
              <option>80</option>
              <option>70</option>
              <option>60</option>
              <option>50</option>
              <option>40</option>
              <option>30</option>
              <option>20</option>
              <option>10</option>
            </select>
            <strong>% de l'Indice</strong></strong></td>
        </tr>
      </table>
  </div>
</div>
<p>&nbsp; </p>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">SALAIRES &amp; INDEMNITES</h3>
  </div>
  <div class="panel-body">

      <table width="100%" border="0">
        <tr>
          <td width="20%">SALAIRE </td>
          <td width="30%">&nbsp;</td>
          <td width="3%">&nbsp;</td>
          <td width="23%">INDEMNITES</td>
          <td width="24%">&nbsp;</td>
        </tr>
        <tr>
          <td>Indice de Base </td>
          <td><strong>
            <input class="form-control" name="indice" type="text" id="indice" value="<?php echo $datam['indice']; ?>" size="20" />
          </strong></td>
          <td>&nbsp;</td>
          <td>Fonction</td>
          <td><strong>
            <input name="fonction" type="text" class="form-control" id="fonction" value="<?php echo $datam['fonction']; ?>" size="20" />
          </strong></td>
        </tr>
        <tr>
          <td>Taux </td>
          <td><strong>
            <input name="taux" type="text" class="form-control" id="taux" value="<?php echo $datam['taux']; ?>" size="20" />
          </strong></td>
          <td>&nbsp;</td>
          <td>Transport</td>
          <td><strong>
            <input name="transport" type="text" class="form-control" id="transport" value="<?php echo $datam['transport']; ?>" size="20" />
          </strong></td>
        </tr>
        <tr>
          <td>Salaire de Base</td>
          <td><strong>
            <input name="sbase" type="text" class="form-control" id="sbase" value="<?php echo $datam['sbase']; ?>" size="20" />
          </strong></td>
          <td>&nbsp;</td>
          <td>Logement</td>
          <td><strong>
            <input name="logement" type="text" class="form-control" id="logement" value="<?php echo $datam['logement']; ?>" size="20" />
          </strong></td>
        </tr>
        <tr>
          <td>Avancement au marité</td>
          <td><strong>
            <input name="avancement" type="text" class="form-control" id="avancement" value="<?php echo $datam['avancement']; ?>" size="20" />
          </strong></td>
          <td>&nbsp;</td>
          <td>Téléphone</td>
          <td><strong>
            <input name="telephone" type="text" class="form-control" id="telephone" value="<?php echo $datam['telephone']; ?>" size="20" />
          </strong></td>
        </tr>
        <tr>
          <td>Prime d'anciennete</td>
          <td><strong>
            <input name="anciennete" type="text" class="form-control" id="anciennete" value="<?php echo $datam['anciennete']; ?>" size="20" />
          </strong></td>
          <td>&nbsp;</td>
          <td>Risque / Autres Indemnite</td>
          <td><strong>
            <input name="risque" type="text" class="form-control" id="risque" value="<?php echo $datam['risque']; ?>" size="20" />
          </strong></td>
        </tr>
        <tr>
          <td>Gratification</td>
          <td><strong>
            <input name="gratification" type="text" class="form-control" id="gratification" value="<?php echo $datam['gratification']; ?>" size="20" />
          </strong></td>
          <td>&nbsp;</td>
          <td>Caisse</td>
          <td><strong>
            <input name="caisse" type="text" class="form-control" id="caisse" value="<?php echo $datam['caisse']; ?>" size="20" />
          </strong></td>
        </tr>
        <tr>
          <td>Rappel</td>
          <td><strong>
            <input name="srappel" type="text" class="form-control" id="srappel" value="<?php echo $datam['srappel']; ?>" size="20" />
          </strong></td>
          <td>&nbsp;</td>
          <td>Prime Nuit ( Astreinte)</td>
          <td><strong>
            <input name="astreinte" type="text" class="form-control" id="astreinte" value="<?php echo $datam['astreinte']; ?>" size="20" />
          </strong></td>
        </tr>
        <tr>
          <td>Heures supplementaire</td>
          <td><strong>
            <input name="heuressup" type="text" class="form-control" id="heuressup" value="<?php echo $datam['heuressup']; ?>" size="20" />
          </strong></td>
          <td>&nbsp;</td>
          <td>Prime de panier</td>
          <td><strong>
            <input name="panier" type="text" class="form-control" id="panier" value="<?php echo $datam['panier']; ?>" size="20" />
          </strong></td>
        </tr>
        <tr>
          <td>Congé payé</td>
          <td><strong>
            <input name="conge" type="text" class="form-control" id="conge" value="<?php echo $datam['conge']; ?>" size="20" />
          </strong></td>
          <td>&nbsp;</td>
          <td>Remboursement de frais</td>
          <td><strong>
            <input name="remboursement" type="text" class="form-control" id="remboursement" value="<?php echo $datam['remboursement']; ?>" size="20" />
          </strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
  </div>
</div>
<div class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">DEDUCTIONS &amp; RETENUES</h3>
  </div>
  <div class="panel-body">
    <table width="100%" border="0">
      <tr>
        <td width="20%">DEDUCTION</td>
        <td width="30%">&nbsp;</td>
        <td width="3%">&nbsp;</td>
        <td width="23%">RETENUES</td>
        <td width="24%">&nbsp;</td>
      </tr>
      <tr>
        <td>Caisse mutuelle</td>
        <td><strong>
          <input name="cotisation" type="text" class="form-control" id="cotisation" value="<?php echo $datam['cotisation']; ?>" size="20" />
        </strong></td>
        <td>&nbsp;</td>
        <td>IGR  <strong>
        <select name="igrchoix" id="igrchoix">
          <option value="<?php echo $datam['igrchoix']; ?>" selected="selected">
           <?php $igrchoix=$datam['igrchoix'];  if ($igrchoix==0){echo 'NON';} else {echo 'OUI';} ?>
            </option>
          <option value="1">OUI</option>
          <option value="0">NON</option>
        </select>
        </strong></td>
        <td><strong>
          <input name="igr" type="text" disabled="disabled" class="form-control" id="igr" value="<?php echo $datam['igr']; ?>" size="20" readonly />
        </strong></td>
      </tr>
      <tr>
        <td>Avance sur Salaire</td>
        <td><strong>
          <input name="avances" type="text" class="form-control" id="avances" value="<?php echo $datam['avances']; ?>" size="20" />
        </strong></td>
        <td>&nbsp;</td>
        <td>Caisse de retraite<strong><font color="#FF0000">&nbsp;
        </font><strong>
        <select name="crchoix" id="crchoix">
          <option value="<?php echo $datam['crchoix']; ?>" selected="selected">
           <?php $crchoix=$datam['crchoix'];   if ($crchoix==0){echo "NON";} else {echo "OUI";} ?>
            </option>
          <option value="1">OUI</option>
          <option value="0">NON</option>
        </select>
        </strong></td>
        <td><strong>
          <input name="retraite" type="text" disabled="disabled" class="form-control" id="retraite" value="<?php echo $datam['retraite']; ?>" size="20" readonly />
        </strong></td>
      </tr>
      <tr>
        <td>Pret</td>
        <td><strong>
          <input name="pret" type="text" class="form-control" id="pret" value="<?php echo $datam['pret']; ?>" size="20" />
        </strong></td>
        <td>&nbsp;</td>
        <td>Caisse de prevoyances</td>
        <td><strong>
          <input name="prevoyance" type="text" class="form-control" id="prevoyance" value="<?php echo $datam['prevoyance']; ?>" size="20" />
        </strong></td>
      </tr>
      <tr>
        <td>Autre deduction</td>
        <td><strong>
          <input name="adeduction" type="text" class="form-control" id="adeduction" value="<?php echo $datam['adeduction']; ?>" size="20" />
        </strong></td>
        <td>&nbsp;</td>
        <td>Autres retenue</td>
        <td><strong>
          <input name="aretenue" type="text" class="form-control" id="aretenue" value="<?php echo $datam['aretenue']; ?>" size="20" />
        </strong></td>
      </tr>
      <tr>
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
        <td>NET A PAYER </td>
        <td><strong>
          <input name="SNET" type="text" disabled class="form-control" id="SNET" value="<?php echo $datam['SNET']; ?>" size="20" readonly />
        </strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong><span style="font-size:8.5pt;font-family:Arial">
          <input type="submit" name="Submit" value="Enregistrer la Paie"  class="btn btn-primary"/>
        <strong><span style="font-size:8.5pt;font-family:Arial"><a href="rh_gestionpaie.php" class="btn btn-danger">FERMER</a></span></strong></span></strong></td>
      </tr>
    </table>
  </div>
</div>


     </form>
     
     </td>
   </tr>
   <?php
}
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