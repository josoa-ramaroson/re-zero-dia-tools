<?php
require 'fonction.php';
require 'configuration.php';

$Numc=addslashes($_POST['Numc']);
$Description=addslashes($_POST['Description']);
mysqli_query($link, "INSERT INTO $compte (Numc,Description) VALUE ('$Numc','$Description')");
mysqli_close($link);


include ("compt_compte.php");
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

</body>
</html>