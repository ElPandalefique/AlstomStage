<form class="form-horizontal" method="post" action="<?= BASE_URL ?>/activiteLeader/nouveau">
<body onLoad="InitSecondaire()"></body>

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
            <label class="col-md-2 control-label" title="Sélectionnez le prestataire de votre activité" for="textinput">Choix du prestataire :</label>
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
            <label class="col-md-2 control-label" title="Sélectionnez le type de tarif pour votre activité" for="textinput">Type Tarif <span class="important">*</span> :</label>
            <div class="col-md-4">
                <select name="TYPE_FORFAIT" id="TYPE_FORFAIT" value="0" required onchange="changeForfait()">
                    <option value='U'>Unitaire</option>
                    <!--<option value='F'>Forfait</option>-->
                </select>
            </div>
        </div>

        <p style="color:#FF0000"><strong>Pour avoir des informations sur les données à entrer pour les prestations, passez simplement votre souris sur le champ en question, une bulle informative s'affichera</strong></p>
        <!-- Si l'on séléctionne le mode Unitaire (par défaut) : required="required" -->
        <div id="prestation_principale"  name = "prestation_principale" class = "prestation_principale d-inline-block">
            <br>Prestation principale n°1
            <div class = "prestation">

                <?php //if(isset($prestation)){
                //ajouter des séparations
                //ajouter bouton pour supprimer
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">Prestation<span class="important">*</span> :</label>

                    <div class="col-md-4">
                        <input id="Libelle" title ="Entrez l'intitulé de la prestation, donner un nom qui indique clairement et facilement son contenu" name="Libelle[]" placeholder="Intitulé de la prestation" class="libelle"
                               type="textinput" value="<?= (isset($activite->prestation) ? $activite->prestation : '') ?>"required>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">Coût<span class="important">*</span> :</label>

                    <div class="col-md-4">
                        <input id="COUT" name="COUT[]" title="Entrez le coût de la prestation" placeholder="Coût" class="form-control input-md"
                               type="number" value="<?= (isset($activite->COUT) ? $activite->COUT : '') ?>"required>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">Âge minimum :</label>

                    <div class="col-md-4">
                        <input id="AGE_MIN" name="AGE_MIN[]" title="Entrez l'âge minimum requis pour participer à la prestation (0 signifie qu'il n'y a pas d'age minimum limite)" placeholder="Âge minimum" class="form-control input-md"
                               type="number" value="<?= (isset($activite->AGE_MIN) ? $activite->AGE_MIN : '0') ?>">
                    </div>

                </div>

                <div class="form-group">

                    <label class="col-md-2 control-label" for="textinput">Âge maximum :</label>
                    <div class="col-md-4">
                        <input id="AGE_MAX" name="AGE_MAX[]" title="Entrez l'âge maximum requis pour participer à la prestation (99 signifie qu'il n'y a pas d'age maximum limite)" placeholder="Âge maximum" class="form-control input-md"
                               type="number" value="<?= (isset($activite->AGE_MAX) ? $activite->AGE_MAX : '99') ?>">
                    </div>

                </div>
            </div>

            <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">adhérent / externe <span class="important">*</span>
                        :</label>
                    <div class="col-md-1">
                        <input id="OUVERT_EXTERNE0" name="OUVERT_EXTERNE0" title="Si la prestation n'est ouverte qu'aux adhérents d'Alstom et leur famille" type="radio" value="0" checked onclick="ouvertEnfants();">
                        <label for="OUVERT_EXTERNE">adhérent (+famille)</label>
                    </div>

                    <div class="col-md-1">
                        <input id="OUVERT_EXTERNE0" name="OUVERT_EXTERNE0" title="Si la prestation est ouverte aux personnes externes à Alstom" type="radio" value="1" onclick="ouvertEnfants();">
                        <label for="OUVERT_EXTERNE">externe</label>
                    </div>
            </div>
            <?php //} ?>
        </div>

        <input type="button" title="ajouter une prestation principale qui pourra être supprimée plus tard si besoin" onClick="addPrestationInput()" value="Ajout prestation principale">
        <input type="button" title="supprimer la dernière prestation principale entrée" onClick="removePrestationInput()" value="Suppression prestation principale">
                
        <div id="prestation_secondaire"  name = "prestation_secondaire" class = "prestation_secondaire d-inline-block">
            <div class = "prestationsecondaire">

                <?php //if(isset($prestation)){
                //ajouter des séparations
                //ajouter bouton pour supprimer
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">Prestation<span class="important">*</span> :</label>

                    <div class="col-md-4">
                        <input id="LibelleSecondaire" title ="Entrez l'intitulé de la prestation, donner un nom qui indique clairement et facilement son contenu" name="LibelleSecondaire[]" placeholder="Intitulé de la prestation" class="libelle"
                               type="textinput" value="<?= (isset($activite->prestation) ? $activite->prestation : '') ?>"required>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">Coût<span class="important">*</span> :</label>

                    <div class="col-md-4">
                        <input id="COUTSecondaire" name="COUTSecondaire[]" title="Entrez le coût de la prestation" placeholder="Coût" class="form-control input-md"
                               type="number" value="<?= (isset($activite->COUT) ? $activite->COUT : '') ?>"required>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">Âge minimum :</label>

                    <div class="col-md-4">
                        <input id="AGE_MINSecondaire" name="AGE_MINSecondaire[]" title="Entrez l'âge minimum requis pour participer à la prestation (0 signifie qu'il n'y a pas d'age minimum limite)" placeholder="Âge minimum" class="form-control input-md"
                               type="number" value="<?= (isset($activite->AGE_MIN) ? $activite->AGE_MIN : '0') ?>">
                    </div>

                </div>

                <div class="form-group">

                    <label class="col-md-2 control-label" for="textinput">Âge maximum :</label>
                    <div class="col-md-4">
                        <input id="AGE_MAXSecondaire" name="AGE_MAXSecondaire[]" title="Entrez l'âge maximum requis pour participer à la prestation (99 signifie qu'il n'y a pas d'age maximum limite)" placeholder="Âge maximum" class="form-control input-md"
                               type="number" value="<?= (isset($activite->AGE_MAX) ? $activite->AGE_MAX : '99') ?>">
                    </div>

                </div>
            </div>

        
            <?php //} ?>
        </div>
                <div>
        <br>
        <p>pouet pouet</p>
                </div>
        <input type="button" title="ajouter une prestation secondaire qui pourra être supprimée plus tard si besoin" onClick="addPrestationSecondaire()" value="Ajout prestation secondaire">
        <input type="button" title="supprimer la dernière prestation secondaire entrée" onClick="removePrestationSecondaire()" value="Suppression prestation secondaire">

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="singlebutton"></label>
            <div class="col-md-4">
                <button id="singlebutton" name="singlebutton" class="btn btn-info" type="submit">Créer</button>
            </div>
        </div>

</form>

<p>Clicks: <a id="clicks">0</a></p>
<p>Clicksecond: <a id="clicksecond">0</a></p>

<script>

    //Une solution pour ce qui est de la transmission des données et du maintient des boutons radios serait de séparer en trois partie le formulaire,
    //coupant sur le radio qui aura un id défini dans le JS grace au "clicks" qui change a chaque ajout de formulaire

    //Voir https://openclassrooms.com/forum/sujet/cloner-des-elements-en-js-et-les-differencier
    //Simplification de l'idée précédente, besoin cependant de comprendre clairement comment ça marche
    // (pas sûr de comprendre la récupération ni la tronche des données exportées)

    //Pour la récupération des données pour la partie admin/validation il faudra voir pour récupérer les données avec un foreach
    //à voir quoi mettre comme initiation et comment les données seront stockées -->

    //remodelage de la bdd à faire
    //voir pour mettre les prestations dans une autre table, reliée à activite par l'id
    //prestation_id prenant comme valeur "clicks" et non unique
    // parce que la recherche de prestations associées à une activité passera par une requete où les 2 id seront demandés

    var clicks = 2;
    var clicksecond = 1;
    let baseSelectInput = document.getElementsByClassName("prestationsecondaire");
    var secondaire = baseSelectInput[baseSelectInput.length-1];
    secondaire.remove();

    function onClick(s) {
        if(s == "+") {
            clicks += 1;
        }
        else{
            clicks -= 1;
        }
        document.getElementById("clicks").innerHTML = clicks;
    }

    function addPrestationInput() {
        let formContainer = document.getElementById("prestation_principale");
        let baseSelectInput = document.getElementsByClassName("prestation");
        let base = "<div class='prestationajoutee'><hr><br>Prestation principale n°"+clicks+
            baseSelectInput[0].innerHTML +
            "<div class='form-group'>" +
            "<label class='col-md-2 control-label' for='textinput'>adhérent / externe <span class='important'>*</span>:</label> " +
            "<div class='col-md-1'> " +
            "<input id='OUVERT_EXTERNE"+(clicks-1)+"' name='OUVERT_EXTERNE"+(clicks-1)+"' title='Si la prestation n est ouverte qu aux adhérents d Alstom et leur famille' type='radio' value='0' checked onclick='ouvertEnfants();'> " +
            "<label for='OUVERT_EXTERNE'>adhérent (+famille)</label> " +
            "</div> " +
            "<div class='col-md-1'>" +
            "<input id='OUVERT_EXTERNE"+(clicks-1)+"' name='OUVERT_EXTERNE"+(clicks-1)+"' title='Si la prestation est ouverte aux personnes externes à Alstom' type='radio' value='1' onclick='ouvertEnfants();'> " +
            "<label for='OUVERT_EXTERNE'>externe</label>" +
            "</div>" +
            "</fieldset>"+
            "</div>";

        clicks +=1;
        document.getElementById("clicks").innerHTML = clicks;
        formContainer.insertAdjacentHTML('beforeend', base);
    }

    function removePrestationInput(){
        let baseSelectInput = document.getElementsByClassName("prestationajoutee")
        if(baseSelectInput.length >= 1){
            let latestInput = baseSelectInput[baseSelectInput.length-1];
            latestInput.remove();
            clicks-=1;
            document.getElementById("clicks").innerHTML = clicks;
        }
    }

    function addPrestationSecondaire(){
        let formContainer = document.getElementById("prestation_secondaire");
        let base = "<div class='prestationsecondaire'><hr><br>Prestation secondaire n°"+clicksecond+
            secondaire.innerHTML+
            "<div class='form-group'>" +
            "<label class='col-md-2 control-label' for='textinput'>adhérent / externe <span class='important'>*</span>:</label> " +
            "<div class='col-md-1'> " +
            "<input id='OUVERT_EXTERNESecondaire"+(clicksecond-1)+"' name='OUVERT_EXTERNESecondaire"+(clicksecond-1)+"' title='Si la prestation n est ouverte qu aux adhérents d Alstom et leur famille' type='radio' value='0' checked onclick='ouvertEnfants();'> " +
            "<label for='OUVERT_EXTERNESecondaire'>adhérent (+famille)</label> " +
            "</div> " +
            "<div class='col-md-1'>" +
            "<input id='OUVERT_EXTERNESecondaire"+(clicksecond-1)+"' name='OUVERT_EXTERNESecondaire"+(clicksecond-1)+"' title='Si la prestation est ouverte aux personnes externes à Alstom' type='radio' value='1' onclick='ouvertEnfants();'> " +
            "<label for='OUVERT_EXTERNESecondaire'>externe</label>" +
            "</div>" +
            "</fieldset>"+
            "</div>";

        clicksecond +=1;
        document.getElementById("clicksecond").innerHTML = clicksecond;
        formContainer.insertAdjacentHTML('beforeend', base);
    }

    function removePrestationSecondaire(){
        let baseSelectInput = document.getElementsByClassName("prestationsecondaire")
            let latestInput = baseSelectInput[baseSelectInput.length-1];
            latestInput.remove();
            clicksecond-=1;
            document.getElementById("clicksecond").innerHTML = clicksecond;
        
    }

    
    //function InitSecondaire(){
        //let baseSelectInput = document.getElementsByClassName("prestationsecondaire");
        //secondaire = document.getElementsByClassName("prestationsecondaire");
        //let latestInput = baseSelectInput[baseSelectInput.length-1];
        //latestInput.remove();
        
    //}

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