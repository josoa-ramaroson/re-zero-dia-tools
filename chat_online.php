<?php
$tps_max_connex = 180;  
$temps_actuel = date("U");  
$sqlnb = 'SELECT count(*) FROM chat_nb WHERE sid1= "'.$_SESSION['SID1'].'" AND sid2= "'.$_SESSION['SID2'].'" ';  
$reqnb = mysqli_query($link, $sqlnb) or die('Erreur SQL !<br />'.$sqlnb.'<br />'.mysqli_error($link));
$datanb = mysqli_fetch_array($reqnb);
 
mysqli_free_result($reqnb);  
 
if ($datanb[0]) { 
   $sqlnb = 'UPDATE  chat_nb SET time = "'.$temps_actuel.'" WHERE sid1= "'.$_SESSION['SID1'].'" AND sid2= "'.$_SESSION['SID2'].'"'; 
   $reqnb = mysqli_query($link, $sqlnb) or die ('Erreur SQL !<br />'.$sqlnb.'<br />'.mysqli_error($link));
}  
else {  
   $sqlnb = 'INSERT INTO  chat_nb (time,SID1,SID2) VALUES ("'.$temps_actuel.'","'.$_SESSION['SID1'].'","'.$_SESSION['SID2'].'")';  
   $reqnb = mysqli_query($link, $sqlnb) or die ('Erreur SQL !<br />'.$sqlnb.'<br />'.mysqli_error($link));
}  
 
$heure_max = $temps_actuel - $tps_max_connex;  
$sql2nb = 'DELETE  FROM  chat_nb where time < "'.$heure_max.'"';  
 
$req2nb = mysqli_query($link, $sql2nb) or die ('Erreur SQL !<br />'.$sql2nb.'<br />'.mysqli_error($link));
?> 
<?php
$sqlaf = 'SELECT count(*) FROM chat_nb  WHERE (sid1= "'.$_SESSION['SID1'].'" AND sid2= "'.$_SESSION['SID2'].'") or (sid1= "'.$_SESSION['SID2'].'" AND sid2= "'.$_SESSION['SID1'].'")  ';  
$reqaf = mysqli_query($link, $sqlaf) or die('Erreur SQL !<br />'.$sqlaf.'<br />'.mysqli_error($link));
$dataaf = mysqli_fetch_array($reqaf);
mysqli_free_result($reqaf);
$nbligne=$dataaf[0];  
?> 