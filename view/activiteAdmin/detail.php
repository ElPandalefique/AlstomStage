<form class="form-horizontal" method="post"
      action="<?= BASE_URL ?>/activiteAdmin/<?= (isset($action) ? 'creer' : 'modifier') ?>/<?= (isset($activite->ID_ACTIVITE) ? $activite->ID_ACTIVITE : '') ?>">

    <fieldset>

        <!-- Form Name -->
        <legend>Activité</legend>

        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Leader de l'activité :</label>
            <div class="col-md-4">
                <input id="LEADER" name="LEADER" placeholder="Leader de l'activité" class="form-control input-md"
                       type="NOM_LEADER"
                       value="<?= (isset($leader->NOMLEADER) ? $leader->NOMLEADER : '') ?> <?= (isset($leader->PRENOMLEADER) ? $leader->PRENOMLEADER : '') ?>"
                       disabled>
            </div>
        </div>

        <hr>
        Détails de l'activité
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
                          ><?= (isset($activite->DETAIL) ? $activite->DETAIL : '') ?></textarea>

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
                          ><?= (isset($activite->INDICATION_PARTICIPANT) ? $activite->INDICATION_PARTICIPANT : '') ?></textarea>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Informations importantes aux participants :</label>
            <div class="col-md-4">
                <textarea id="INFO_IMPORTANT_PARTICIPANT" name="INFO_IMPORTANT_PARTICIPANT"
                          placeholder="INFO_IMPORTANT_PARTICIPANT" class="form-control input-md" type="text"
                          ><?= (isset($activite->INFO_IMPORTANT_PARTICIPANT) ? $activite->INFO_IMPORTANT_PARTICIPANT : '') ?></textarea>
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
                            <option <?= $activite->ID_PRESTATAIRE == $p->ID ? 'selected' : '' ?> value=<?= $p->ID; ?>><?= $p->NOM ?></option>
                        <?php endforeach;
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Type Tarif <span class="important">*</span> :</label>
            <div class="col-md-4">
                <select name="TYPE_FORFAIT" id="TYPE_FORFAIT" required onchange="changeForfait()">
                    <option value='U'<?php if ($activite->FORFAIT == 'U') echo ' selected' ?>>Unitaire</option>
                </select>
            </div>
        </div>


        <!-- Si l'on séléctionne le mode Unitaire (par défaut) : -->
        <div id="prestation_principale"  name = "prestation_principale" class = "prestation_principale">
            <?php
            $count = 0;
            foreach($prestationsPrincipales as $presta){
                $count+=1;
                if($count>1) echo "<div class = 'prestationajoutee'>";
                ?>

                <br>Prestation principale n°<?= $count ?>
                <div class = "prestation">

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="textinput">Prestation<span class="important">*</span> :</label>

                        <div class="col-md-4">
                            <input id="Libelle" title ="Entrez le nom de la prestation" name="Libelle[]" placeholder="Intitulé de la prestation" class="libelle"
                                   type="textinput" value="<?= (isset($presta->LIBELLE) ? $presta->LIBELLE : '') ?>"required>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="textinput">Coût<span class="important">*</span> :</label>

                        <div class="col-md-4">
                            <input id="COUT" name="COUT[]" title="Entrez le coût de la prestation" placeholder="Coût" class="form-control input-md"
                                   type="number" value="<?= (isset($presta->COUT) ? $presta->COUT : '') ?>"required>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="textinput">Âge minimum :</label>

                        <div class="col-md-4">
                            <input id="AGE_MIN" name="AGE_MIN[]" title="Entrez l'âge minimum requis pour participer à la prestation" placeholder="Âge minimum" class="form-control input-md"
                                   type="number" value="<?= (isset($presta->AGEMIN) ? $presta->AGEMIN : '0') ?>">
                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-md-2 control-label" for="textinput">Âge maximum :</label>
                        <div class="col-md-4">
                            <input id="AGE_MAX" name="AGE_MAX[]" title="Entrez l'âge maximum requis pour participer à la prestation" placeholder="Âge maximum" class="form-control input-md"
                                   type="number" value="<?= (isset($presta->AGEMAX) ? $presta->AGEMAX : '99') ?>">
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">adhérent / externe <span class="important">*</span>
                        :</label>
                    <div class="col-md-1">
                        <input id="OUVERT_EXTERNE<?= $count ?>" name="OUVERT_EXTERNE<?= $count ?>" title="Si la prestation n'est ouverte qu'aux adhérents d'Alstom et leur famille" type="radio" value="0" <?php if($presta->OUVERT_EXT==0) echo'checked'; ?> onclick="ouvertEnfants();">
                        <label for="OUVERT_EXTERNE">adhérent (+famille)</label>
                    </div>

                    <div class="col-md-1">
                        <input id="OUVERT_EXTERNE<?= $count ?>" name="OUVERT_EXTERNE<?= $count ?>" title="Si la prestation est ouverte aux personnes externes à Alstom" type="radio" value="1" <?php if($presta->OUVERT_EXT==1) echo'checked'; ?> onclick="ouvertEnfants();">
                        <label for="OUVERT_EXTERNE">externe</label>
                    </div>
                </div>

            <div class="form-group">
                <label class="col-md-2 control-label" for="textinput">Prix Prestation :</label>
                <div class="col-md-4">
                    <input id="PRIX[]" name="PRIX[]" placeholder="Prix de la prestation" class="form-control input-md " title="Prix de la prestation"
                           type="text" value="<?= (isset($presta->PRIX) ? $presta->PRIX : '') ?>">

                </div>
            </div>
                <hr>

                <?php if($count>1) echo "</div>";}?>
        </div>

        <input type="button" onClick="addPrestationInput()" value="Ajout prestation principale">
        <input type="button" onClick="removePrestationInput()" value="Suppression prestation principale">

        <?php if(isset($prestationsSecondaires)){
        echo'<div id="prestation_principale"  name = "prestation_principale" class = "prestation_principale">';
            $count = 0;
            foreach($prestationsSecondaires as $presta){
                $count+=1;
                if($count>1) echo "<div class = 'prestationajoutee'>";
                ?>

                <br>Prestation secondaire n°<?= $count ?>
                <div class = "prestation">

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="textinput">Prestation<span class="important">*</span> :</label>

                        <div class="col-md-4">
                            <input id="LibelleSecondaire" title ="Entrez le nom de la prestation" name="LibelleSecondaire[]" placeholder="Intitulé de la prestation" class="libelle"
                                   type="textinput" value="<?= (isset($presta->LIBELLE) ? $presta->LIBELLE : '') ?>"required>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="textinput">Coût<span class="important">*</span> :</label>

                        <div class="col-md-4">
                            <input id="COUTSecondaire" name="COUTSecondaire[]" title="Entrez le coût de la prestation" placeholder="Coût" class="form-control input-md"
                                   type="number" value="<?= (isset($presta->COUT) ? $presta->COUT : '') ?>"required>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="textinput">Âge minimum :</label>

                        <div class="col-md-4">
                            <input id="AGE_MINSecondaire" name="AGE_MINSecondaire[]" title="Entrez l'âge minimum requis pour participer à la prestation" placeholder="Âge minimum" class="form-control input-md"
                                   type="number" value="<?= (isset($presta->AGEMIN) ? $presta->AGEMIN : '0') ?>">
                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-md-2 control-label" for="textinput">Âge maximum :</label>
                        <div class="col-md-4">
                            <input id="AGE_MAXSecondaire" name="AGE_MAXSecondaire[]" title="Entrez l'âge maximum requis pour participer à la prestation" placeholder="Âge maximum" class="form-control input-md"
                                   type="number" value="<?= (isset($presta->AGEMAX) ? $presta->AGEMAX : '99') ?>">
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">adhérent / externe <span class="important">*</span>
                        :</label>
                    <div class="col-md-1">
                        <input id="OUVERT_EXTERNESecondaire<?= $count ?>" name="OUVERT_EXTERNESecondaire<?= $count ?>" title="Si la prestation n'est ouverte qu'aux adhérents d'Alstom et leur famille" type="radio" value="0" <?php if($presta->OUVERT_EXT==0) echo'checked'; ?> onclick="ouvertEnfants();">
                        <label for="OUVERT_EXTERNESecondaire">adhérent (+famille)</label>
                    </div>

                    <div class="col-md-1">
                        <input id="OUVERT_EXTERNESecondaire<?= $count ?>" name="OUVERT_EXTERNESecondaire<?= $count ?>" title="Si la prestation est ouverte aux personnes externes à Alstom" type="radio" value="1" <?php if($presta->OUVERT_EXT==1) echo'checked'; ?> onclick="ouvertEnfants();">
                        <label for="OUVERT_EXTERNESecondaire">externe</label>
                    </div>
                </div>

                <div class="form-group">
                <label class="col-md-2 control-label" for="textinput">Prix Prestation :</label>
                <div class="col-md-4">
                    <input id="PRIXSecondaire[]" name="PRIXSecondaire[]" placeholder="Prix de la prestation" class="form-control input-md " title="Prix de la prestation"
                           type="text" value="<?= (isset($presta->PRIX) ? $presta->PRIX : '') ?>">

                </div>
            </div>
                <hr>

                <?php if($count>1) echo "</div>";
            }
            echo '</div>';
}?>

        <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Statut <span class="important">*</span> :</label>
            <div class="col-md-4">
                <select name="STATUT">
                    <option value="A"<?php if ($activite->STATUT == "A") {
                        echo "selected";
                    } ?>>1- En attente
                    </option>
                    <option value="V"<?php if ($activite->STATUT == "V") {
                        echo "selected";
                    } ?>>2- Validé
                    </option>
                    <option value="O"<?php if ($activite->STATUT == "O") {
                        echo "selected";
                    } ?>>3- Ouvert
                    </option>
                    <option value="F"<?php if ($activite->STATUT == "F") {
                        echo "selected";
                    } ?>>4- Fermé
                    </option>
                    <option value="T"<?php if ($activite->STATUT == "T") {
                        echo "selected";
                    } ?>>5- Terminé
                    </option>
                </select>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="singlebutton"></label>
            <div class="col-md-4">
                <button id="singlebutton" name="singlebutton" class="btn btn-info">Valider les modifications</button>
            </div>
        </div>
    </fieldset>
</form>


<!-- Ancien form -->
