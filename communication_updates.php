<?php

/*if( isset($_POST['upload']) ) // si formulaire soumis
{
    $content_dir = 'upload/'; // dossier où sera déplacé le fichier

    $tmp_file = $_FILES['fichier']['tmp_name'];

    if( !is_uploaded_file($tmp_file) )
    {
		header("location: communication.php");
        exit("Le fichier est introuvable");
    }

    // on vérifie maintenant l'extension
    $type_file = $_FILES['fichier']['type'];

  	if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
    {
		header("location: communication.php");
        exit("Le fichier n'est pas une image ");
    }

 // on vérifie maintenant la capacite de l image 
 
      if (filesize($_FILES['fichier']['tmp_name']) >3145728)
	  {
	   header("location: communication.php");
       exit ("image trop grande, limitée à 3Mo");
      }


    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier']['name'];
    
    if( ! move_uploaded_file($tmp_file, $content_dir . $name_file) )
    {
        exit("Impossible de copier le fichier dans $content_dir");
    }
  // echo "Le fichier a bien été uploadé";
 } 
   
   //$siteweb_dir = 'http://localhost/xampp/webcc/';
   $siteweb_dir = 'http://www.cciaanjouan.com/';
   $lefichier="$siteweb_dir$content_dir$name_file";	*/
   
$lefichier='';
$id=$_REQUEST["id"];
$titre=addslashes($_POST['titre']);
$detail=addslashes($_POST['detail']);
$date=addslashes($_POST['date']);
$id_nom=addslashes($_POST['id_nom']);


    require 'fonction.php';
    $link = mysqli_connect ($host,$user,$pass);
    mysqli_select_db($link, $db);

#---------------------------------------------------3 
$sqlp="update  $tbl_com  set  date='$date', titre='$titre' , detail='$detail' ,  id_nom='$id_nom' , fichier='$lefichier' WHERE idcom='$id'";
$resultp=mysqli_query($link, $sqlp);
if($resultp){
}
else {
echo "ERROR";
}
mysql_close();
header("location: communication.php");?>