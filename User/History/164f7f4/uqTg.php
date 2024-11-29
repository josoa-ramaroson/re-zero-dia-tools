<?php
require 'session.php';
require 'fonction.php';
?>
<?php
require_once('calendar/classes/tc_calendar.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        min-height: 100vh;
    }
    
    .panel {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }
    
    .panel-heading {
        margin-bottom: 1rem;
    }
    
    .panel-title {
        font-size: 14px;
        color: #198754;
        margin: 0;
    }
    
    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 0.6rem 0.8rem;
        font-size: 14px;
        height: auto;
    }

    select, input {
        font-size: 14px !important;
        padding: 0.6rem 0.8rem !important;
        border-radius: 8px !important;
        border: 1px solid #dee2e6 !important;
    }

    em {
        font-style: normal;
        color: #198754;
        font-weight: 500;
        font-size: 14px;
    }

    table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        border-collapse: collapse;
    }
    
    table thead th {
        background-color: #198754 !important;
        color: white !important;
        border: none !important;
        padding: 0.8rem !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        text-align: left !important;
    }
    
    table tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.05);
    }
    
    table td {
        padding: 0.8rem !important;
        font-size: 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        text-align: left !important;
    }

    /* Ajustement des colonnes du tableau */
    table th:first-child,
    table td:first-child {
        padding-left: 1.5rem !important;
    }

    table th:last-child,
    table td:last-child {
        padding-right: 1.5rem !important;
    }

    input[type="submit"], .btn {
        font-size: 14px !important;
        padding: 0.6rem 1.2rem !important;
        border-radius: 8px !important;
        transition: all 0.3s ease;
        background-color: #198754;
        color: white;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover, .btn:hover {
        background-color: #146c43;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    /* Style amélioré pour ORTC */
    .ortc-status {
        padding: 0.8rem;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .ortc-status.success {
        background-color: rgba(25, 135, 84, 0.1);
        border: 1px solid #198754;
    }

    .ortc-status.success select {
        background-color: white;
        color: #198754;
    }

    .ortc-status.danger {
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid #dc3545;
    }

    .ortc-status.danger select {
        background-color: white;
        color: #dc3545;
    }

    /* Ajustements des marges dans le formulaire */
    .form-group {
        margin-bottom: 0.8rem;
    }

    label {
        margin-bottom: 0.3rem;
        font-weight: 500;
        color: #444;
        font-size: 14px;
    }

    .row > div {
        margin-bottom: 0.8rem;
    }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" src="js/validator.js" type="text/javascript" xml:space="preserve"></script>
<script language="javascript" src="calendar/calendar.js"></script>
<title>Document sans titre</title>
</head>
<?php
Require 'bienvenue.php';    // on appelle la page contenant la fonction
?>
<?php
/*$Police=$_POST['id'];
$sql82 ="SELECT * FROM $tbl_contact where Police='$Police'";
$result82 = mysqli_query($linki,$sql82);
while ($row82 = mysqli_fetch_assoc($result82)) {
$id=$row82['id'];
}*/

$id=$_REQUEST['id'];
$sqlfacturation="SELECT * FROM $tbl_fact f, $tbl_contact c  WHERE c.id=f.id and f.id='$id' and (f.st='E' or f.st='P' or f.st='D')  ORDER BY idf desc limit 0,1";

$resultatfact=mysqli_query($linki, $sqlfacturation);
$ident=mysqli_fetch_array($resultatfact);

$sqfac="SELECT * FROM $tbl_paiement WHERE id='$id' and (st='E' or st='P' or st='D') ORDER BY idp DESC "; //DESC ASC
$resultfac = mysqli_query($linki, $sqfac);

$sqfaca = "SELECT * FROM $tbl_paiement WHERE id='$id' and (st='F') ORDER BY idp DESC "; //DESC ASC
$resultfaca = mysqli_query($linki, $sqfaca);

$sqldate="SELECT * FROM $tbl_caisse "; //DESC ASC
$resultldate = mysqli_query($linki, $sqldate);
$datecaisse=mysqli_fetch_array($resultldate);

if ($ident) {
$idf=$ident['idf'];
}
else {
	header("location:paiement.php");
	}
	
	
	    //choix d espace de memoire pour les connection.---------------------------------------------------------------- 
	$valeur_existant = "SELECT COUNT(*) AS nb FROM $tbl_paiconn  WHERE idrecu='$id_nom' ";
	$sqLvaleur = mysqli_query($linki,$valeur_existant)or exit(mysqli_error($linki)); 
	$nb = mysqli_fetch_assoc($sqLvaleur);
	
	if($nb['nb'] == 1)
   {

   }
   else 
   {
	   	
	$sqlcon="INSERT INTO $tbl_paiconn (idrecu)VALUES('$id_nom')";
    $connection=mysqli_query($linki,$sqlcon);
    }
    //------------------------FIn du Programme ---------------------------------------------------------
	
	$nserie=$ident['nserie'];
	$fanneefacture=$ident['fannee'];
	 //choix paiement ORTC.---------------------------------------------------------------- 
	$valeur_existant_ortc = "SELECT COUNT(*) AS nb FROM $tbl_paiement WHERE id='$id' and st='E' and nserie='$nserie'  and fanneefacture='$fanneefacture' and ortc_dp='250' ";
	$sqLvaleur_ortc = mysqli_query($linki,$valeur_existant_ortc)or exit(mysqli_error($linki)); 
	$nb_ortc = mysqli_fetch_assoc($sqLvaleur_ortc);
	
	if ($nserie==12) {$facmois='Dec'; }
	if ($nserie==11) {$facmois='Nov'; }
	if ($nserie==10) {$facmois='Oct'; }
	if ($nserie==9) {$facmois='Sep'; }
	if ($nserie==8) {$facmois='Aou'; }
	if ($nserie==7) {$facmois='Jul'; }
	if ($nserie==6) {$facmois='Jui'; }
	if ($nserie==5) {$facmois='Mai'; }
	if ($nserie==4) {$facmois='Avr'; }
	if ($nserie==3) {$facmois='Mar'; }
	if ($nserie==2) {$facmois='Fev'; }
	if ($nserie==1) {$facmois='Jan'; }
	if ($nserie==0) {$facmois=''; }
	
	if(($nb_ortc['nb']> 1) or ($nb_ortc['nb']==1))
   {
$couleur='#D0FFF0'; $couleurV='0'; $couleurL="Il a payé pour fact $facmois $fanneefacture ";

   }
   else 
   {
$couleur='#FF0000'; $couleurV='1'; $couleurL="Il n a pas payé pour fact $facmois $fanneefacture";
    }
    //------------------------FIn du Programme ---------------------------------------------------------
	
	
?>
<body>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Etape 2 PAIEMENT : Enregistre des paiements</h3>
  </div>
  <div class="panel-body">
    <form action="paiement_save.php" method="post" name="form1" id="form1">
      <table width="100%" border="0">
        <tr>
          <td width="14%">ID_client</td>
          <td width="30%"><em><?php echo $ident['id'];?></em></td>
          <td width="21%">Date de paiement </td>
          <td width="35%"><input name="date" type="text" id="date" value="<?php echo $datecaisse['datecaisse'];?>" size="30" readonly="readonly" /></td>
        </tr>
        <tr>
          <td>Nom client</td>
          <td><em><?php echo $ident['nomprenom'];?></em></td>
          <td>&nbsp;</td>
          <td><?php /*
					  $myCalendar = new tc_calendar("date", true, false);
					  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
					  $myCalendar->setPath("calendar/");
					  $myCalendar->setYearInterval($annee1, $annee2);
					  $myCalendar->dateAllow($date1,$date2);
					  $myCalendar->setDateFormat('j F Y');
					  $myCalendar->setAlignment('left', 'bottom');
					  $myCalendar->writeScript();*/
					  ?></td>
        </tr>
        <tr>
          <td>N° Facture </td>
          <td><em><?php echo $ident['nfacture'];?></em></td>
          <td>Montant reste à payer</td>
          <td><em><?php echo $ident['report'];?></em></td>
        </tr>
        <tr>
          <td>Date Facturuation</td>
          <td><em><?php echo $ident['date'];?></em></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Montant</td>
          <td><em><?php echo $ident['totalht'];?></em></td>
          <td>Montant</td>
          <td><input name="paiement" type="text" id="paiement" size="30" /></td>
        </tr>
         <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Taxes</td>
          <td><em><?php echo $ident['tax'];?></em></td>
          <td bgcolor="#C04040" style="color:white"> <?php if  ($ident['st']=='E') {?> ORTC <?php }?></td>
          <td>
          
          <?php if  ($ident['st']=='E') {?>
          
          <label for="">
            <select name="ortc_d" id="ortc_d">
              <option value="<?php echo $couleurV;?>" selected="selected"><?php echo $couleurL;?></option>
              <option value="0">Ne pas facturé   </option>
              <option value="1">Facturé pour 1 mois </option>
              <option value="2">Facturé pour 2 mois </option>
              <option value="3">Facturé pour 3 mois </option>
              <option value="4">Facturé pour 4 mois </option>
              <option value="5">Facturé pour 5 mois </option>
              <option value="6">Facturé pour 6 mois </option>
            </select>
        </label>
        <?php }?>
        </td>
        </tr>
                 <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="26">ORTC</td>
          <td><em><?php echo $ident['ortc'];?></em></td>
          <td>Modalité de paiement</td>
          <td><select name="modalité" id="modalité">
            <option>Espece</option>
            <option>Chèque</option>
            <option>Virement</option>
            <option>Mobile</option>
          </select>
N°/Ref
<input name="reference" type="text" id="reference" size="30" /></td>
        </tr>
        <tr>
          <td height="26">Impayée</td>
          <td><em><?php echo $ident['impayee'];?></em></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="26">Penalité de retard</td>
          <td><em><?php echo $ident['Pre'];?></em></td>
          <td><em><font size="2"><strong><font size="2"><strong><font size="2"><strong><font size="2"><strong><font color="#FF0000">
            <input name="idf" type="hidden" id="idf" value="<?php echo $idf; ?>" />
          </font><font size="2"><strong><font size="2"><strong><font color="#FF0000">
          <input name="id_nom" type="hidden" id="id_nom" value="<?php echo $id_nom; ?>" />
          <input name="Nomclient" type="hidden" id="Nomclient" value="<?php echo $ident['nomprenom']; ?>" />
          <input name="nserie" type="hidden" id="nserie" value="<?php echo $ident['nserie']; ?>" />
          <input name="bstatut" type="hidden" id="bstatut" value="<?php echo $ident['bstatut']; ?>" />
          <input name="statut" type="hidden" id="statut" value="<?php echo $ident['statut']; ?>" />
          <input name="clique" type="hidden" id="clique" value="0" />
          </font></strong></font></strong></font></strong></font></strong></font></strong></font></strong></font></em></td>
          <td><?php if ($ident['report']>0) {?>  <input type="submit" name="Paiement" id="Paiement" value="Paiement"/>
          <?php } else { echo 'le Client a tout payé ';} ?></td>
        </tr>
        <tr>
          <td height="26">Total facturé</td>
          <td><em><?php echo $ident['totalnet'];?></em></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form>
  </div>
</div>
<p>&nbsp;</p>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#0794F0">
    <td width="100%" bgcolor="#3071AA"><div align="center"><strong><font color="#FFFFFF">Historique des paiements</font></strong></div></td>
  </tr>
</table>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#0794F0">
    <td width="8%" align="center" bgcolor="#FFFFFF"><font color="#000000">ID Paiement</font></td>
    <td width="8%" align="center" bgcolor="#FFFFFF"><font color="#000000" size="3"><strong>Date</strong></font></td>
    <td width="19%" align="center" bgcolor="#FFFFFF"><font color="#000000" size="3"><strong>Nom/ Raison sociale</strong></font></td>
    <td width="13%" align="center" bgcolor="#FFFFFF"><font color="#000000" size="3"><strong>N Facture</strong></font></td>
    <td width="8%" align="center" bgcolor="#FFFFFF"><font color="#000000"><strong>N Reçu </strong></font></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><font color="#000000"><strong>Montant</strong></font></td>
    <td width="9%" align="center" bgcolor="#FFFFFF"><font color="#000000"><strong>Payé</strong></font></td>
    <td width="9%" align="center" bgcolor="#FFFFFF">Reste à payer</td>
    <td width="5%" align="center" bgcolor="#FFFFFF"><font color="#000000"><strong>Mois </strong></font></td>
    <td width="5%" align="center" bgcolor="#FFFFFF"><font color="#000000"><strong>Ortc</strong></font></td>
    <td width="9%" align="center" bgcolor="#FFFFFF"><font color="#000000"><strong>Tax</strong></font></td>
  </tr>
  <?php
while($rowsfac=mysqli_fetch_array($resultfac)){ 
?>
  <tr>
    <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $rowsfac['idp'];?></em></div></td>
    <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $rowsfac['date'];?></em></div></td>
    <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $rowsfac['Nomclient'];?></em></div></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfac['nfacture'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfac['nrecu'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfac['montant'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfac['paiement'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfac['report'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfac['nserie'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfac['ortc_dp'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfac['tax_dp'];?></em></td>
  </tr>
  <?php
}
?>
</table>
<p>&nbsp;</p>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#0794F0">
    <td width="8%" align="center" bgcolor="#FFFFFF"><font color="#000000">ID Paiement</font></td>
    <td width="8%" align="center" bgcolor="#FFFFFF"><font color="#000000" size="3"><strong>Date</strong></font></td>
    <td width="19%" align="center" bgcolor="#FFFFFF"><font color="#000000" size="3"><strong>Nom/ Raison sociale</strong></font></td>
    <td width="13%" align="center" bgcolor="#FFFFFF"><font color="#000000" size="3"><strong>N Facture</strong></font></td>
    <td width="13%" align="center" bgcolor="#FFFFFF"><font color="#000000"><strong>N Reçu </strong></font></td>
    <td width="12%" align="center" bgcolor="#FFFFFF"><font color="#000000"><strong>Montant</strong></font></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><font color="#000000"><strong>Payé</strong></font></td>
    <td width="17%" align="center" bgcolor="#FFFFFF">Reste à payer</td>
  </tr>
  <?php
while($rowsfaca=mysqli_fetch_array($resultfaca)){ 
?>
  <tr>
    <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $rowsfaca['idp'];?></em></div></td>
    <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $rowsfaca['date'];?></em></div></td>
    <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $rowsfaca['Nomclient'];?></em></div></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfaca['nfacture'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfaca['nrecu'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfaca['montant'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfaca['paiement'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $rowsfaca['report'];?></em></td>
  </tr>
  <?php
}
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script language="JavaScript" type="text/javascript" xml:space="preserve"> 
    var frmvalidator  = new Validator("form1");
	frmvalidator.EnableOnPageErrorDisplaySingleBox();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("paiement","req","SVP entre un nombre");
	
</script>