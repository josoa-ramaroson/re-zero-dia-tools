<?php
require 'fonction.php';
require 'configuration.php';
//----------------parametre de configuration--------
//------------identification du maximun -----------
$sqlmax="SELECT MAX(idf) AS Maxa_id FROM $tbl_fact";
$resultmax=mysqli_query($linki,$sqlmax);
$rowsmax=mysqli_fetch_array($resultmax);
if ($rowsmax) {
$Max_id = $rowsmax['Maxa_id']+1;
}
else {
$Max_id = 1;
}
//--------------------------------------
 $id_user=addslashes($_POST['id_user']);
$id_nom=addslashes($_POST['id_nom']);
$id=addslashes($_POST['id']);
$st=$_POST['st'];
//$nfacture=$Max_id.$ci.$st.$annee;
//$nfacture=$Max_id.$st;
$nfacture=$Max_id.'I'.$id_user.$st;
//----
$fannee=$annee_facturation;
//$fannee=$annee;
//$iannee=$annee-1;
$date=$datec;
$datelimite=$datcoupure;
$libelle=addslashes($_POST['libelle']);
$bnom=addslashes($_POST['bnom']);
$bquartier=addslashes($_POST['bquartier']);
$bstatut=addslashes($_POST['bstatut']);
//$Police=addslashes($_POST['Police']);

$nf=addslashes($_POST['nf']);
$n=addslashes($_POST['n']);


if ($nf<$n) {
header("location:co_facturation.php");
exit;
}

$Tarif=addslashes($_POST['Tarif']);
$sql82 ="SELECT * FROM tarif where idt='$Tarif'";
var_dump($sql82);
$result82 = mysqli_query($linki,$sql82);
while ($row82 = mysqli_fetch_assoc($result82)) {
$t1=$row82['t1'];
$t2=$row82['t2'];
$q=$row82['q'];
$type=$row82['typecom'];
$alpha=$row82['alpha'];
}

$c=$nf-$n;
//$q = 20;
var_dump($nf);die();

if ($c < $q)  {$c1 = $c; $c2 = 0;}
if ($c == $q) {$c1 = $c; $c2 = 0;}
if ($c > $q)  {$c1 = $q; $c2 = $c-$q;}
if ($c == 0)  {$c1 = 0;  $c2 = 0;}

//$t1=132;
//$t2=130;

$coefTi=addslashes($_POST['coefTi']);

$mtt1 = $t1 * $c1 ;
$mtt2 = $t2 * $c2 ;
$mtotal= $mtt1 + $mtt2 ;

$amperage=addslashes($_POST['amperage']);

	if(!isset($amperage)|| empty($amperage)) {
	header("location:co_facturation.php");
	exit;
 }
 
if ($type=='MONO') { 
if ($amperage==5){ $ps=500;}
if ($amperage==10){ $ps=500;}
if ($amperage==15){ $ps=1000;}
if ($amperage==20){ $ps=1500;}
if ($amperage==25){ $ps=2000;}
if ($amperage==30){ $ps=2500;}
if ($amperage==35){ $ps=3000;}
if ($amperage==40){ $ps=3500;}
if ($amperage==45){ $ps=4000;}
if ($amperage==50){ $ps=4500;}
if ($amperage==55){ $ps=5000;}
if ($amperage==60){ $ps=5500;}
if ($amperage>60) { $ps=4000+(($amperage-45)/5)*500;}
}
if ($type=='TRI')  {
if ($amperage==5){ $ps=2500;}	
if ($amperage==10){ $ps=2500;}
if ($amperage==15){ $ps=5000;}
if ($amperage==20){ $ps=7500;}
if ($amperage==25){ $ps=10000;}
if ($amperage==30){ $ps=12500;}
if ($amperage==35){ $ps=15000;}
if ($amperage==40){ $ps=17500;}
if ($amperage==45){ $ps=20000;}
if ($amperage==50){ $ps=22500;}
if ($amperage==55){ $ps=25000;}
if ($amperage==60){ $ps=27500;}
if ($amperage==65){ $ps=30000;}
if ($amperage==70){ $ps=32500;}
if ($amperage==75){ $ps=35000;}
if ($amperage==80){ $ps=37500;}
if ($amperage>80) { $ps=20000+(($amperage-45)/5)*2500;}
}
//$ps=500;
$ps=$ps*$alpha;
$totalht= $mtotal+$ps ;


$chtaxe=addslashes($_POST['chtaxe']);
if ($chtaxe==0){ $tax = (3 * $totalht) / 100 ;} else {$tax=0;}


$totalttc=$tax + $totalht ;
$imp=addslashes($_POST['impayee']);

if ($Tarif==3){$ortc=0;} else { $ortc=250;}

$totalnet = $totalttc +$imp+$ortc;
$etat='facture';


 $valeur_existant = "SELECT COUNT(*) AS nb FROM $tbl_fact  WHERE st='E' and id='$id'  and fannee='$fannee' and nserie='$nserie'";
$sqLvaleur = mysqli_query($linki,$valeur_existant)or exit(mysqli_error($linki)); 
$nb = mysqli_fetch_assoc($sqLvaleur);

if($nb['nb'] == 1)
{ 	
header("location:co_facturation.php");
exit;
}


$sql="INSERT INTO $tbl_fact ( id,  ci , st, id_nom, bnom, bquartier, nfacture, fannee, nserie, date, datelimite, libelle , nf , n , cons, cons1, cons2, t1, t2, mont1, mont2, puisct, totalht, tax , totalttc, ortc, impayee , totalnet , report, etat, bstatut, impression,coefTi)
VALUES
( '$id','$ci','$st', '$id_nom', '$bnom', '$bquartier', '$nfacture', '$fannee','$nserie', '$date', '$datelimite', '$libelle', '$nf', '$n','$c', '$c1', '$c2', '$t1', '$t2', '$mtt1','$mtt2', '$ps',  '$totalht', '$tax',  '$totalttc', $ortc, '$imp' , '$totalnet', '$totalnet', '$etat', '$bstatut','saisie',  '$coefTi')";
$result=mysqli_query($linki,$sql);


$sqlindex="update $tbl_contact  set Indexinitial='$nf'  WHERE id='$id'";
$resultindex=mysqli_query($linki,$sqlindex);

   if($result){
   }
   else {
   echo "ERROR";
   }


if ($st=='E'){
$sqlbs="INSERT INTO $tbl_factsave ( id, ci , st, nserie, annee, nfacture ) VALUES ( '$id', '$ci','$st', '$nserie', '$fannee', '$nfacture')";
$resultbs=mysqli_query($linki,$sqlbs);

header("location:co_facturation.php");
}

if ($imp>'0'){
	$idf=addslashes($_POST['idf']);
	$sqlp="update  $tbl_fact  set etat='impayee' WHERE idf='$idf' and st='E'";
    $resultp=mysqli_query($linki,$sqlp);
	}

mysqli_close($linki); 
?>

