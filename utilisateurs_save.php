<?php
	global $u_utilisateur;
	$u_login=addslashes($_POST['u_login']);
	$u_pwd=addslashes(md5($_POST['u_pwd']));
	$u_pwd1=addslashes(md5($_POST['u_pwd1']));
	
	require 'fonction.php';
	$sql="SELECT * FROM $tbl_utilisateur WHERE u_login='$u_login' and u_pwd='$u_pwd'" ;
	$resultat= mysql_query($sql);
	$u_utilisateur=mysql_fetch_array($resultat);

	if ($u_utilisateur===FALSE)
	{
		header("location:utilisateurs.php");
		exit;
	} else {
$sqlp="update  $tbl_utilisateur set  u_pwd='$u_pwd1' WHERE  u_login='$u_login' and u_pwd='$u_pwd'";
$resultp=mysql_query($sqlp);

   header("location:utilisateurs.php?a=true");
   }
?>