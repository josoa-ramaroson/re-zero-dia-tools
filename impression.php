<?php
require 'session.php';
require_once('calendar/classes/tc_calendar.php');
require 'fc-affichage.php';
require 'fonction.php';
require 'configuration.php';
?>
<?php
if(($_SESSION['u_niveau'] != 2)) {
    header("location:index.php?error=false");
    exit;
}
?>
<html>
<head>
<title><?php include("titre.php"); ?></title>
<meta name="viewport" content="width=device-width, minimum-scale=0.25"/>
<script language="JavaScript" src="js/validator.js" type="text/javascript" xml:space="preserve"></script>
<script type="text/javascript">
function AjaxFunction()
{
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
     httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e)
    {
    try
      {
      httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     }
    catch (e)
      {
      alert("Your browser does not support AJAX!");
      return false;
      }
    }
  }
function stateck() 
    {
    if(httpxml.readyState==4)
      {
        var myarray = JSON.parse(httpxml.responseText);
        
        for(j=document.testform.quartier.options.length-1;j>=0;j--)
        {
        document.testform.quartier.remove(j);
        }
        
        for (i=0;i<myarray.data.length;i++)
        {
        var optn = document.createElement("OPTION");
        optn.text = myarray.data[i].quartier;
        optn.value = myarray.data[i].id_quartier;
        document.testform.quartier.options.add(optn);
        } 
      }
    }
    var url="fonction_dvq.php";
    var refville=document.getElementById('s1').value;
    url=url+"?refville="+refville;
    url=url+"&sid="+Math.random();
    httpxml.onreadystatechange=stateck;
    httpxml.open("GET",url,true);
    httpxml.send(null);
  }
</script>

<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.centrevaleur {
    text-align: center;
}
.centrevaleur td {
    text-align: center;
}
.taille16 {
    font-size: 16px;
}
</style>
<script language="javascript" src="calendar/calendar.js"></script>
</head>
<?php
Require("bienvenue.php");
?>
<?php
$sql = "SELECT count(*) FROM $tbl_fact WHERE fannee='$anneec' and nserie='$nserie' and st='E'";  
$resultat = mysqli_query($linki, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
$nb_total = mysqli_fetch_array($resultat);

if (($nb_total = $nb_total[0]) == 0) {  
    echo 'Aucune reponse trouvee';  
}  
else { 
    if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
    
    $nb_affichage_par_page = 50; 
    
    $sql = "SELECT f.bstatut, c.quartier, c.ville, f.impression, COUNT(*) AS nbch 
            FROM $tbl_contact c, $tbl_fact f 
            WHERE c.id=f.id AND fannee='$anneec' AND f.nserie='$nserie' AND st='E' AND c.statut='6' 
            GROUP BY c.quartier 
            LIMIT ".$_GET['debut'].','.$nb_affichage_par_page;

    $req = mysqli_query($linki, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));
?>
<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0">
  <tr>
    <td width="60%"><div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Impression par Ville et Quartier</h3>
      </div>
      <div class="panel-body">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="47%"><table width="100%" border="0.5" cellspacing="0" cellpadding="0">
              <tr>
                <td width="52%"><form action="impression_fact.php" method="post" name="testform" id="testform">
                  <strong>Ville</strong> :
                  <?php
                    $sql="SELECT * FROM ville"; 
                    $result = mysqli_query($linki, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));
                    echo "<select name=refville id='s1' onchange=AjaxFunction();>
                          <option value=''>Choisissez une ville</option>";
                    while($row = mysqli_fetch_array($result)) {
                        echo "<option value=".$row['refville'].">".$row['ville']."</option>";
                    }
                    echo "</select>";
                  ?>
                  <strong>Quartier</strong> : 
                  <select name=quartier id='s2'>
                  </select>
                  <input type="submit" name="Submit4" class="btn btn-sm btn-default"  value="Imprimer" />
                </form></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </div>
    </div></td>
    <td width="2%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="36%"><div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Id_Client, Ville, Quartier, Nom, Tel, Adresse, Plc</h3>
      </div>
      <div class="panel-body">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="47%"><table width="100%" border="0.5" cellspacing="0" cellpadding="0">
              <tr>
                <td width="52%"><form name="form1" method="post" action="imp_chercher.php">
                  <label for="mr1"></label>
                  <input name="mr1" type="text" id="mr1" size="30">
                  <input type="submit" name="Cherchez" id="Cherchez" class="btn btn-sm btn-default" value="Chercher">
                </form></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
</table>
<p></p>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr bgcolor="#0000FF">
    <td width="293" align="center" bgcolor="#3071AA"><strong><font color="#FFFFFF" size="4">Ville</font></strong></td>
    <td width="379" align="center" bgcolor="#3071AA"><strong><font color="#FFFFFF" size="4">Quartier</font></strong></td>
    <td width="427" align="center" bgcolor="#3071AA"><font color="#FFFFFF" size="4"><strong>Suivi des impressions (MT & AUTRES)</strong></font></td>
  </tr>
  <?php
    while($data = mysqli_fetch_array($req)) {
  ?>
    <tr bgcolor="<?php echo gettatut($data['bstatut']); ?>">
      <td align="center"><?php echo $data['ville']; ?></td>
      <td align="center"><?php echo $data['quartier']; ?></td>
      <td align="center"><?php echo $data['impression']; ?> (<?php echo $data['nbch']; ?>)</td>
    </tr>
  <?php
    }
    mysqli_free_result($req); 
    echo '<span class="gras">'.barre_navigation($nb_total, $nb_affichage_par_page, $_GET['debut'], 10).'</span>';  
}  

mysqli_free_result($resultat);  

function gettatut($fetat) {
    if ($fetat=='imprimé') { 
        return "#fdff00";
    }
    return "";
}
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
    <td height="21"><?php include_once('pied.php'); ?></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>