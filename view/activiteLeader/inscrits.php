<section class="table-responsive">
    <table class="table table-bordered table-condensed table-striped">
        <th>Effectifs des créneaux</th>
        <tr>
            <td>Créneau</td>
            <td>Effectif actuel</td>
        </tr>
        <?php
        if(!empty($effectifs)){
//            var_dump($effectifs);
            $c=0;
            foreach ($effectifs as $eff){
                $format = date_create($eff->DATE_CRENEAU);
                $date = date_format($format, 'd-m-Y');
                $heure = substr($eff->HEURE_CRENEAU, 0, -3);
                $effectif=$eff->effectif+$effectifsInvite[$c]->effectif;

                $c+=1;
//                var_dump($effectif);
//                var_dump($effectifInvite);
                foreach ($effectifInvite as $invite){
                    if($eff->NUM_CRENEAU==$invite->NUM_CRENEAU){
                        $effectif-=$invite->effectif;
//                        var_dump($invite->effectif);
                    }
                }
                echo"<tr><td> Le $date à $heure</td><td>$effectif / $eff->EFFECTIF_CRENEAU</td>";
            }
        }
        ?>
    </table>
    <table class="table table-bordered table-condensed table-striped">
        <!-- entête tableau -->
        <th>Liste des inscrits</th>
        <tr>
            <td>Créneau</td>
            <td>Participant</td>
            <td>Adhérent lié</td>
            <td>Prestation</td>
            <td>Prestation(s)<br>Secondaire(s)</td>
            <td>Téléphone</td>
            <td>Montant</td>
            <td>Gérer</td>
        </tr>

        <?php if (!empty($inscrits)) {
            //$cren=date_format(date_create($inscrits[0]->DATE_CRENEAU), 'd-m-Y').' - '.substr($inscrits[0]->HEURE_CRENEAU, 0, -3);
            $count = 0;
            $cren=0;
            foreach ($inscrits as $i){
                $date = date_create($i->DATE_CRENEAU);
                $creneau = date_format($date, 'd-m-Y').' - '.substr($i->HEURE_CRENEAU, 0, -3);
                if($creneau!=$cren){
                    echo   "<tr>
            <td><strong>Autre créneau :<br>$creneau</strong></td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>";
                }
                $redirect=BASE_URL . '/activiteLeader/gerer/' . $i->ID;
                $c=0;
                $libelle = $prestation[($i->PRESTATION-1)]->LIBELLE;
                if($i->PrestationSecondaire1!=null) {
                    if($i->PrestationSecondaire2!=null) {
                        $libelleSecondaires = $prestation[($i->PrestationSecondaire1)-1]->LIBELLE . "<br>" . $prestation[($i->PrestationSecondaire2)-1]->LIBELLE;
                    }
                    else{
                        $libelleSecondaires = $prestation[($i->PrestationSecondaire1)-1]->LIBELLE;
                    }
                }
                else{
                    $libelleSecondaires ="";
                }

                ?>

                <tr>
                    <td>
                        <?= $creneau ?>
                    </td>
                    <td>
                        <?= "{$i->ADN} {$i->ADP}" ?>
                    </td>
                    <td>

                    </td>
                    <td>
                        <?=$libelle?>
                    </td>
                    <td>
                        <?=$libelleSecondaires?>
                    </td>
                    <td>
                        <?php
                        echo"$i->TELEPHONE";
                        ?>
                    </td>
                    <td>
                        <?= "{$i->MONTANT} €"?>
                    </td>

                    <td><a href="<?=
                        $redirect;
                        ?>"><button class="btn btn-primary">Gérer</button></a></td>

                </tr>
                <?php
                $dateP=date_format($date, 'd-m-Y').' - '.substr($i->HEURE_CRENEAU, 0, -3);

                if(!empty($i->INN)) {
                    foreach (range(0, (count(explode("<br>", $i->INN)) - 1)) as $n) {

                        $nom = explode("<br>", $i->INN)[$n];
                        $libellePresta='';
//                        var_dump($i);
//                        var_dump($prestation);
//                        var_dump($prestationI);
                        foreach ($prestationI as $presta) {
                            $nominvite = "$presta->NOM $presta->PRENOM";
                            if($nominvite == $nom) {
                                $libellePresta = $prestation[($presta->PRESTATION-1)]->LIBELLE;
                                if($presta->PrestationSecondaire1!=null) {
                                    if($presta->PrestationSecondaire2!=null) {
                                        $libellePrestaSec = $prestation[($presta->PrestationSecondaire1)-1]->LIBELLE . "<br>" . $prestation[($presta->PrestationSecondaire2)-1]->LIBELLE;
                                    }
                                    else{
                                        $libellePrestaSec = $prestation[($presta->PrestationSecondaire1)-1]->LIBELLE;
                                    }
                                }
                                else{
                                    $libellePrestaSec ="";
                                }
                            }
                        }
                        echo "<td>$dateP</td><td>$nom</td>
<td>$i->ADN $i->ADP</td>";
                        echo "<td>$libellePresta</td><td>$libellePrestaSec</td><td></td><td></td></tr>";


                    }
                }
                ?>

                <?php $count+=1;
                $cren = date_format($date, 'd-m-Y').' - '.substr($i->HEURE_CRENEAU, 0, -3);
            }
        } ?>
    </table>
    <?php if (!empty($inscritsA)) { $cren = date_format($date, 'd-m-Y').' - '.substr($inscritsA[0]->HEURE_CRENEAU, 0, -3);?>
    <table class="table table-bordered table-condensed table-striped">
        <!-- entête tableau -->
        <th>Liste d'attente</th>
        <tr>
            <td>Créneau</td>
            <td>Participant</td>
            <td>Adhérent lié</td>
            <td>Prestation</td>
            <td>Prestation(s)<br>Secondaire(s)</td>
            <td>Téléphone</td>
            <td>Montant</td>
            <td>Gérer</td>
        </tr>

        <?php foreach ($inscritsA as $i){
            $date = date_create($i->DATE_CRENEAU);
            $creneau = date_format($date, 'd-m-Y').' - '.substr($i->HEURE_CRENEAU, 0, -3);
            if($cren!=$creneau){
             echo   "<tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>";
            }
            $redirect=BASE_URL . '/activiteLeader/gererAttente/' . $i->ID;
            $c=0;
            $libelle = $prestation[($i->PRESTATION-1)]->LIBELLE;
            if($i->PrestationSecondaire1!=null) {
                if($i->PrestationSecondaire2!=null) {
                    $libelleSecondaires = $prestation[($i->PrestationSecondaire1)-1]->LIBELLE . "<br>" . $prestation[($i->PrestationSecondaire2)-1]->LIBELLE;
                }
                else{
                    $libelleSecondaires = $prestation[($i->PrestationSecondaire1)-1]->LIBELLE;
                }
            }
            else{
                $libelleSecondaires ="";
            }

            ?>

            <tr>
                <td>
                    <?= $creneau ?>
                </td>
                <td>
                    <?= "{$i->ADN} {$i->ADP}" ?>
                </td>
                <td>
                    Adhérent
                </td>
                <td>
                    <?=$libelle?>
                </td>
                <td>
                    <?=$libelleSecondaires?>
                </td>
                <td>
                    <?php
                    echo"$i->TELEPHONE";
                    ?>
                </td>
                <td>
                    <?= "{$i->MONTANT} €"?>
                </td>

                <td><a href="<?=
                    $redirect;
                    ?>"><button class="btn btn-primary">Gérer</button></a></td>

            </tr>
            <?php
            $dateP=date_format($date, 'd-m-Y').' - '.substr($i->HEURE_CRENEAU, 0, -3);

            if(!empty($i->INN)) {
                foreach (range(0, (count(explode("<br>", $i->INN)) - 1)) as $n) {

                    $nom = explode("<br>", $i->INN)[$n];
                    $libellePresta='';
                    $libellePrestaSec='';
//                        var_dump($i);
//                        var_dump($prestation);
//                        var_dump($prestationIA);
                    foreach ($prestationIA as $presta) {
                        $nominvite = "$presta->NOM $presta->PRENOM";
                        if($nominvite == $nom) {
                            $libellePresta = $prestation[($presta->PRESTATION-1)]->LIBELLE;
                            if($presta->PrestationSecondaire1!=null) {
                                if($presta->PrestationSecondaire2!=null) {
                                    $libellePrestaSec = $prestation[($presta->PrestationSecondaire1)-1]->LIBELLE . "<br>" . $prestation[($presta->PrestationSecondaire2)-1]->LIBELLE;
                                }
                                else{
                                    $libellePrestaSec = $prestation[($presta->PrestationSecondaire1)-1]->LIBELLE;
                                }
                            }
                            else{
                                $libellePrestaSec ="";
                            }
                        }
                    }
                    echo "<td>$dateP</td><td>$nom</td>
<td>$i->ADN $i->ADP</td>";
                    echo "<td>$libellePresta</td><td>$libellePrestaSec</td><td></td><td></td></tr>";


                }
            }
            $cren=$creneau;
        }
        echo "</table>";
        }?>

