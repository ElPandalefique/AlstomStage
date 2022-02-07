<?php if (empty($inscription)) { ?>
    <form class="form-horizontal" method="post"
          action="<?= BASE_URL ?>/activite/inscriptionActivite/<?= $donnees->ID_ACTIVITE ?>">
        <fieldset>

            <!-- Form Name -->
            <legend>Formulaire d'Inscription à une Activité</legend>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-2 control-label" for="textinput">Nom de l'activité</label>
                <div class="col-md-3">
                    <input id="NOM" name="NOM" placeholder="NOM" readonly="yes" class="form-control input-md"
                           type="text"
                           value="<?= (isset($donnees->NOM) ? $donnees->NOM : '') ?>">
                </div>
            </div>


            <br>
            Séléctionnez les participants
            <?php
            //        var_dump($invitesfamille);
            //        var_dump($prestation);
            ?>

            <div class="prestation form-group" id="participations">
                <div class="participation">
                    <hr>
                    <label class="control-label" for="textinput">Participation</label>
                    <br>
                    <strong>Participant:</strong>
                    <select onchange="calculMontantLive()"  name="participant[]">
                        <option id="AUTO_PARTICIPATION" value="AUTO_PARTICIPATION"><?= $_SESSION['NOM'] . ' ' . $_SESSION['PRENOM'] ?></option>
                        <?php if (isset($invitesfamille)) {

                            foreach ($invitesfamille as $invite) {

                                // Vérification Enfant
                                //if (!(ActiviteController::getAge($invite->DATE_NAISSANCE) <= $donnees->AGE_MINIMUM)) {

                                ?>
                                <option id="<?= ActiviteController::getAge($invite->DATE_NAISSANCE) < 18 ? 'enfant' : 'adulte' ?>"  value=<?= $invite->ID_PERS_EXTERIEUR; ?>><?= $invite->NOM ?> <?= $invite->PRENOM ?></option>
                                <?php //}
                            }
                        }
                        if ($donnees->OUVERT_EXT == 1) {
                            if (isset($invitesext)) {

                                foreach ($invitesext as $invite) {
                                    //if (!(ActiviteController::getAge($invite->DATE_NAISSANCE) <= $donnees->AGE_MINIMUM)) {

                                    ?>
                                    <option id="<?= ActiviteController::getAge($invite->DATE_NAISSANCE) < 18 ? 'enfant' : 'adulte' ?>"  value=<?= $invite->ID_PERS_EXTERIEUR; ?>><?= $invite->NOM ?> <?= $invite->PRENOM ?></option>
                                    <?php //}
                                }
                            }
                        }?>
                    </select>
                    <br>
                    <strong>Prestation principale:</strong>
                    <select onchange="calculMontantLive()"  name="prestationprincipale[]">
                        <?php
                        foreach ($prestationP as $presta) {
                            echo "<option id=\"$presta->ID_PRESTATION\" value=\"$presta->ID_PRESTATION\">$presta->LIBELLE</option>";
                        }
                        echo "</select>";
                        if(isset($prestationS)) {
                            echo "
<div class = \"PrestationSecondaire\">
<strong>Prestation(s) Secondaire(s)</strong>
<select name =\"prestationSecondaire0[]\">
<option value=\"none\">--aucune--</option>
";
                            foreach ($prestationS as $presta) {
                                echo "<option id=\"$presta->ID_PRESTATION\" value=\"$presta->ID_PRESTATION\">$presta->LIBELLE</option>";
                            }
                            echo"</select>
<input type=\"button\" value=\"Ajouter\" onclick=\"addPrestationSecondaire()\">
            <input type=\"button\" value=\"Supprimer\" onclick=\"removePrestationSecondaire();\"></div>
";
                        }
                        ?>

                </div>
            </div>



            <!--</div>-->
            <input type="button" value="Ajouter une participation" onclick="addParticipation()">
            <input type="button" value="Supprimer une participation" onclick="removeParticipation();">


            <div id="live_montant">Montant : <?= $donnees->PRIX_ADULTE ?> €</div>

            <br>
            Choix du créneau
            <hr>

            <p style="color:#FF0000"><strong>Si un créneau ne s'affiche pas dans le tableau, c'est que l'effectif de ce dernier est vide</strong></p>
            <table class="table table-bordered table-condensed table-striped">
                <th>Effectifs des créneaux</th>
                <tr>
                    <td>Créneau</td>
                    <td>Effectif actuel</td>
                    <td>Personnes en liste d'attente</td>
                </tr>
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
                        echo"<tr><td> Le $date à $heure</td><td>$effectif / $eff->EFFECTIF_CRENEAU</td><td>$attentes</td>";
                    }
                }
                ?>
            </table>

            <div class="form-group">
                <label class="col-md-2 control-label" for="textinput">Créneau :</label>
                <div class="col-md-3" id="creneau">

                    <select name="CRENEAU" id="creneau">

                        <?php if (!empty($creneaux)) {
                            foreach ($creneaux as $creneau):
                                $date = date_create($creneau->DATE_CRENEAU);
                                ?>

                                <option value="<?= $creneau->NUM_CRENEAU ?>"><?= 'Le ' . date_format($date, 'd-m-Y') . ' à ' . substr($creneau->HEURE_CRENEAU, 0, -3) ?></option>
                            <?php endforeach;
                        } else {
                            ?>
                            <option selected disabled value="">Il n'y a pas de créneau pour le moment.</option>
                            <?php

                        } ?>
                    </select>
                </div>

            </div>


            <td>
                <?php if (!empty($creneaux)) {
//                    echo "creneaux";
//                    var_dump($creneaux);
//                    echo "prix adulte";
//                    var_dump( $donnees->PRIX_ADULTE);
//                    echo "invites famille";
//                    var_dump($invitesfamille);
//                    echo "invites externe";
//                    var_dump($invitesext);
//                    echo "id activité";
//                    var_dump($donnees->ID_ACTIVITE);?>
                    <button id="singlebutton" name="singlebutton" class="btn btn-info">S'inscrire</button>
                <?php } else { ?>
                    <button disabled id="singlebutton" name="singlebutton" class="btn btn-info">S'inscrire</button>
                <?php } ?>
            </td>

        </fieldset>
    </form>


<?php } else { ?>

    <form class="form-horizontal" method="post"
          action="<?= BASE_URL ?>/activite/modificationActivite/<?= $donnees->ID_ACTIVITE ?>">
        <fieldset>

            <!-- Form Name -->
            <legend>Formulaire d'Inscription à une Activité</legend>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-2 control-label" for="textinput">Nom de l'activité</label>
                <div class="col-md-3">
                    <input id="NOM" name="NOM" placeholder="NOM" readonly="yes" class="form-control input-md"
                           type="text"
                           value="<?= (isset($donnees->NOM) ? $donnees->NOM : '') ?>">
                </div>
            </div>


            <br>
            <h4>Vous êtes déjà inscrit. Vous pouvez tout de même choisir de participer à l'activité, ou ajouter des participants</h4>
            Séléctionnez les participants
            <?php
            //        var_dump($invitesfamille);
            //        var_dump($prestation);
            ?>

            <div class="prestation form-group" id="participations">
                <?php
                if(!empty($inscrits)) {
                $count = 0;
                var_dump($inscrits);
                foreach ($inscrits as $i) {
//                var_dump($i);

                ?>
                <div class="participation">
                    <hr>
                    <label class="control-label" for="textinput">Participation</label>
                    <br>
                    <strong>Participant:</strong>
                    <select onchange="calculMontantLive()"  name="participant[]">
                        <option id="AUTO_PARTICIPATION" value="AUTO_PARTICIPATION"><?= $_SESSION['NOM'] . ' ' . $_SESSION['PRENOM'] ?></option>
                        <?php if (isset($invitesfamille)) {

                            foreach ($invitesfamille as $invite) {

                                ?>
                                <option id="<?= ActiviteController::getAge($invite->DATE_NAISSANCE) < 18 ? 'enfant' : 'adulte' ?>"  value=<?= $invite->ID_PERS_EXTERIEUR; ?>><?= $invite->NOM ?> <?= $invite->PRENOM ?></option>
                                <?php
                            }
                        }
                        if ($donnees->OUVERT_EXT == 1) {
                            if (isset($invitesext)) {

                                foreach ($invitesext as $invite) {

                                    ?>
                                    <option id="<?= ActiviteController::getAge($invite->DATE_NAISSANCE) < 18 ? 'enfant' : 'adulte' ?>"  value=<?= $invite->ID_PERS_EXTERIEUR; ?>><?= $invite->NOM ?> <?= $invite->PRENOM ?></option>
                                    <?php
                                }
                            }
                        }?>
                    </select>
                    <br>
                    <strong>Prestation principale:</strong>
                    <select onchange="calculMontantLive()" value="0" name="prestationprincipale[]">
                        <?php
                        foreach ($prestationP as $presta) {
                            if($presta->ID_PRESTATION==$i->PRESTATION)
                                echo "<option selected=\"selected\" id=\"$presta->ID_PRESTATION\" value=\"$presta->ID_PRESTATION\">$presta->LIBELLE</option>";
                            else
                                echo "<option id=\"$presta->ID_PRESTATION\" value=\"$presta->ID_PRESTATION\">$presta->LIBELLE</option>";
                        }
                        echo "</select>";
                        if(isset($prestationS)) {
                            echo "
<div class = \"PrestationSecondaire\">
<strong>Prestation(s) Secondaire(s)</strong>
<select name =\"prestationSecondaire0[]\">
<option value=\"none\">--aucune--</option>
";
                            foreach ($prestationS as $presta) {
                                echo "<option id=\"$presta->ID_PRESTATION\" value=\"$presta->ID_PRESTATION\">$presta->LIBELLE</option>";
                            }
                            echo"</select>
<input type=\"button\" value=\"Ajouter\" onclick=\"addPrestationSecondaire()\">
            <input type=\"button\" value=\"Supprimer\" onclick=\"removePrestationSecondaire();\"></div>
";
                        }
                }

                if($invites[0]->ID_INVITE != null)
                        foreach ($invites as $i) {


                        ?>
                    </select>
                </div>
                        <div class="participation">
                            <hr>
                            <label class="control-label" for="textinput">Participation</label>
                            <br>
                            <strong>Participant:</strong>
                            <select onchange="calculMontantLive()"  name="participant[]">
                                <option id="AUTO_PARTICIPATION" value="AUTO_PARTICIPATION"><?= $_SESSION['NOM'] . ' ' . $_SESSION['PRENOM'] ?></option>
                                <?php if (isset($invitesfamille)) {

                                    foreach ($invitesfamille as $invite) {
                                        if(ActiviteController::getAge($invite->DATE_NAISSANCE) < 18)
                                        $id='enfant';
                                        else
                                        $id='adulte';

                                        if($invite->ID_PERS_EXTERIEUR == $i->ID_INVITE)
                                        echo"<option id=\"$id\" selected='selected' value=$invite->ID_PERS_EXTERIEUR>$invite->NOM $invite->PRENOM</option>";
                                        else
                                            echo"<option id=\"$id\" value=$invite->ID_PERS_EXTERIEUR>$invite->NOM $invite->PRENOM</option>";

                                    }
                                }
                                if ($donnees->OUVERT_EXT == 1) {
                                    if (isset($invitesext)) {

                                        foreach ($invitesext as $invite) {

                                            ?>
                                            <option id="<?= ActiviteController::getAge($invite->DATE_NAISSANCE) < 18 ? 'enfant' : 'adulte' ?>"  value=<?= $invite->ID_PERS_EXTERIEUR; ?>><?= $invite->NOM ?> <?= $invite->PRENOM ?></option>
                                            <?php
                                        }
                                    }
                                }?>
                            </select>
                            <br>
                            <strong>Prestation principale:</strong>
                            <select onchange="calculMontantLive()" value="0" name="prestationprincipale[]">
                                <?php
                                foreach ($prestationP as $presta) {
                                    if($presta->ID_PRESTATION==$i->PRESTATION)
                                        echo "<option selected=\"selected\" id=\"$presta->ID_PRESTATION\" value=\"$presta->ID_PRESTATION\">$presta->LIBELLE</option>";
                                    else
                                        echo "<option id=\"$presta->ID_PRESTATION\" value=\"$presta->ID_PRESTATION\">$presta->LIBELLE</option>";
                                }
                                echo "</select>";
                                if(isset($prestationS)) {
                                    echo "
<div class = \"PrestationSecondaire\">
<strong>Prestation(s) Secondaire(s)</strong>
<select name =\"prestationSecondaire0[]\">
<option value=\"none\">--aucune--</option>
";
                                    foreach ($prestationS as $presta) {
                                        echo "<option id=\"$presta->ID_PRESTATION\" value=\"$presta->ID_PRESTATION\">$presta->LIBELLE</option>";
                                    }
                                    echo"</select>
<input type=\"button\" value=\"Ajouter\" onclick=\"addPrestationSecondaire()\">
            <input type=\"button\" value=\"Supprimer\" onclick=\"removePrestationSecondaire();\"></div>
";
                                }
                                }
                }

                        ?>

                </div>
            </div>

            <!--</div>-->
            <input type="button" value="Ajouter une participation" onclick="addParticipation()">
            <input type="button" value="Supprimer une participation" onclick="removeParticipation();">


            <div id="live_montant">Montant : <?= $donnees->PRIX_ADULTE ?> €</div>

            <br>
            Choix du créneau
            <hr>

            <p style="color:#FF0000"><strong>Si un créneau ne s'affiche pas dans le tableau, c'est que l'effectif de ce dernier est vide</strong></p>
            <table class="table table-bordered table-condensed table-striped">
                <th>Effectifs des créneaux</th>
                <tr>
                    <td>Créneau</td>
                    <td>Effectif actuel</td>
                    <td>Personnes en liste d'attente</td>
                </tr>
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
                        echo"<tr><td> Le $date à $heure</td><td>$effectif / $eff->EFFECTIF_CRENEAU</td><td>$attentes</td>";
                    }
                }
                ?>
            </table>

            <div class="form-group">
                <label class="col-md-2 control-label" for="textinput">Créneau :</label>
                <div class="col-md-3" id="creneau">

                    <select name="CRENEAU" id="creneau">

                        <?php if (!empty($creneaux)) {
                            foreach ($creneaux as $creneau):
                                $date = date_create($creneau->DATE_CRENEAU);
                                ?>

                                <option value="<?= $creneau->NUM_CRENEAU ?>"><?= 'Le ' . date_format($date, 'd-m-Y') . ' à ' . substr($creneau->HEURE_CRENEAU, 0, -3) ?></option>
                            <?php endforeach;
                        } else {
                            ?>
                            <option selected disabled value="">Il n'y a pas de créneau pour le moment.</option>
                            <?php

                        } ?>
                    </select>
                </div>

            </div>


            <td>
                <?php if (!empty($creneaux)) {
//                    echo "creneaux";
//                    var_dump($creneaux);
//                    echo "prix adulte";
//                    var_dump( $donnees->PRIX_ADULTE);
//                    echo "invites famille";
//                    var_dump($invitesfamille);
//                    echo "invites externe";
//                    var_dump($invitesext);
//                    echo "id activité";
//                    var_dump($donnees->ID_ACTIVITE);?>
                    <button id="singlebutton" name="singlebutton" class="btn btn-info">Valider les modifications</button>
                <?php } else { ?>
                    <button disabled id="singlebutton" name="singlebutton" class="btn btn-info">Valider les modifications</button>
                <?php } ?>
            </td>

        </fieldset>
    </form>


    <?php
}
//var_dump($creneaux);?>
<td>
    <button id="singlebutton" name="singlebutton" class="btn btn-info"
            onclick="window.location.href = '../../activite/listerActivite'">Annuler
    </button>
</td>

<script>
    var count = 1;
    function addInscriptionInput(type) {
        // type sera égal à "famille" où à "ext"
        let formContainer = document.getElementById("invites" + type);
        let baseSelectInput = document.getElementsByClassName("participant" + type)
        let base = baseSelectInput[0];
        formContainer.insertAdjacentHTML('beforeend', base.outerHTML);

    }

    function addPrestationSecondaire() {
        let formContainer = document.getElementById("participations");
        let baseSelectInput = document.getElementsByClassName("PrestationSecondaire");
        let base = baseSelectInput[0];
        formContainer.insertAdjacentHTML('beforeend', base.outerHTML);
    }

    function removePrestationSecondaire(){
        // type sera égal à "famille" où à "ext"
        let baseSelectInput = document.getElementsByClassName("PrestationSecondaire")
        if(baseSelectInput.length < 2){
            // baseSelectInput[0].value = 'none';
        }else{
            let latestInput = baseSelectInput[baseSelectInput.length - 1];
            latestInput.remove();
            count-=1;
        }
        document.getElementById("click").innerHTML = count;
        //calculMontantLive();
    }

    function addParticipation() {
        // type sera égal à "famille" où à "ext"
        let formContainer = document.getElementById("participations");
        let baseSelectInput = document.getElementsByClassName("participation");
        let base = baseSelectInput[0];
        formContainer.insertAdjacentHTML('beforeend', base.outerHTML);
    }

    function removeParticipation(){
        // type sera égal à "famille" où à "ext"
        let baseSelectInput = document.getElementsByClassName("participation")
        if(baseSelectInput.length < 2){
            //baseSelectInput[0].value = 'none';
        }else{
            let latestInput = baseSelectInput[baseSelectInput.length - 1];
            latestInput.remove();
        }
        //calculMontantLive();
    }

    function removeInscriptionInput(type){
        // type sera égal à "famille" où à "ext"
        let baseSelectInput = document.getElementsByClassName("participant" + type)
        if(baseSelectInput.length < 2){
            baseSelectInput[0].value = 'none';
        }else{
            let latestInput = baseSelectInput[baseSelectInput.length - 1];
            latestInput.remove();
        }
        calculMontantLive();
    }
    <?php if(isset($donnees->PRIX_ADULTE))
        echo "let prix_adulte = $donnees->PRIX_ADULTE" ;
    if(isset($donnees->PRIX_ADULTE_EXT))
        echo"let prix_adulte_ext = $donnees->PRIX_ADULTE_EXT";
    if(isset($donnees->PRIX_ENFANT))
        echo"let prix_enfant = $donnees->PRIX_ENFANT" ;
    if(isset($donnees->PRIX_ENFANT_EXT))
        echo"let prix_enfant_ext = $donnees->PRIX_ENFANT_EXT" ;
    ?>


    function calculMontantLive(){
        let auto_participation = document.getElementById('AUTO_PARTICIPATION');
        let extSelectInput = document.getElementsByClassName("participantext");
        let familleSelectInput = document.getElementsByClassName("participantfamille");

        let montant = 0;

        <?php if(isset($inscription->MONTANT)){?>
        montant = <?= $inscription->MONTANT ?>
        <?php }  ?>

        if(auto_participation.value == 1){
            if(auto_participation[auto_participation.selectedIndex].id == 'ap'){

            }else{
                montant += prix_adulte;
            }

        }
        for(var i = 0; i < extSelectInput.length; i++){
            if(extSelectInput[i].value == 'none'){

            }else{
                if(extSelectInput[i][extSelectInput[i].selectedIndex].id == 'enfant'){
                    montant += prix_enfant_ext;
                }else{
                    montant += prix_adulte_ext;
                }
            }

        }
        for(var i = 0; i < familleSelectInput.length; i++){
            if(familleSelectInput[i].value == 'none'){

            }else{
                if(familleSelectInput[i][familleSelectInput[i].selectedIndex].id == 'enfant'){
                    montant += prix_enfant;
                }else {
                    montant += prix_adulte;
                }
            }
        }

        let divAffichageMontant = document.getElementById('live_montant');
        divAffichageMontant.innerHTML = 'Montant : ' + montant + " €";

    }

</script>
