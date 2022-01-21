<form class="form-horizontal" method="post" action="<?= BASE_URL ?>/activiteLeader/nouveau">

    <fieldset>

        <!-- Form Name -->
        <legend>Activité</legend>
        <!-- Text input-->
        Leader en charge de l'activité :
        <br>
        <br>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Nom :</label>
            <div class="col-md-4">
                <input id="NOM_LEADER" name="NOM_LEADER" placeholder="Nom du Leader" class="form-control input-md"
                       type="NOM_LEADER" value="<?= (isset($_SESSION['NOM']) ? $_SESSION['NOM'] : 'ERREUR') ?>"
                       readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Prénom :</label>
            <div class="col-md-4">
                <input id="PRENOM_LEADER" name="PRENOM_LEADER" placeholder="Prénom du leader"
                       class="form-control input-md" type="PRENOM_LEADER"
                       value="<?= (isset($_SESSION['PRENOM']) ? $_SESSION['PRENOM'] : 'ERREUR') ?>" readonly>
            </div>
        </div>
        <hr>
        Détail de l'activité
        <br>
        <br>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Nom de l'activité <span class="important">*</span>
                :</label>
            <div class="col-md-4">
                <input id="NOM" name="NOM" placeholder="Nom de l'activité" class="form-control input-md" type="text"
                       value="<?= (isset($activite->NOM) ? $activite->NOM : '') ?>" required>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Détail :</label>
            <div class="col-md-4">
                <textarea id="DETAIL" name="DETAIL" placeholder="Détail" class="form-control input-md" type="text"
                          value="<?= (isset($activite->DETAIL) ? $activite->DETAIL : '') ?>"></textarea>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Adresse <span class="important">*</span> :</label>
            <div class="col-md-4">
                <input id="ADRESSE" name="ADRESSE" placeholder="ADRESSE" class="form-control input-md" type="text"
                       value="<?= (isset($activite->ADRESSE) ? $activite->ADRESSE : '') ?>" required>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Code Postal <span class="important">*</span> :</label>
            <div class="col-md-4">
                <input id="CP" name="CP" placeholder="CP" class="form-control input-md" type="text"
                       value="<?= (isset($activite->CP) ? $activite->CP : '') ?>" required>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Ville <span class="important">*</span> :</label>
            <div class="col-md-4">
                <input id="VILLE" name="VILLE" placeholder="VILLE" class="form-control input-md" type="text"
                       value="<?= (isset($activite->VILLE) ? $activite->VILLE : '') ?>" required>

            </div>
        </div>


        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Indications aux participants :</label>
            <div class="col-md-4">
                <textarea id="INDICATION_PARTICIPANT" name="INDICATION_PARTICIPANT" placeholder="INDICATION_PARTICIPANT"
                          class="form-control input-md" type="text"
                          value="<?= (isset($activite->INDICATION_PARTICIPANT) ? $activite->INDICATION_PARTICIPANT : '') ?>"></textarea>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Informations importantes aux participants :</label>
            <div class="col-md-4">
                <textarea id="INFO_IMPORTANT_PARTICIPANT" name="INFO_IMPORTANT_PARTICIPANT"
                          placeholder="INFO_IMPORTANT_PARTICIPANT" class="form-control input-md" type="text"
                          value="<?= (isset($activite->INFO_IMPORTANT_PARTICIPANT) ? $activite->INFO_IMPORTANT_PARTICIPANT : '') ?>"></textarea>
            </div>
        </div>


        <hr>
        Le prestataire :

        <br>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Choix du prestataire :</label>
            <div class="col-md-4">
                <select name="ID_PRESTATAIRE">
                    <?php if (isset($prestataires)) {
                        foreach ($prestataires as $p): ?>
                            <option value=<?= $p->ID; ?>><?= $p->NOM ?></option>
                        <?php endforeach;
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Type Tarif <span class="important">*</span> :</label>
            <div class="col-md-4">
                <select name="TYPE_FORFAIT" id="TYPE_FORFAIT" value="0" required onchange="changeForfait()">
                    <option value='U'>Unitaire</option>
                    <option value='F'>Forfait</option>
                </select>
            </div>
        </div>


        <!-- Si l'on séléctionne le mode Unitaire (par défaut) : required="required" -->
        <div id="prestation_principale" name = "prestation_principale">

            <div class="form-group" id="libelle">
                <label class="col-md-2 control-label" for="textinput">Prestation<span class="important">*</span> :</label>

                <div class="col-md-4">
                    <input id="Prestation" name="Prestation" placeholder="Intitulé de la prestation" class="prestation"
                           type="text" value="<?= (isset($activite->prestation) ? $activite->prestation : '') ?>">
                </div>

            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="textinput">Coût<span class="important">*</span> :</label>

                <div class="col-md-4">
                    <input id="COUT" name="COUT" placeholder="Coût" class="form-control input-md"
                           type="number" value="<?= (isset($activite->COUT) ? $activite->COUT : '') ?>">
                </div>

            </div>

            <div class="form-group">
                <label class="col-md-2 control-label" for="textinput">Âge minimum :</label>

                <div class="col-md-4">
                    <input id="AGE_MIN" name="AGE_MIN" placeholder="Âge minimum" class="form-control input-md"
                           type="number" value="<?= (isset($activite->AGE_MIN) ? $activite->AGE_MIN : '') ?>">
                </div>

            </div>

            <div class="form-group">

                <label class="col-md-2 control-label" for="textinput">Âge maximum :</label>
                <div class="col-md-4">
                    <input id="AGE_MAX" name="AGE_MAX" placeholder="Âge maximum" class="form-control input-md"
                           type="number" value="<?= (isset($activite->AGE_MAX) ? $activite->AGE_MAX : '') ?>">
                </div>

            </div>

            <div class="form-group">

                <label class="col-md-2 control-label" for="textinput">adhérent / externe <span class="important">*</span>
                    :</label>
                <div class="col-md-1">
                    <input id="OUVERT_ENFANT_OUI" name="OUVERT_EXTERNE" type="radio" value="0" checked onclick="ouvertEnfants();">
                    <label for="OUVERT_ENFANT">adhérent (+famille)</label>
                </div>

                <div class="col-md-1">
                    <input id="OUVERT_ENFANT_NON" name="OUVERT_EXTERNE" type="radio" value="1" onclick="ouvertEnfants();">
                    <label for="OUVERT_ENFANT">externe</label>
                </div>
            </div>

        </div>


        <input type="button" onClick="addPrestationInput()" value="Ajout prestation principale">

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="singlebutton"></label>
            <div class="col-md-4">
                <button id="singlebutton" name="singlebutton" class="btn btn-info" type="submit">Créer</button>
            </div>
        </div>



    </fieldset>
</form>


<div id="getText" style="display: none;">
    INNER TEXT
</div>

<script>

function addPrestationInput() {
        // type sera égal à "famille" où à "ext"
        let formContainer = document.getElementById("prestation_principale");
        //let formContainer = document.getElementById("prestation_principale");
        //let baseSelectInput = document.getElementsByClassName("prestation")
        //let base = baseSelectInput[0];
        formContainer.insertAdjacentHTML('beforeend', formContainer.outerHTML);

    }

    function createDiv() {
        let formContainer = document.getElementById("getText");
        let div = document.createElement('div');
        div.innerHTML = document.getElementById('getText').innerHTML;
        formContainer.insertAdjacentHTML('beforeend', div.innerHTML);
    }

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