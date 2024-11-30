<?php

// Start of Selection
require 'session.php';
require 'fc-affichage.php';
require 'fonction.php';

if (!in_array($_SESSION['u_niveau'], [1, 90, 43, 46])) {
    header("location:index.php?error=false");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php include 'titre.php'; ?></title>
</head>
<body>
<?php
require 'bienvenue.php';

$queries = [
    'actif' => "SELECT COUNT(*) AS actif FROM $tbl_contact WHERE statut='6'",
    'resilier' => "SELECT COUNT(*) AS resilier FROM $tbl_contact WHERE statut='7'",
    'police' => "SELECT COUNT(*) AS police FROM $tbl_contact WHERE statut='1'",
    'devis1' => "SELECT COUNT(*) AS devis1 FROM $tbl_contact WHERE statut='2'",
    'devis2' => "SELECT COUNT(*) AS devis2 FROM $tbl_contact WHERE statut='3'",
    'brancher' => "SELECT COUNT(*) AS brancher FROM $tbl_contact WHERE statut='4'",
    'ffacture' => "SELECT COUNT(*) AS ffacture FROM $tbl_contact WHERE statut='5'",
    'bt' => "SELECT COUNT(*) AS bt FROM $tbl_contact WHERE statut='6' AND Tarif!='10'",
    'mt' => "SELECT COUNT(*) AS mt FROM $tbl_contact WHERE statut='6' AND Tarif='10'",
    'mono' => "SELECT COUNT(*) AS mono FROM $tbl_contact WHERE statut='6' AND Tarif IN ('2', '3', '4', '6', '7', '8', '9', '11')",
    'tri' => "SELECT COUNT(*) AS tri FROM $tbl_contact WHERE statut='6' AND Tarif IN ('1', '5', '12')",
    'v1' => "SELECT COUNT(*) AS v1 FROM $tbl_contact WHERE statut='6' AND Tarif='1'",
    'v2' => "SELECT COUNT(*) AS v2 FROM $tbl_contact WHERE statut='6' AND Tarif='2'",
    'v3' => "SELECT COUNT(*) AS v3 FROM $tbl_contact WHERE statut='6' AND Tarif='3'",
    'v4' => "SELECT COUNT(*) AS v4 FROM $tbl_contact WHERE statut='6' AND Tarif='4'",
    'v5' => "SELECT COUNT(*) AS v5 FROM $tbl_contact WHERE statut='6' AND Tarif='5'",
    'v6' => "SELECT COUNT(*) AS v6 FROM $tbl_contact WHERE statut='6' AND Tarif='6'",
    'v7' => "SELECT COUNT(*) AS v7 FROM $tbl_contact WHERE statut='6' AND Tarif='7'",
    'v8' => "SELECT COUNT(*) AS v8 FROM $tbl_contact WHERE statut='6' AND Tarif='8'",
    'v9' => "SELECT COUNT(*) AS v9 FROM $tbl_contact WHERE statut='6' AND Tarif='9'",
    'v10' => "SELECT COUNT(*) AS v10 FROM $tbl_contact WHERE statut='6' AND Tarif='10'",
    'v11' => "SELECT COUNT(*) AS v11 FROM $tbl_contact WHERE statut='6' AND Tarif='11'",
    'v12' => "SELECT COUNT(*) AS v12 FROM $tbl_contact WHERE statut='6' AND Tarif='12'"
];

$results = [];
foreach ($queries as $key => $query) {
    $req = mysqli_query($linki, $query);
    $data = mysqli_fetch_assoc($req);
    $results[$key] = $data[$key];
}
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">&nbsp;</h3>
    </div>
    <div class="panel-body">
        <a href="re_affichage_n.php" class="btn btn-sm btn-success">Police à Payer</a> |
        <a href="re_affichage_devis.php" class="btn btn-sm btn-success">Devis à realiser</a> |
        <a href="re_affichage_branch.php" class="btn btn-sm btn-success">Devis realisé</a> |
        <a href="re_affichage_connecte.php" class="btn btn-sm btn-success">Client à Brancher</a> |
        <a href="re_affichage_facture.php" class="btn btn-sm btn-success">Client à Facturer</a> |
        <a href="re_affichage.php" class="btn btn-sm btn-success">Client actifs</a> |
        <a href="re_affichage_resilier.php" class="btn btn-sm btn-success">Client résilié</a> |
    </div>
</div>
<p>&nbsp;</p>
<table width="100%" border="0">
    <tr>
        <td width="96%">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">INFO SUR LES CLIENTS</h3>
                </div>
                <div class="panel-body">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                            <td width="47%">
                                <table width="100%" border="0">
                                    <tr>
                                        <td width="8%" height="43">Police à payer</td>
                                        <td width="10%">Devis à realiser</td>
                                        <td width="9%">Devis realisé</td>
                                        <td width="10%">A Brancher</td>
                                        <td width="10%">Client à Fact</td>
                                        <td width="9%">Client Actif</td>
                                        <td width="10%">Monophasé</td>
                                        <td width="9%">Triphasé(BT)</td>
                                        <td width="9%">Client BT</td>
                                        <td width="9%">Client MT</td>
                                        <td width="7%">Resilié</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $results['police']; ?></td>
                                        <td><?php echo $results['devis1']; ?></td>
                                        <td><?php echo $results['devis2']; ?></td>
                                        <td><?php echo $results['brancher']; ?></td>
                                        <td><?php echo $results['ffacture']; ?></td>
                                        <td><?php echo $results['actif']; ?></td>
                                        <td><?php echo $results['mono']; ?></td>
                                        <td><?php echo $results['tri']; ?></td>
                                        <td><?php echo $results['bt']; ?></td>
                                        <td><?php echo $results['mt']; ?></td>
                                        <td><?php echo $results['resilier']; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
    <tr>
        <td width="96%" height="114">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">DETAIL DES CLIENTS PAR TARIFICATION</h3>
                </div>
                <div class="panel-body">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                            <td width="47%">
                                <table width="100%" border="0">
                                    <tr>
                                        <td width="8%" height="34">Elec BT Triphasé</td>
                                        <td width="10%"><?php echo $results['v1']; ?></td>
                                        <td width="9%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="32" bgcolor="#CCCCCC">Elec BT Monophasé Domestique</td>
                                        <td bgcolor="#CCCCCC"><?php echo $results['v2']; ?></td>
                                        <td bgcolor="#CCCCCC">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="32">Mosquée</td>
                                        <td><?php echo $results['v3']; ?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="34" bgcolor="#CCCCCC">BT Mono Pomoni</td>
                                        <td bgcolor="#CCCCCC"><?php echo $results['v4']; ?></td>
                                        <td bgcolor="#CCCCCC">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="33">BT Tri Pomoni</td>
                                        <td><?php echo $results['v5']; ?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="37" bgcolor="#CCCCCC">BT Mono Agent</td>
                                        <td bgcolor="#CCCCCC"><?php echo $results['v6']; ?></td>
                                        <td bgcolor="#CCCCCC">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="40">BT Mono Agent P</td>
                                        <td><?php echo $results['v7']; ?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="36" bgcolor="#CCCCCC">BT Mono Agent retraité</td>
                                        <td bgcolor="#CCCCCC"><?php echo $results['v8']; ?></td>
                                        <td bgcolor="#CCCCCC">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="34">BT Mono Retraité P</td>
                                        <td><?php echo $results['v9']; ?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="35" bgcolor="#CCCCCC">MT</td>
                                        <td bgcolor="#CCCCCC"><?php echo $results['v10']; ?></td>
                                        <td bgcolor="#CCCCCC">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="47">BT Mono Agent Couple</td>
                                        <td><?php echo $results['v11']; ?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="37" bgcolor="#CCCCCC">BT Tri 500</td>
                                        <td bgcolor="#CCCCCC"><?php echo $results['v12']; ?></td>
                                        <td bgcolor="#CCCCCC">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <div align="center"></div>
        </td>
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
