<?php
Require 'session.php';
require_once('calendar/classes/tc_calendar.php');
require 'fc-affichage.php';
require 'fonction.php';
require 'configuration.php';
?>
<?
if(($_SESSION['u_niveau'] != 3)) {
	header("location:index.php?error=false");
	exit;
 }
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
//alert(httpxml.responseText);
var myarray = JSON.parse(httpxml.responseText);

//--------- Pour le champs il y a 3 document.testform.quartier.options
for(j=document.testform.quartier.options.length-1;j>=0;j--)
{
//--------- Pour le champs il y a document.testform.quartier.options
document.testform.quartier.remove(j);
}


for (i=0;i<myarray.data.length;i++)
{
var optn = document.createElement("OPTION");

//le champs quartier qui est dans la table quartier
optn.text = myarray.data[i].quartier;
optn.value = myarray.data[i].id_quartier;  // You can change this to subcategory 

//--------- Pour le champs il y a 3 document.testform.quartier.options 
document.testform.quartier.options.add(optn);

} 
      }
    } // end of function stateck
	var url="fonction_dvq.php";

//le champs ville qui se trouve dans la table Ville
var refville=document.getElementById('s1').value;
url=url+"?refville="+refville;
//-------------------------------------
url=url+"&sid="+Math.random();
httpxml.onreadystatechange=stateck;
//alert(url);
httpxml.open("GET",url,true);
httpxml.send(null);
  }
</script>

</head>
<?php
Require("bienvenue.php");  // on appelle la page contenant la fonction
?>
 
<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0">
  <tr>
    <td width="63%"><div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"> Penalité par Ville et Quartier</h3>
      </div>
      <div class="panel-body">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="47%"><table width="100%" border="0.5" cellspacing="0" cellpadding="0">
              <tr>
                <td width="52%"><form action="penalite_quartier.php" method="post" name="testform" id="form3">
                  <strong>Ville</strong> :
                  <?Php
require "fonction.php";// connection to database 

echo "<select name=refville id='s1' onchange=AjaxFunction();>
<option value=''>Choisissez une ville</option>";

$sql="select * from ville "; // Query to collect data from table 
$result = mysqli_query($linki, $sql);

if (!$result) {
    die("Erreur dans la requête : " . mysqli_error($linki));
}

while ($row = mysqli_fetch_assoc($result)) {
    echo '<option value="' . htmlspecialchars($row['refville'], ENT_QUOTES) . '">' 
         . htmlspecialchars($row['ville'], ENT_QUOTES) . '</option>';
}

mysqli_free_result($result);
?></select>
<strong>Quartier</strong>
                  : 
                  <select name=quartier id='s2'>
                  </select>
                  <input type="submit" name="Submit4" class="btn btn-sm btn-default" value="executer" />
                  
                </form></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </div>
    </div></td>
    <td width="2%">&nbsp;</td>
    <td width="35%"><div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Penalité pour tous les clients</h3>
      </div>
      <div class="panel-body">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="47%"><table width="100%" border="0.5" cellspacing="0" cellpadding="0">
              <tr>
                <td width="52%"><?php echo "<a class=\"text-black\" type=\"button\" href=\"penalite_ttclient.php\" onClick=\"return confirm('Etes-vous sûr de vouloir taxer les 1000FC ')\"> Penalité pour tous les clients </a> ";?></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
</table>
               <?php
                $llErreur = false;
                if (isset($_GET["a"]))
                $llErreur = true;
                ?>
                <div id="error" class="boiteorange" style="display:<?php if ($llErreur){echo "block";}else{echo "none";}?>;width:300px;">
                <p style="color:#F00">Votre demande a été executé avec succes, Merci.<br /> </p>
                </div>
<p></p>
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