<?php
Require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';
?>
<?php
 if((($_SESSION['u_niveau'] != 50) ) && ($_SESSION['u_niveau'] != 90)) {
	header("location:index.php?error=false");
	exit;
 }
?>
<html>
<head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include 'titre.php' ?></title>
</head>
<?php
Require 'bienvenue.php';    // on appelle la page contenant la fonction
?>
<body>
<table width="98%" border="0">
  <tr>
    <td width="32%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="37%"><div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Nom ,Matricule, Tel , Direction, Service </h3>
      </div>
      <div class="panel-body">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="47%"><table width="100%" border="0.5" cellspacing="0" cellpadding="0">
              <tr>
                <td width="52%"><form name="testform" method="post" action="rh_chercher_employe.php">
                  <label for="mr1"></label>
                  <input name="mr1" type="text" id="mr1" size="30">
                  <input type="submit" name="Cherchez " id="Cherchez " class="btn btn-sm btn-default"value="Chercher un employe">
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
$sql = "SELECT count(*) FROM $tb_rhpersonnel";  
$resultat = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
$nb_total = mysqli_fetch_array($resultat);  
if (($nb_total = $nb_total[0]) == 0) {  
echo 'Aucune reponse trouvee';  
}  
else { 
if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
$nb_affichage_par_page = 50; 
$sql = "SELECT * FROM $tb_rhpersonnel ORDER BY matricule ASC LIMIT ".$nb_affichage_par_page." OFFSET ".$_GET['debut'];  
$req = mysqli_query($linki,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
?>
 </p>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
   <tr bgcolor="#3071AA">
     <td width="8%" align="center"><font color="#FFFFFF" size="4"><strong>Matricule </strong></font></td>
     <td width="25%" align="center"><font color="#FFFFFF" size="3"><strong>Nom et Prenom </strong></font></td>
     <td width="25%" align="center"><font color="#FFFFFF"><strong>Fonction</strong> </font></td>
     <td width="10%" align="center"><font color="#FFFFFF"><strong>Tel</strong> </font></td>
     <td width="17%" align="center"><font color="#FFFFFF"><strong>Direction</strong></font></td>
     <td width="13%" align="center"><font color="#FFFFFF"><strong>Service</strong></font></td>
     <td width="8%" align="center">&nbsp;</td>
  </tr>
   <?php
while($data=mysqli_fetch_array($req)){ // Start looping table row 
?>
   <tr>
     <td align="center" bgcolor="#FFFFFF"><em><?php echo $data['matricule'];?></em></td>
     <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['nomprenom'];?></em></div></td>
     <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $data['titre'];?></em></div></td>
     <td  bgcolor="#FFFFFF"><em><?php echo $data['tel'];?></em></td>
     <td  bgcolor="#FFFFFF"><em><?php echo $data['direction'];?></em></td>
     <td  bgcolor="#FFFFFF"><em><?php echo $data['service'];?></em></td>
     <td align="center" bgcolor="#FFFFFF"><a href="rh_employer_user.php?id=<?php echo md5(microtime()).$data['idrhp']; ?>" class="btn btn-sm btn-success" >Aperçu</a></td>
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