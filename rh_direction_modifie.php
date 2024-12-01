<?php
Require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
?>
<?php
 if(($_SESSION['u_niveau'] != 50)) {
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
?>
<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
<div class="panel panel-primary">
<div class="panel-heading">
  <h3 class="panel-title"><em>
    <label><strong>Modification du nom de la direction</strong></label></em></h3>
</div>
 <div class="panel-body">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="47%"><font color="#CC9933" size="5">
      <?php
$id=$_GET['id'];

$sql3="SELECT * FROM $tb_rhdirection WHERE idrh='$id'";
$result3=mysqli_query($linki,$sql3);

$rows3=mysqli_fetch_array($result3);
?>
    </font>
      <form name="form3" method="post" action="rh_direction_updates.php">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="37%">&nbsp;</td>
            <td width="63%">&nbsp;</td>
          </tr>
          <tr>
            <td><em>
              <input name="idrh" type="hidden" id="idrh" value="<?php echo $rows3['idrh'];?>">
            </em></td>
            <td><em>
              <input class="form-control" name="direction" type="text" id="direction" value="<?php echo $rows3['direction']; ?>" size="40" bgcolor="#FFFF00">
            </em></td>
          </tr>
          <tr>
            <td><font size="2"><strong><font size="2"><strong><font color="#FF0000">
              <input name="id_nom" type="hidden" id="id_nom" value="<?php echo $id_nom; ?>">
            </font></strong></font></strong></font></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit3" value="Valider votre modification"></td>
          </tr>
        </table>
      </form>
    <font color="#CC9933" size="5">&nbsp;</font></td>
    <td width="53%">&nbsp;</td>
  </tr>
</table>
</div></div>
<p><font size="2"><font size="2"><font size="2">
<?php
require 'fonction.php';

 
$sql = "SELECT count(*) FROM $tb_rhdirection ";  


$resultat = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
 
 
$nb_total = mysqli_fetch_array($resultat);  
 
if (($nb_total = $nb_total[0]) == 0) {  
echo 'Aucune reponse trouvee';  
}  
else { 
 
if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
    

   $nb_affichage_par_page = 20; 
   

$sql = "SELECT * FROM $tb_rhdirection  ORDER BY idrh DESC LIMIT ".$nb_affichage_par_page." OFFSET ".$_GET['debut'];  //ASC
 

$req = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
?>
</font></strong></font></font></font></font></font></font></font></font></font></strong></font></font></font></font></font></font></font></font></font></font></p>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#000000">
    <td width="15%" align="center" bgcolor="#0033FF"><font color="#CCCCCC" size="4"><strong>N&deg; Enregistrement</strong></font></td>
    <td width="35%" align="center" bgcolor="#0033FF"><font color="#CCCCCC">Direction</font></td>
    <td width="19%" align="center" bgcolor="#0033FF">&nbsp;</td>
  </tr>
  <?php
while($data=mysqli_fetch_array($req)){ // Start looping table row 
?>
  <tr>
    <td align="center" bgcolor="#FFFFFF"><div align="left"><?php echo $data['idrh'];?></div>
      <div align="left"></div></td>
    <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['direction'];?></em></div></td>
    <td align="center" bgcolor="#FFFFFF"><p><a href="rh_direction_modifie.php?id=<?php echo $data['idrh']; ?>" class="btn btn-xs btn-success"><?php echo 'Modifier' ?></a></p></td>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
  </tr>
  <tr>
    <td height="21">
    <?php
 function direction_eda($iddr,$tb_rhdirection){
	global $linki;
	$sql = "SELECT * FROM $tb_rhdirection where  idrh=$iddr ";

	$resultat = mysqli_query($linki,$sql) or exit(mysqli_error($linki)); 
	$nqt = mysqli_fetch_assoc($resultat);

	if((!isset($nqt['direction'])|| empty($nqt['direction']))) { $qt=''; return $qt;}
	else {$qt=$nqt['direction']; return $qt;}

	}	
	?>
	<?php
include_once('pied.php');
?></td>
  </tr>
</table>
<p>&nbsp; </p>
</body>
</html>
<script language="JavaScript" type="text/javascript" xml:space="preserve">//<![CDATA[
  var frmvalidator  = new Validator("form3");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("direction","req","SVP enregistre le libelle");
//]]></script>