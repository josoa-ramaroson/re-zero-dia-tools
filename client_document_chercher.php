<?php
require 'fc-affichage.php';
require 'fonction.php';
require 'session.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
span.surlign1{font-style:italic; background-color:#ffff00;}
span.surlign2{font-style:italic; background-color:#ff99FF;}
span.surlign3{font-style:italic; background-color:#ff9999;}
span.surlign4{font-style:italic; background-color:#9999FF;}
body {
    background-image: url(images/bg.jpg);
    background-color: #FFF;
}
body,td,th {
    color: #000;
}
</style>
<title>Recherche de Documents</title>
</head>
<?php
require 'bienvenue.php';
?>
<body>
<p>&nbsp;</p>
<table width="99%" border="0">
  <tr>
    <td width="33%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="26%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="39%"><div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Id_Client, Nom, Prenom, Titre</h3>
      </div>
      <div class="panel-body">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="47%"><table width="100%" border="0.5" cellspacing="0" cellpadding="0">
              <tr>
                <td width="52%"><form action="client_document_chercher.php" method="post" name="form1" id="form2">
                  <label for="mr1"></label>
                  <input name="mr1" type="text" id="mr1" size="30" />
                  <input type="submit" name="Cherchez" id="Cherchez" class="btn btn-sm btn-default" value="Chercher un document" />
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
if (isset($_POST['mr1'])) {
    $mr1 = addslashes($_POST['mr1']);
    $s = explode(" ", $mr1);

    $sql = "SELECT count(*) FROM $tbl_client_doc";  
    $resultat = mysqli_query($linki, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  
    $nb_total = mysqli_fetch_array($resultat);  
    
    if (($nb_total = $nb_total[0]) == 0) {  
        echo 'Aucune reponse trouvee';  
    } else { 
        if (!isset($_GET['debut'])) $_GET['debut'] = 0; 
        $nb_affichage_par_page = 2; 

        $sql = "SELECT * FROM $tbl_client_doc WHERE "; 

        foreach($s as $mot) {
            if (strlen($mot) > 0) {
                $sql .= "idclient LIKE '%".mysqli_real_escape_string($linki, $mot)."%' 
                        OR titre LIKE '%".mysqli_real_escape_string($linki, $mot)."%' 
                        OR description LIKE '%".mysqli_real_escape_string($linki, $mot)."%' OR ";
            }
        }

        $sql .= " 0 ORDER BY idclient ASC";  

        $req = mysqli_query($linki, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($linki));  

        function Nom_prenom_client($LE_idclient, $tbl_contact, $linki) {
            $sqld7 = "SELECT nomprenom FROM $tbl_contact WHERE id = '".mysqli_real_escape_string($linki, $LE_idclient)."'";
            $resultatd7 = mysqli_query($linki, $sqld7); 
            $nqtd7 = mysqli_fetch_assoc($resultatd7);
            return isset($nqtd7['nomprenom']) ? $nqtd7['nomprenom'] : '';
        }   
?>
</p>
<table width="98%" border="1" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
    <tr bgcolor="#3071AA">
        <td width="11%" align="center"><font color="#FFFFFF" size="4"><strong>ID</strong></font></td>
        <td width="28%" align="center"><font color="#FFFFFF" size="3"><strong>Nom et Prenom</strong></font></td>
        <td width="22%" align="center"><font color="#FFFFFF"><strong>Titre</strong></font></td>
        <td width="22%" align="center">&nbsp;</td>
        <td width="17%" align="center">&nbsp;</td>
    </tr>
    <?php
    while($data = mysqli_fetch_array($req)) { 
        $idclient = $data['idclient'];
        $titre = $data['titre'];
        
        $i = 0;
        foreach($s as $mot) {
            if (strlen($mot) > 0) {
                $i++;
                if ($i > 4) {$i = 1;}
                $idclient = str_replace($mot, '<span class="surlign'.$i.'">'.$mot.'</span>', $idclient);
                $titre = str_replace($mot, '<span class="surlign'.$i.'">'.$mot.'</span>', $titre);
            }
        }
    ?>
    <tr>
        <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $idclient; ?></em></div></td>
        <td align="center" bgcolor="#FFFFFF"><div align="left">
            <?php echo Nom_prenom_client($data['idclient'], $tbl_contact, $linki); ?>
        </div></td>
        <td align="center" bgcolor="#FFFFFF"><div align="left"><em><?php echo $titre; ?></em></div></td>
        <td align="center" bgcolor="#FFFFFF"><div align="left"></div></td>
        <td align="center" bgcolor="#FFFFFF">
            <?php 
            $filename = 'upload/document_client/'.$data['iddocument'].'.jpg';
            if (file_exists($filename)) { 
            ?>
                <a href="client_document_file_apercu.php?doc=<?php echo md5(microtime()).$data['iddocument']; ?>&amp;d=<?php echo md5(microtime());?>" 
                   onClick="return !window.open(this.href, 'pop', 'width=679,height=679,left=120,top=120');">
                    <img src="upload/document_client/document_file.jpg" width="38" height="42" class="pix" />
                </a>
            <?php } ?>
        </td>
    </tr>
    <?php
    }
    mysqli_free_result($req); 
    }  
    mysqli_free_result($resultat);  
} else {
    echo "Pas de recherche <br>";
} 
?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>