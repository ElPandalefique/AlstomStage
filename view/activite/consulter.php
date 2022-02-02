<legend>Amicale des cadres ALSTOM</legend>

<fieldset>
    <section class="table_responsive">
        <table class="mx-auto" style="border-spacing : 20px;border-collapse : separate;">

            <legend>Consulter une activité</legend>


            <!-- Leader de l'activité -->
            <tr class="">
                <td class="text-right "><strong>Leader de l'activité :</strong></td>
                <td disabled
                    class="pl-3">  <?= (isset($leader->NOMLEADER) ? $leader->NOMLEADER : '') ?> <?= (isset($leader->PRENOMLEADER) ? $leader->PRENOMLEADER : '') ?></td>
            </tr>
            <!-- Nom de l'activité -->
            <tr>
                <td class="text-right"><strong>Nom de l'activité :</strong></td>
                <td class="pl-3"><?= (isset($donnees->NOM) ? $donnees->NOM : '') ?></td>
            </tr>
            <!-- Detail de l'activité -->
            <tr>
                <td class="text-right"><strong>Detail de l'activité :</strong></td>
                <td class="pl-3"><?= (isset($donnees->DETAIL) ? $donnees->DETAIL : '') ?></td>
            </tr>
            <!-- Adresse de l'activité -->
            <tr>
                <td class="text-right"><strong>Adresse :</strong></td>
                <td class="pl-3"><?= (isset($donnees->ADRESSE) ? $donnees->ADRESSE : '') ?></td>
            </tr>
            <!-- Code postale -->
            <tr>
                <td class="text-right"><strong>Code Postale :</strong></td>
                <td class="pl-3"><?= (isset($donnees->CP) ? $donnees->CP : '') ?></td>
            </tr>
            <!--  Ville de l'activité -->
            <tr>
                <td class="text-right"><strong>Ville :</strong></td>
                <td class="pl-3"><?= (isset($donnees->VILLE) ? $donnees->VILLE : '') ?></td>
            </tr>
            <!-- Age Minimum -->
            <tr>
                <td class="text-right"><strong>Age Minimum :</strong></td>
                <td class="pl-3"><?= (isset($donnees->AGE_MINIMUM) ? $donnees->AGE_MINIMUM . " ans" : '') ?></td>
            </tr>
            <!-- Indications aux participants -->
            <tr>
                <td class="text-right"><strong>Indications aux participants :</strong></td>
                <td class="pl-3"><?= (isset($donnees->INDICATION_PARTICIPANT) ? $donnees->INDICATION_PARTICIPANT : '') ?></td>
            </tr>
            <!-- Info Importante aux participants -->
            <tr>
                <td class="text-right"><strong>Informations Importantes aux Participants :</strong></td>
                <td class="pl-3"><?= (isset($donnees->INFO_IMPORTANT_PARTICIPANT) ? $donnees->INFO_IMPORTANT_PARTICIPANT : '') ?></td>
            </tr>

        </table>
        <br>

        <h4><strong>Liste des prestations</strong></h4>
        <table class="table table-bordered table-condensed table-striped">
            <td>Nom de la prestation</td>
            <td>Prix</td>
            <td>Age min</td>
            <td>Age max</td>
            <td>Externes</td>
            <tr><td><strong>Prestations Principales</strong></td></tr>

            <?php
            foreach($prestationsP as $prestation){
                if($prestation->OUVERT_EXT==1){
                    $ouvertext = "Oui";
                }
                else{
                    $ouvertext = "Non";
                };
                echo "<tr>
<td>$prestation->LIBELLE</td>
<td>$prestation->PRIX €</td>
<td>";
                if($prestation->AGEMIN==0){
                    echo"aucun";
                }
                else{
                    echo "$prestation->AGEMIN ans";
                }

                echo"</td>
<td>";
                if($prestation->AGEMAX==99){
                    echo"aucun";
                }
                else{
                    echo "$prestation->AGEMAX ans";
                }

                echo"</td>
<td>$ouvertext</td>
</tr>";
            }
            if(isset($prestationsS)) {
                echo "<tr><td><strong>Prestations secondaires</strong></td></tr>";
                foreach ($prestationsS as $prestation) {
                    if ($prestation->OUVERT_EXT == 1) {
                        $ouvertext = "Oui";
                    } else {
                        $ouvertext = "Non";
                    };
                    echo "<tr>
<td>$prestation->LIBELLE</td>
<td>$prestation->PRIX €</td>
<td>";
                    if ($prestation->AGEMIN == 0) {
                        echo "aucun";
                    } else {
                        echo "$prestation->AGEMIN ans";
                    }

                    echo "</td>
<td>";
                    if ($prestation->AGEMAX == 99) {
                        echo "aucun";
                    } else {
                        echo "$prestation->AGEMAX ans";
                    }

                    echo "</td>
<td>$ouvertext</td>
</tr>";

                }
            }
            ?>

        </table>
<!--
        <table id="liste_tournoi" class="table table-bordered table-condensed table-striped">

            <div class="form-group">
                <table id="liste_tournoi" class="table table-bordered table-condensed table-striped">
                    <td>Prix Adulte</td>
                    <td>Prix Enfant</td>
                    <td>Prix Adulte Extérieur</td>
                    <td>Prix Enfant Extérieur</td>
                    <tr>
                        <td><?= $donnees->PRIX_ADULTE . "  €" ?></td>
                        <td><?= $donnees->AGE_MINIMUM < 18 ? $donnees->PRIX_ENFANT . "  €"  : 'Activité non ouverte aux enfants'?></td>
                        <td><?= $donnees->OUVERT_EXT == 1 ? $donnees->PRIX_ADULTE_EXT . "  €" : 'Activité non ouverte aux externes'?></td>
                        <td><?= $donnees->AGE_MINIMUM < 18 && $donnees->OUVERT_EXT == 1 ? $donnees->PRIX_ENFANT_EXT . "  €"  : 'Activité non ouverte aux enfants externes'?></td>
                    </tr>
                </table>
            </div>
            -->

            <br>
            Liste des Créneaux
        <?php
            if(isset($creneaux)){
                foreach ($creneaux as $cre){
                    echo"<p>$cre->DATE_CRENEAU, $cre->HEURE_CRENEAU</p>";
                }
            }
        ?>
            <hr>
            <div class="form-group">
                <table class="table table-bordered table-condensed table-striped">
                    <td>Date</td>
                    <td>Heure</td>
                    <td>Participants</td>
                    <td>Effectif</td>
                    <td>Nombre de personnes en attente</td>
                    <?php
                    if(!empty($effectifs)){
//            var_dump($effectifs);
                        foreach ($effectifs as $eff){
                            $format = date_create($eff->DATE_CRENEAU);
                            $date = date_format($format, 'd-m-Y');
                            $heure = substr($eff->HEURE_CRENEAU, 0, -3);
                            $effectif=$effectif=$eff->effectif;
                            foreach ($effectifInvite as $invite){
                                if($eff->NUM_CRENEAU==$invite->NUM_CRENEAU){
                                    $effectif-=$invite->effectif;
                                }
                            }
                            $attentes=0;
                            foreach ($effectifsattente as $attente){
                                $attentes = $attente->effectif;
                                foreach ($effectifInviteattente as $attenteinv){
                                    if($eff->NUM_CRENEAU==$attente->NUM_CRENEAU && $eff->NUM_CRENEAU==$attenteinv->NUM_CRENEAU){
                                        $attentes-=$attenteinv->effectif;
                                    }
                                }
                            }
                            echo"<tr><td>$date</td><td>$heure</td><td>";
                            if (!empty($eff->adh)) {
                                if (!empty($eff->listeinv)) {
                                    echo $eff->listeinv . '<br>';
                                }
                                echo $eff->adh;
                            } else {
                                echo $eff->listeinv;
                            }
                            echo"</td><td>$effectif / $eff->EFFECTIF_CRENEAU</td><td>$attentes</td></tr>";
                        }
                    }
                    ?>

                </table>
            </div>
</fieldset>

<div>
    <button id="singlebutton" name="singlebutton" class="btn btn-info"
            onclick="window.location.href = '../../activite/formulaireInscription/<?= $donnees->ID_ACTIVITE ?>'">
        S'inscrire
    </button>
</div>
<div class="alert-info" name="info"><?= (isset($info) ? $info : '') ?></div>