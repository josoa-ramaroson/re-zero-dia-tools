<?php
Require 'session.php';
require 'fonction.php';
$nserie1=addslashes($_POST['nserie']);
$annee1f=addslashes($_POST['annee']);
$CA=addslashes($_POST['CA']);
$CB=addslashes($_POST['CB']);
$ARCH=$annee1f;
?>
<?php
Require 'fonction_niveau_stat_filtre.php';
?>
<html>
<head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
</head>
<?php
Require"bienvenue.php";  // on appelle la page contenant la fonction
?>
<body>
 <p><a href="stat_filtre_kmfsimp.php?an=<?php echo md5(microtime()).$annee1f;?>&ns=<?php echo md5(microtime()).$nserie1;?>&CA=<?php echo md5(microtime()).$CA;?>&CB=<?php echo md5(microtime()).$CB;?>" target="_blank"><img src="images/imprimante.png" width="50" height="30"></a></p>
 <p>&nbsp;</p>
<p>&nbsp;</p>
<p>
  <?php 

//require 'configuration.php';
//if (($ARCH==$annee)|| ($ARCH>$annee))
if (($ARCH==$annee_recouvrement)|| ($ARCH>$annee_recouvrement))
{
$sql11 = "SELECT  COUNT(*) AS nbres, SUM(cons1) AS cons1, SUM(cons2) AS cons2, SUM(cons) AS cons, SUM(mont1) AS mont1,SUM(mont2) AS mont2,SUM(puisct) AS puisct, SUM(totalht) AS totalht, SUM(tax) AS tax, SUM(totalttc) AS totalttc, SUM(ortc) AS ortc, SUM(impayee) AS impayee, SUM(Pre) AS Pre, SUM(totalnet) AS totalnet, refcommune , nserie , fannee , Tarif , st FROM $tv_facturation where fannee='$annee1f'  and nserie='$nserie1' and totalttc > '$CA' and  '$CB' > totalttc GROUP BY refcommune ";
}
else
{
$sql11 = "SELECT  COUNT(*) AS nbres, SUM(f.cons1) AS cons1, SUM(f.cons2) AS cons2, SUM(f.cons) AS cons, SUM(f.mont1) AS mont1,SUM(f.mont2) AS mont2,SUM(f.puisct) AS puisct, SUM(f.totalht) AS totalht, SUM(f.tax) AS tax, SUM(f.totalttc) AS totalttc, SUM(f.ortc) AS ortc, SUM(f.impayee) AS impayee, SUM(f.Pre) AS Pre, SUM(f.totalnet) AS totalnet, c.refcommune , f.nserie , f.fannee , c.Tarif , f.st FROM z_"."$ARCH"."_$tbl_fact f , $tbl_contact c  where  c.id=f.id and f.fannee='$annee1f'  and f.nserie='$nserie1' and f.totalttc  > '$CA' and  '$CB' > f.totalttc  GROUP BY c.refcommune "; 
}
$req11=mysqli_query($linki,$sql11);
?>
</p>
<H2>
  <p align="center" >Facturation ( <?php echo $nserie1.'/'.$annee1f; ?>) supérieur à <?php echo $CA; ?> KMF et inférieur à <?php echo $CB; ?> KMF </p>
</H2>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
  <tr bgcolor="#3071AA">
    <td width="10%" align="center"><strong><font color="#FFFFFF" size="4">SECTEUR</font></strong></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>Nbre client</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>CONS </strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>CONS 1</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>CONS 2</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>MT 1</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>MT 2</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>Puis Sct</strong></font></td>
    <td width="10%" align="center"><font color="#FFFFFF"><strong>Montant THT</strong></font></td>
    <td width="9%" align="center"><strong><font color="#FFFFFF">TCA</font></strong></td>
    <td width="15%" align="center"><font color="#FFFFFF"><strong>Montant TTC</strong></font></td>
  </tr>
  <?php
while($data11=mysqli_fetch_array($req11)){ // Start looping table row 
?>
  <tr>
    <td  bgcolor="#FFFFFF"><em>
      <?php $RefCommune=$data11['refcommune'];
	 
	 $sql3 = "SELECT * FROM commune where ref_com=$RefCommune";
$result3 = mysqli_query($linki,$sql3);
while ($row3 = mysqli_fetch_assoc($result3)) {
echo $secteur=$row3['commune'];
}
	 
	 ?>
    </em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['nbres'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['cons'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['cons1'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['cons2'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['mont1'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['mont2'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['puisct'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['totalht'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['tax'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data11['totalttc'];?></em></td>
  </tr>
  <?php
}  

?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>
  <?php
//if (($ARCH==$annee)|| ($ARCH>$annee))
if (($ARCH==$annee_recouvrement)|| ($ARCH>$annee_recouvrement))
{
$sql22 = "SELECT  COUNT(*) AS nbres, SUM(cons1) AS cons1, SUM(cons2) AS cons2, SUM(cons) AS cons, SUM(mont1) AS mont1,SUM(mont2) AS mont2,SUM(puisct) AS puisct, SUM(totalht) AS totalht, SUM(tax) AS tax, SUM(totalttc) AS totalttc, SUM(ortc) AS ortc, SUM(impayee) AS impayee, SUM(Pre) AS Pre, SUM(totalnet) AS totalnet, RefLocalite , nserie , fannee , Tarif , st FROM $tv_facturation where  fannee='$annee1f'  and nserie='$nserie1' and totalttc > '$CA' and  '$CB' > totalttc GROUP BY RefLocalite ";  
}
else 
{
$sql22 = "SELECT  COUNT(*) AS nbres, SUM(f.cons1) AS cons1, SUM(f.cons2) AS cons2, SUM(f.cons) AS cons, SUM(f.mont1) AS mont1,SUM(f.mont2) AS mont2,SUM(f.puisct) AS puisct, SUM(f.totalht) AS totalht, SUM(f.tax) AS tax, SUM(f.totalttc) AS totalttc, SUM(f.ortc) AS ortc, SUM(f.impayee) AS impayee, SUM(f.Pre) AS Pre, SUM(f.totalnet) AS totalnet, c.RefLocalite , f.nserie , f.fannee , c.Tarif , f.st FROM z_"."$ARCH"."_$tbl_fact f , $tbl_contact c  where  c.id=f.id and fannee='$annee1f'  and f.nserie='$nserie1' and f.totalttc > '$CA' and  '$CB' > f.totalttc GROUP BY c.RefLocalite ";
}
$req22=mysqli_query($linki,$sql22);
?>
</p>
<H2>
  <p align="center" >Facturation ( <?php echo $nserie1.'/'.$annee1f; ?>) supérieur à <?php echo $CA; ?>KMF et inférieur à <?php echo $CB; ?> KMF </p>
</H2>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
  <tr bgcolor="#3071AA">
    <td width="10%" align="center"><strong><font color="#FFFFFF" size="4">VILLE</font></strong></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>Nbre client</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>CONS </strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>CONS 1</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>CONS 2</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>MT 1</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>MT 2</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>Puis Sct</strong></font></td>
    <td width="10%" align="center"><font color="#FFFFFF"><strong>Montant THT</strong></font></td>
    <td width="9%" align="center"><strong><font color="#FFFFFF">TCA</font></strong></td>
    <td width="15%" align="center"><font color="#FFFFFF"><strong>Montant TTC</strong></font></td>
  </tr>
  <?php
while($data22=mysqli_fetch_array($req22)){ // Start looping table row 
?>
  <tr>
    <td  bgcolor="#FFFFFF"><em>
      <?php $RefLocalite=$data22['RefLocalite'];
	 
	 $sql322 = "SELECT * FROM ville where refville=$RefLocalite";
$result322 = mysqli_query($linki,$sql322);
while ($row322 = mysqli_fetch_assoc($result322)) {
echo $ville=$row322['ville'];
}
	 
	 ?>
    </em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['nbres'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['cons'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['cons1'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['cons2'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['mont1'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['mont2'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['puisct'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['totalht'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['tax'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data22['totalttc'];?></em></td>
  </tr>
  <?php
}  
?>
</table>
<p>
  <?php

//if (($ARCH==$annee)|| ($ARCH>$annee))
if (($ARCH==$annee_recouvrement)|| ($ARCH>$annee_recouvrement))

{
$sql33 = "SELECT COUNT(*) AS nbres, SUM(cons1) AS cons1, SUM(cons2) AS cons2, SUM(cons) AS cons, SUM(mont1) AS mont1,SUM(mont2) AS mont2,SUM(puisct) AS puisct, SUM(totalht) AS totalht, SUM(tax) AS tax, SUM(totalttc) AS totalttc, SUM(ortc) AS ortc, SUM(impayee) AS impayee, SUM(Pre) AS Pre, SUM(totalnet) AS totalnet, RefLocalite , nserie , fannee , Tarif, st FROM $tv_facturation where  fannee='$annee1f'  and nserie='$nserie1' and totalttc > '$CA' and  '$CB' > totalttc ";   

$sql4 = "SELECT COUNT(*) AS nbtotal FROM $tv_facturation where  fannee='$annee1f'  and nserie='$nserie1'";   
}
else
{
$sql33 = "SELECT  COUNT(*) AS nbres, SUM(f.cons1) AS cons1, SUM(f.cons2) AS cons2, SUM(f.cons) AS cons, SUM(f.mont1) AS mont1,SUM(f.mont2) AS mont2,SUM(f.puisct) AS puisct, SUM(f.totalht) AS totalht, SUM(f.tax) AS tax, SUM(f.totalttc) AS totalttc, SUM(f.ortc) AS ortc, SUM(f.impayee) AS impayee, SUM(f.Pre) AS Pre, SUM(f.totalnet) AS totalnet, c.RefLocalite , f.nserie , f.fannee , c.Tarif , f.st FROM z_"."$ARCH"."_$tbl_fact f , $tbl_contact c  where  c.id=f.id and f.fannee='$annee1f'  and f.nserie='$nserie1' and f.totalttc > '$CA' and  '$CB' > f.totalttc ";   

$sql4 = "SELECT COUNT(*) AS nbtotal FROM z_"."$ARCH"."_$tbl_fact f , $tbl_contact c  where  c.id=f.id and f.fannee='$annee1f'  and f.nserie='$nserie1'";
}
$req33=mysqli_query($linki,$sql33);
$req4=mysqli_query($linki,$sql4);
while($data4=mysqli_fetch_array($req4)){$nbt=$data4['nbtotal'];}

?>
</p>
<H2>
  <p align="center" >Facturation ( <?php echo $nserie1.'/'.$annee1f; ?>) supérieur à <?php echo $CA; ?> KMF et inférieur à <?php echo $CB; ?> KMF </p>
</H2>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
  <tr bgcolor="#3071AA">
    <td width="10%" align="center">&nbsp;</td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>Nbre client</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>CONS </strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>CONS 1</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>CONS 2</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>MT 1</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>MT 2</strong></font></td>
    <td width="9%" align="center"><font color="#FFFFFF" size="3"><strong>Puis Sct</strong></font></td>
    <td width="10%" align="center"><font color="#FFFFFF"><strong>Montant THT</strong></font></td>
    <td width="9%" align="center"><strong><font color="#FFFFFF">TCA</font></strong></td>
    <td width="20%" align="center"><font color="#FFFFFF"><strong>Montant TTC</strong></font></td>
  </tr>
  <?php
while($data33=mysqli_fetch_array($req33)){ // Start looping table row 
$nb= $data33['nbres'];
?>
  <tr>
    <td  bgcolor="#FFFFFF"><a href="stat_filtre_kmf_liste.php?an=<?php echo md5(microtime()).$annee1f;?>&ns=<?php echo md5(microtime()).$nserie1;?>&CA=<?php echo md5(microtime()).$CA;?>&CB=<?php echo md5(microtime()).$CB;?>"  class="btn btn-sm btn-success" target="_blank"> LA LISTE</a></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['nbres'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['cons'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['cons1'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['cons2'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['mont1'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['mont2'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['puisct'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['totalht'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['tax'];?></em></td>
    <td align="center" bgcolor="#FFFFFF"><em><?php echo $data33['totalttc'];?></em></td>
  </tr>
  <?php
}  

?>
</table>
<p>&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td width="38%">&nbsp;</td>
    <td width="27%">NOMBRE </td>
    <td width="35%">&nbsp;</td>
  </tr>
  <tr>
    <td> Client Total </td>
    <td><em><?php echo $nbt;?></em></td>
    <td> 100 %</td>
  </tr>
  <tr>
    <td>Client  ( supérieur à <?php echo $CA; ?> KMF et inférieur à <?php echo $CB; ?> KMF)</td>
    <td><em><?php echo $nb;?></em></td>
    <td><?php  if ($nbt==0) { echo '0'; } else { echo round( ($nb*100)/$nbt, 2);} ?> 
    %</td>
  </tr>
  <tr>
    <td>Client Restant</td>
    <td><em><?php $nr=$nbt-$nb; echo $nr;?></em></td>
    <td><?php if ($nbt==0) { echo '0'; } else {  echo round( ($nr*100)/$nbt, 2); }?> 
    %</td>
  </tr>
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
mysqli_close($linki); 
include_once('pied.php');
?></td>
  </tr>
</table>
<p></p>
</body>
</html>