<?php
Require 'session.php';
require 'fonction.php';
?>
<?
if(($_SESSION['u_niveau']!= 7) &&($_SESSION['u_niveau']!= 10)) {
	header("location:index.php?error=false");
	exit;
 }
?>
<html>
<head>
<title><?php include("titre.php"); ?></title>
<meta name="viewport" content="width=device-width, minimum-scale=0.25"/>
<script language="JavaScript" src="js/validator.js" type="text/javascript" xml:space="preserve"></script>

<style type="text/css">
.rouge {	color: #F00;
}
</style>
</head>
<?php
Require 'bienvenue.php';    // on appelle la page contenant la fonction
?>
<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
<p>
<?php
Require 'xbackup_menu.php';
?>

<p>
  <?php
	
    function dump($ignore)
    {
	
	 require 'fonction.php';

     $server   = $host ;
     $database =  $db;
   
     $password = $pass;
	 
	 $table1=$_REQUEST["table"];
	 
   

    
 	$sql = "SHOW TABLES FROM $database WHERE Tables_in_$database='$table1'" ;
	 
     $tables = mysqli_query($linki,$sql) or die(mysqli_error($linki));
      
   
     for ($i=0; $i<$ignore; $i++) ($donnees = mysqli_fetch_array($tables));
      
  
     while ($donnees = mysqli_fetch_array($tables))
     {
	 
      $table = $donnees[0];
      $sql = 'SHOW CREATE TABLE '.$table;
      $res = mysqli_query($linki,$sql) or die(mysqli_error($linki).$sql);
      if ($res)
      {
       
	   $datedossier = date("d_m_Y");
	   $datedossier ='Day_'. $datedossier;
	   
       @mkdir ('backup/' . $datedossier);
       $backup_file = 'backup/' . $datedossier . '/' . $table . '.sql.gz';  
       ?>
	   
	   <br>Sauvegarde de la table: <?php echo $table;
	   
       $fp = gzopen($backup_file, 'w');
      
       $tableau = mysqli_fetch_array($res);
       $tableau[1] .= ";\n";
       $insertions = $tableau[1];
       gzwrite($fp, $insertions);
      
       $req_table = mysqli_query($linki, 'SELECT * FROM '.$table) or die(mysqli_error($linki));
       $nbr_champs = mysqli_num_fields($req_table);
       while ($ligne = mysqli_fetch_array($req_table))
       {
        $insertions = 'INSERT INTO '.$table.' VALUES (';
        for ($i=0; $i<$nbr_champs; $i++)
        {
         $insertions .= '\'' . mysqli_real_escape_string($linki, $ligne[$i]) . '\', ';
        }
        $insertions = substr($insertions, 0, -2);
        $insertions .= ");\n";
        gzwrite($fp, $insertions);
       }
      } // fin if ($res)
      mysqli_free_result($res);
      gzclose($fp);
	  
	  
	}  
     return true;
    }
      
   
    $dump = dump(0);
    ?>
	<br><br>Proc&#233dure termin&#233e. Base de donn&#233es sauvegard&#233e.</br>
</p>
<p>&nbsp; </p>
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