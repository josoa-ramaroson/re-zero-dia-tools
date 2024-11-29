<?php 

require "session.php";
require 'fonction.php';

// Remplacer l'ancien calendrier par jQuery UI
?>
<!-- Ajout des CDN nécessaires -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

<table width="100%" border="0">
  <!-- ... début du tableau ... -->
  <tr>
    <td>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Liste des ventes par date &amp; agent</h3>
        </div>
        <div class="panel-body">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td width="47%">
                <table width="100%" border="0.5" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="52%">
                      <form action="rapport_listedateagent.php" method="post" name="form3" id="form5">
                        <input type="text" id="dateB" name="dateB" class="datepicker" readonly="readonly">
                        <font color="#000000">
                          <strong>
                            <select name="agentv" id="agentv">
                              <?php
                              $sql8 = "SELECT DISTINCT * FROM $tbl_paiement WHERE id_nom = '$id_nom'  ORDER BY id_nom ASC";
                              $result8 = mysqli_query($linki, $sql8);
                              if ($result8) {
                                while ($row8 = mysqli_fetch_assoc($result8)) {
                                  echo '<option value="' . htmlspecialchars($row8['id_nom']) . '">' . 
                                       htmlspecialchars($row8['id_nom']) . '</option>';
                                }
                              }
                              ?>
                            </select>
                          </strong>
                        </font>
                        <input type="submit" name="valider2" id="valider2" value="Valider" />
                      </form>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Activité par Date &amp; Agent</h3>
        </div>
        <div class="panel-body">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td width="47%">
                <form action="rapport_agent.php" method="post" name="form2" id="form6">
                  <input type="text" id="datec" name="datec" class="datepicker" readonly="readonly">
                  <font color="#000000">
                    <strong>
                      <select name="agent" id="agent">
                        <?php
                        $sql8 = "SELECT DISTINCT * FROM $tbl_paiement WHERE id_nom = '$id_nom' ORDER BY id_nom ASC";
                        $result8 = mysqli_query($linki, $sql8);
                        if ($result8) {
                          while ($row8 = mysqli_fetch_assoc($result8)) {
                            echo '<option value="' . htmlspecialchars($row8['id_nom']) . '">' . 
                                 htmlspecialchars($row8['id_nom']) . '</option>';
                          }
                        }
                        ?>
                      </select>
                    </strong>
                  </font>
                  <input type="submit" name="valider6" id="valider4" value="Valider" />
                </form>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </td>
    <!-- ... reste du tableau ... -->
  </tr>
</table>

<script>
$(document).ready(function() {
    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '2018:2024',
        firstDay: 1,
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesMin: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc']
    });
});
</script>