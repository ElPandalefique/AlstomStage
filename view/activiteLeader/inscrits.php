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
            foreach ($effectifs as $eff){
                $format = date_create($eff->DATE_CRENEAU);
                $date = date_format($format, 'd-m-Y');
                $heure = substr($eff->HEURE_CRENEAU, 0, -3);
                $effectif=$eff->effectif;
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
            <td>Téléphone</td>
            <td>Montant</td>
            <td>Gérer</td>
        </tr>

        <?php if (!empty($inscrits)) {
//            var_dump($inscrits);
            $count = 0;
            foreach ($inscrits as $i){
//                var_dump($i);
                $date = date_create($i->DATE_CRENEAU);
                $redirect=BASE_URL . '/activiteLeader/gerer/' . $i->ID;
                $c=0;
                $libelle = $prestation[($i->PRESTATION-1)]->LIBELLE;
//                var_dump($prestation);
//                foreach ($prestationI as $presta){
//                    if($c==$count){
//                        $libelleI = $presta->LIBELLE;
//                    }
//                    var_dump($count);
//                    $c+=1;
//                }


                ?>

                <tr>
                    <td>
                        <?= date_format($date, 'd-m-Y').' - '.substr($i->HEURE_CRENEAU, 0, -3) ?>
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
                        <?php
//                        var_dump($i->INN);
//                        $test = count(explode("<br>",$i->INN));
//                        var_dump($test);
//                        echo"prestationI";
//                        var_dump($prestationI);
                      /*  var_dump($prestationI);
                        foreach(range(0,(count(explode("<br>",$i->INN))-1)) as $n) {
                            $c=0;

                            foreach ($prestationI as $presta){
                                echo 'n';
                                var_dump($n);
                                echo 'c';
                                var_dump($c);


                                if($c==$n && isset(explode("<br>",$i->INN)[$n])){
                                    echo "presta n°$c";
                                    $libelleI=$prestation[($presta->PRESTATION-1)]->LIBELLE;
                                    var_dump($presta);
                                    $nom=explode("<br>",$i->INN)[$n];
                                    echo "$nom ($libelleI)<br>";
                                }
//                                var_dump($n);
//                                var_dump($c);
                                $c+=1;
                            }
                        }*/
                        $i->TELEPHONE;
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
//                        var_dump($i->INN);
//                        $test = count(explode("<br>",$i->INN));
//                        var_dump($test);
//                        echo"prestationI";
//                        var_dump($prestationI);
                $dateP=date_format($date, 'd-m-Y').' - '.substr($i->HEURE_CRENEAU, 0, -3);

//                  var_dump($prestationI);
                  if(!empty($i->INN)) {
                      foreach (range(0, (count(explode("<br>", $i->INN)) - 1)) as $n) {

                          $nom = explode("<br>", $i->INN)[$n];
                          $libellePresta='';
                          foreach ($prestationI as $presta) {
                              $nominvite = "$presta->NOM $presta->PRENOM";
//                              echo 'nominvite';
//                              var_dump($nominvite);
//                              echo 'nom';
//                              var_dump($nom);
//                              echo 'c';
//                              var_dump($c);
                              if($nominvite == $nom) {
//                                  echo 'nominvite';
//                                  var_dump($nominvite);
//                                  echo 'nom';
//                                  var_dump($nom);
                                  $libellePresta = $prestation[($presta->PRESTATION-1)]->LIBELLE;
//                                  echo 'libellePresta';
//                                  var_dump($libellePresta);
                              }

                          }


                          echo "<td>$dateP</td><td>$nom</td>
<td>$i->ADN $i->ADP</td>";
                          echo "<td>$libellePresta</td><td></td><td>$i->MONTANT €</td></tr>";


                      }
                  }
                ?>

                <?php $count+=1;}} ?>
    </table>
    <?php if (!empty($inscritsA)) { ?>
    <table class="table table-bordered table-condensed table-striped">
        <!-- entête tableau -->
        <th>Liste d'attente</th>
        <tr>
            <td>Créneau</td>
            <td>Adhérent lié</td>
            <td>Participe-t-il ?</td>
            <td>Invités</td>
            <td>Montant</td>
            <td>Gérer</td>
        </tr>


        <?php foreach ($inscritsA as $i){
            $date = date_create($i->DATE_CRENEAU);
            $redirect=BASE_URL . '/activiteLeader/gererAttente/' . $i->ID;
            ?>

            <tr>
                <td>
                    <?= date_format($date, 'd-m-Y').' - '.substr($i->HEURE_CRENEAU, 0, -3) ?>
                </td>
                <td>
                    <?= "{$i->ADN} {$i->ADP}" ?>
                </td>
                <td>
                    <?= $i->AUTO_PARTICIPATION == 1 ? 'Oui' : 'Non' ;?>
                </td>
                <td>
                    <?= $i->INN ?>
                </td>
                <td>
                    <?= "{$i->MONTANT}€"?>
                </td>

                <td><a href="<?=
                    $redirect;
                    ?>"><button class="btn btn-primary">Gérer</button></a></td>

            </tr>


        <?php }
        echo "</table>";
        } ?>

