<?php
	global $u_utilisateur;
	$login=addslashes($_POST['m1']);
	$motdepasse=addslashes(md5($_POST['m2']));
	require 'fonction.php';
	$link = mysqli_connect ($host,$user,$pass);
//	$link = mysqli_connect ($host,$user,$pass);
	mysqli_select_db($link, $db);
	$sql="SELECT * FROM $tbl_utilisateur WHERE u_login='$_POST[m1]' and u_pwd='$motdepasse' and statut='Operationnel'" ;
	$resultat= mysqli_query($link, $sql);
//	$resultat= mysqli_query($link, $sql);
	$u_utilisateur=mysqli_fetch_array($resultat);
//	$u_utilisateur=mysqli_fetch_array($resultat);

	if ($u_utilisateur===FALSE)
	{

		//---------------DEBUT CLIENT------------------------------------------------------------------------//

		//---------------FIN   CLIENT -------------------------------------------------------------------------
		header("location:index.php?a=false");
		exit;
	} else {
		@session_start();
		$_SESSION['u_login']=$_POST['m1'];
		$_SESSION['niveau']=$u_utilisateur['u_niveau'];
		$_SESSION['privileges']=$u_utilisateur['privileges'];
		$_SESSION['SID']=$u_utilisateur['id_u'];
		$_SESSION['APP']='111fc469d902d74a481bae7b217f4e58';

	    $idsession=$u_utilisateur['id_u'];
		$sqlp="update $tbl_utilisateur  set session=1  WHERE  id_u='$idsession'";
        $resultp=mysqli_query($link,$sqlp);


		header("location:welcome.php");
		}
?>
