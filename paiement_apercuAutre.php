<?php
Require 'session.php';
require 'fonction.php';
?>
<?php
require_once('calendar/classes/tc_calendar.php');
?>
<?php
Require 'bienvenue.php';    // on appelle la page contenant la fonction
?>
<?php
$idf=$_POST['idf'];
//$sqlfacturation="SELECT * FROM $tbl_fact f, $tbl_contact c, $tbl_clientgaz g  WHERE (c.id=f.id or g.id=f.id) and f.idf='$idf' and (f.st='F' or f.st='A')  ORDER BY idf desc";

// $sqlfacturation="SELECT * FROM $tbl_fact f, $tbl_contact c WHERE (c.id=f.id) and f.idf=$idf' and (f.st='F' or f.st='A')  ORDER BY idf desc";
$sqlfacturation="SELECT * FROM $tbl_fact f, $tbl_contact c WHERE (c.id=f.id) and f.idf=$idf  ORDER BY idf desc";
$resultatfact=mysqli_query($linki,$sqlfacturation);
$ident=mysqli_fetch_array($resultatfact);

	$sqldate="SELECT * FROM $tbl_caisse "; //DESC  ASC
	$resultldate=mysqli_query($linki,$sqldate);
	$datecaisse=mysqli_fetch_array($resultldate);

if ($ident) {
$idf=$ident['idf'];
}
else {
	header("location:paiement.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" src="js/validator.js" type="text/javascript" xml:space="preserve"></script>
<script language="javascript" src="calendar/calendar.js"></script>
<title>Document sans titre</title>
</head>

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
          <td><?php
					 /* $myCalendar = new tc_calendar("date", true, false);
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
          <td>Total facturée </td>
          <td><em><?php echo $ident['totalttc'];?></em></td>
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
          <td height="26">&nbsp;</td>
          <td>&nbsp;</td>
          <td>Modalité de paiement</td>
          <td><select name="modalité" id="modalité">
            <option>Espece</option>
            <option>Chèque</option>
            <option>Virement</option>
          </select>
N°/Ref
<input name="reference" type="text" id="reference" size="30" /></td>
        </tr>
        <tr>
          <td height="26">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="26">&nbsp;</td>
          <td>&nbsp;</td>
          <td><em><font size="2"><strong><font size="2"><strong><font size="2"><strong><font size="2"><strong><font color="#FF0000">
            <input name="idf" type="hidden" id="idf" value="<?php echo $idf; ?>" />
          </font><font size="2"><strong><font size="2"><strong><font color="#FF0000">
          <input name="id_nom" type="hidden" id="id_nom" value="<?php echo $id_nom; ?>" />
          <input name="Nomclient" type="hidden" id="Nomclient" value="<?php echo $ident['nomprenom']; ?>" />
          <input name="nserie" type="hidden" id="nserie" value="<?php echo $ident['nserie']; ?>" />
          <input name="bstatut" type="hidden" id="bstatut" value="<?php echo $ident['bstatut']; ?>" />
          <input name="statut" type="hidden" id="statut" value="<?php echo $ident['statut']; ?>" />
          </font></strong></font></strong></font></strong></font></strong></font></strong></font></strong></font></em></td>
          <td><?php if ($ident['report']!=0 ) {?>            <input type="submit" name="Paiement" id="Paiement" value="Paiement" />
          <?php } else { echo 'le Client a tout payé ';} ?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
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
<script language="JavaScript" type="text/javascript" xml:space="preserve"> 
    var frmvalidator  = new Validator("form1");
	frmvalidator.EnableOnPageErrorDisplaySingleBox();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("paiement","req","SVP entre un nombre");
	
</script>