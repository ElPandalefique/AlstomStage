<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\mailConfig;
require("../core/phpmailer/mailConfig.php");

class ActiviteController extends Controller
{


    //Liste d'attente non fonctionnelle
    /* 
    public function positionListeAttente($numinscription)
    {
        $modActiviteInscrit = $this->loadModel('ActiviteInscrit');
        $req['projection'] = 'INSCRIPTION.ID_ADHERENT, INSCRIPTION.ID_ACTIVITE, INSCRIPTION.CRENEAU';
        $req['conditions'] = 'ID = ' . $numinscription;
        $infosinscription = $modActiviteInscrit->findfirst($req);

        $idactivite = $infosinscription->ID_ACTIVITE;
        $idadherent = $infosinscription->ID_ADHERENT;
        $creneau = $infosinscription->CRENEAU;


        $modActiviteInscritC = $this->loadModel('ActiviteParticipantsLeader');
        $req['projection'] = 'ROW_NUMBER() OVER(ORDER BY INSCRIPTION.ID) AS placeFile, INSCRIPTION.ID_ADHERENT as idadh, INVITE.ID_PERS_EXTERIEUR';
        $req['conditions'] = 'INSCRIPTION.ID_ACTIVITE = ' . $idactivite;
        $inscrits = $modActiviteInscritC->find($req);
        

        // Effectif
        $modActiviteInscritC = $this->loadModel('ActiviteInscriptionCreneau');

        $req['projection'] = 'CRENEAU.EFFECTIF_CRENEAU';
        $req['conditions'] = 'CRENEAU.ID_ACTIVITE = ' . $idactivite . ' AND CRENEAU.NUM_CRENEAU = ' . $creneau;
        $effectif = $modActiviteInscritC->findfirst($req)->EFFECTIF_CRENEAU;

        foreach($inscrits as $i)
        {
            if ($i->idadh == $idadherent)
            {
                $position = $i->placeFile;
                break;
            }
        }

        if($position < $effectif){
            return 0;
        }else{
            return $position - $effectif;
        }

    }
    */

// Lister les activités ouvertes aux adhérents
    public function listerActivite()
    {
        $modActivite = $this->loadModel('ListeActiviteOuverte'); //instancier le modele
        $projection = "ID_ACTIVITE,NOM,DETAIL,VILLE";
        $condition = 'STATUT = "O"';
        $params = array('projection' => $projection, 'conditions' => $condition);
        $d['activites'] = $modActivite->find($params);
        //passer les informations à la vue qui s'appellera liste.php
        $this->set($d);
    }

    function consulter($id)
    {
        $ID_ACTIVITE = $id;

        // requete 1
        $modActivite = $this->loadModel('ListeActiviteOuverte');
        $projection ['projection'] = "OUVERT_EXT, ACTIVITE.ID_ACTIVITE, ACTIVITE.ID_LEADER, ACTIVITE.NOM, ACTIVITE.DETAIL, ACTIVITE.ADRESSE, ACTIVITE.CP, ACTIVITE.VILLE, ACTIVITE.AGE_MINIMUM,ACTIVITE.PRIX_ADULTE,ACTIVITE.PRIX_ENFANT,ACTIVITE.PRIX_ADULTE_EXT,ACTIVITE.PRIX_ENFANT_EXT, ACTIVITE.INDICATION_PARTICIPANT, ACTIVITE.INFO_IMPORTANT_PARTICIPANT";
        $projection['conditions'] = "ID_ACTIVITE = " . $ID_ACTIVITE;
        $d['donnees'] = $modActivite->findfirst($projection);

        // requete 2 pour récupérer le nom
        $modNomLeader = $this->loadModel('NomLeader');
        $projection ['projection'] = "ADHERENT.NOM as NOMLEADER, ADHERENT.PRENOM as PRENOMLEADER";
        $projection['conditions'] = "ID_ACTIVITE = " . $ID_ACTIVITE;
        // $d['nomleader'] = $modNomLeader->findfirst($projection);
        $d['leader'] = $modNomLeader->findfirst($projection);

        // requete 3 pour récupérer la liste des créneau
        $modListeCreneau = $this->loadModel('ListeCreneau');
        $projection ['projection'] = "CRENEAU.NUM_CRENEAU, CRENEAU.DATE_CRENEAU, HEURE_CRENEAU, EFFECTIF_CRENEAU";
        $projection['conditions'] = "ID_ACTIVITE = " . $ID_ACTIVITE;
        $d['creneaux'] = $modListeCreneau->find($projection);

        // requete 4 pour récupérer la liste des participants par créneau

        $modInscription = $this->loadModel('ActiviteParticipantsAdherent');

        //Récuperer les effectifs des créneaux
        $modEffectif = $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = 'i.DATE_PAIEMENT, i.ID, c.DATE_CRENEAU, c.HEURE_CRENEAU,c.EFFECTIF_CRENEAU,
        i.PAYE, i.CRENEAU, i.ID_ADHERENT, 
        MONTANT, AUTO_PARTICIPATION, i.ID_ACTIVITE, 
        GROUP_CONCAT(a.NOM," ", a.PRENOM) as adh, 
        GROUP_CONCAT(inv.NOM, " ", inv.PRENOM separator "<br>") as listeinv, c.NUM_CRENEAU, COUNT(i.ID_ADHERENT)+COUNT(li.ID_INVITE) as effectif';
        $projectionC['conditions'] = "i.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 0";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultE = $modEffectif->find($projectionC);
        $d['effectifs'] = $resultE;
        ////var_dump($resultE);

        //Récuperer les personnes qui ne participent pas mais qui ont inscrit des invités
        $modEffectifInvite= $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(i.ID) as effectif";
        $projectionC['conditions'] = "i.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 0 AND i.AUTO_PARTICIPATION=0";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultEI = $modEffectifInvite->find($projectionC);
        $d['effectifInvite'] = $resultEI;

        //Récuperer les effectifs des créneaux en attente
        $modEffectif = $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(i.ID_ADHERENT)+COUNT(li.ID_INVITE) as effectif";
        $projectionC['conditions'] = "i.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 1";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultE = $modEffectif->find($projectionC);
        $d['effectifsattente'] = $resultE;
        ////var_dump($resultE);

        //Récuperer les personnes qui ne participent pas mais qui ont inscrit des invités en attente
        $modEffectifInvite= $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(i.ID) as effectif";
        $projectionC['conditions'] = "i.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 1 AND i.AUTO_PARTICIPATION=0";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultEI = $modEffectifInvite->find($projectionC);
        $d['effectifInviteattente'] = $resultEI;

        $modPresta = $this->loadModel('Prestation');
        $projPresta["conditions"] = "ID_ACTIVITE = $id AND SECONDAIRE = 0";
        $d['prestationsP'] = $modPresta->find($projPresta);
        $projPresta["conditions"] = "ID_ACTIVITE = $id AND SECONDAIRE = 1";
        $d['prestationsS'] = $modPresta->find($projPresta);

        $this->set($d);

    }


    public function formulaireInscription($id)
    {
        $ID_ACTIVITE = $id;
        $modActivite = $this->loadModel('ListeActiviteOuverte');
        $projection['conditions'] = "ID_ACTIVITE = " . $ID_ACTIVITE;
        $d['donnees'] = $modActivite->findfirst($projection);
        //Verification inscription
        $modActivite = $this->loadModel('Inscription');
        $projection['conditions'] = "ID_ACTIVITE = " . $ID_ACTIVITE . " AND ID_ADHERENT = " . Session::get('ID_ADHERENT');
        $d['inscription'] = $modActivite->findfirst($projection);

        //Récuperer les effectifs des créneaux
        $modEffectif = $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(li.ID_INVITE) as effectif";
        $projectionC['conditions'] = "c.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND (i.ATTENTE = 0 OR i.ATTENTE is null)";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultE = $modEffectif->find($projectionC);
        $d['effectifsInvite'] = $resultE;
        ////var_dump($resultE);

        $modEffectif = $this->loadModel('InscriptionCreneau');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(i.ID_ADHERENT) as effectif";
        $projectionC['conditions'] = "c.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND (i.ATTENTE = 0 OR i.ATTENTE is null)";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultEff = $modEffectif->find($projectionC, true);
        $d['effectifs'] = $resultEff;

        //Récuperer les personnes qui ne participent pas mais qui ont inscrit des invités
        $modEffectifInvite= $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(i.ID) as effectif";
        $projectionC['conditions'] = "c.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND (i.ATTENTE = 0 OR i.ATTENTE is null) AND i.AUTO_PARTICIPATION=0";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultEI = $modEffectifInvite->find($projectionC);
        $d['effectifInvite'] = $resultEI;

        //Récuperer les effectifs des créneaux en attente
        $modEffectif = $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(i.ID_ADHERENT)+COUNT(li.ID_INVITE) as effectif";
        $projectionC['conditions'] = "c.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 1";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultE = $modEffectif->find($projectionC);
        $d['effectifsattente'] = $resultE;
        ////var_dump($resultE);

        //Récuperer les personnes qui ne participent pas mais qui ont inscrit des invités en attente
        $modEffectifInvite= $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(i.ID) as effectif";
        $projectionC['conditions'] = "i.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 1 AND i.AUTO_PARTICIPATION=0";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultEI = $modEffectifInvite->find($projectionC);
        $d['effectifInviteattente'] = $resultEI;

        //Récupération liste des invités
        $modInvite = $this->loadModel('Invite');
        $projection['conditions'] = "STATUT = 'FAMILLE' AND ID_ADHERENT = " . Session::get('ID_ADHERENT');
        $d['invitesfamille'] = $modInvite->find($projection);

        $projection['conditions'] = "STATUT = 'EXTERNE' AND ID_ADHERENT = " . Session::get('ID_ADHERENT');
        $d['invitesext'] = $modInvite->find($projection);

        // Récupération des créneaux.
        $modCreneau = $this->loadModel('ActiviteCreneauAdmin');
        $projection['conditions'] = "ID_ACTIVITE = {$id} AND STATUT = 'O'";
        $projection['orderby'] = "DATE_CRENEAU, HEURE_CRENEAU";
        $d['creneaux'] = $modCreneau->find($projection);

        //Récupération des prestations
        $modPresta=$this->loadModel('Prestation');
        $projPresta['projection'] = "ID_PRESTATION, PRIX, LIBELLE";
        $projPresta['conditions'] = "ID_ACTIVITE = {$id} AND SECONDAIRE = 0";
        $d['prestationP'] = $modPresta->find($projPresta);
        $projPresta['conditions'] = "ID_ACTIVITE = {$id} AND SECONDAIRE = 1";
        $d['prestationS'] = $modPresta->find($projPresta);
        $projPresta['projection'] = "PRIX";
        $projPresta['conditions'] = "ID_ACTIVITE = {$id}";
        $d['prestationPrix']=$modPresta->find($projPresta);
        $projPresta['projection'] = "COUNT(ID_PRESTATION) as nbPresta";
        $projPresta['conditions'] = "ID_ACTIVITE = {$id}";
        $d['nbPresta']=$modPresta->findfirst($projPresta);

        $modInscription = $this->loadModel('ActiviteParticipantsLeader');
        $projection['projection'] = 'INSCRIPTION.ID_PRESTATION as PRESTATION, INSCRIPTION.PRESTATIONSEC1 as PrestationSecondaire1, INSCRIPTION.PRESTATIONSEC2 as PrestationSecondaire2';
        $projection['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$id} AND ADHERENT.ID_ADHERENT = " . Session::get('ID_ADHERENT');
        $projection['groupby'] = "INSCRIPTION.DATE_INSCRIPTION ";
        $projection['orderby'] = "INSCRIPTION.CRENEAU";
        //$projection['order by'] = "INSCRIPTION.DATE_INSCRIPTION";
        ////var_dump($projection);
        $result = $modInscription->find($projection);
        $d['inscrits'] = $result;

        $modInvitePresta=$this->loadModel('InvitePrestation');
        $projec['projection'] = 'LISTE_INVITES.ID_INVITE, LISTE_INVITES.ID_PRESTATION as PRESTATION, LISTE_INVITES.PRESTATIONSEC1 as PrestationSecondaire1, LISTE_INVITES.PRESTATIONSEC2 as PrestationSecondaire2';
        $projec['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$id} AND INSCRIPTION.ID_ADHERENT = " . Session::get('ID_ADHERENT');
        $d['invites'] = $modInvitePresta->find($projec);

        $this->set($d);
    }

    // Permet de savoir si le même invité a été renseigné plus d'une fois.
    function has_dupes($array)
    {
        $dupe_array = array();
        foreach ($array as $val) {
            if (++$dupe_array[$val] > 1) {
                return true;
            }
        }
        return false;
    }

    function getAge($date)
    {
        $dob = new DateTime($date);
        $now = new DateTime();
        $difference = $now->diff($dob);
        $age = $difference->y;
        return $age;
    }

    function calculMontant($activite, $participation, $invites)
    {


        $modInvite = $this->loadModel("Invite");
        // Récupération des prix de l'activité:
        $modActivite = $this->loadModel("ActiviteLeader");
        $projection['conditions'] = "ID_ACTIVITE = " . $activite;
        $infosActivite = $modActivite->findfirst($projection);

        $montant = 0;


        if (isset($invites)) {
            foreach ($invites as $inv) {
                //                echo "invites=";
                ////                var_dump($invites);
                //                echo "nouvel invité";
                ////                var_dump($inv);
                if ($inv->STATUT == 'FAMILLE') {
                    $famille[] = $inv->ID_INVITE;
                } else if ($inv->STATUT == 'EXTERNE') {
                    $ext[] = $inv->ID_INVITE;
                }
            }


            if (isset($famille)) {
                foreach ($famille as $invf) { // FAMILLE

                    // Enfant ?
                    $projection['conditions'] = "ID_PERS_EXTERIEUR = " . $invf;
                    $age = $this->getAge($modInvite->findfirst($projection)->DATE_NAISSANCE);
                    if ($age >= 18) { // adulte
                        $montant += $infosActivite->PRIX_ADULTE;

                    } else { // enfant
                        $montant += $infosActivite->PRIX_ENFANT;
                    }
                }

            }

            if (isset($ext)) {
                foreach ($ext as $inve) { // EXTERIEUR
                    // Enfant ?

                    $projection['conditions'] = "ID_PERS_EXTERIEUR = " . $inve;
                    $age = $this->getAge($modInvite->findfirst($projection)->DATE_NAISSANCE);

                    if ($age >= 18) { // adulte
                        $montant += $infosActivite->PRIX_ADULTE_EXT;

                    } else { // enfant
                        $montant += $infosActivite->PRIX_ENFANT_EXT;

                    }

                }

            }
        }


        if (!($participation == 'non')) {
            $montant += $infosActivite->PRIX_ADULTE;
        }

        return $montant;
    }

    public function modificationActiviteBackup($id)
    {

        $modInscription = $this->loadModel('Inscription');
        $req['projection'] = "CRENEAU, ID_ACTIVITE, MONTANT, AUTO_PARTICIPATION";
        $req['conditions'] = "ID = ${id}";
        $inscription = $modInscription->findfirst($req);

        // Vérification des places dispo :
        $modInscription = $this->loadModel('ActiviteParticipantsAdherent');
        $reqI['projection'] =
            'i.AUTO_PARTICIPATION as ap,
            CASE 
    	        WHEN AUTO_PARTICIPATION=1 THEN COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE)
    	        ELSE COUNT(li.ID_INVITE)
            END as inscrits,
            c.EFFECTIF_CRENEAU as places';
        $reqI['conditions'] = "c.ID_ACTIVITE = {$inscription->ID_ACTIVITE} AND c.NUM_CRENEAU = {$inscription->CRENEAU}";
        // $projection['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $effectifc = $modInscription->findfirst($reqI);

        $nombreinscription = 0;
        if (isset($_POST['famille'])) $nombreinscription += count($_POST['famille']);
        if (isset($_POST['ext'])) $nombreinscription += count($_POST['ext']);
        if ($_POST['AUTO_PARTICIPATION'] == 1 && $effectifc->ap == 0) $nombreinscription++;


        if (!($nombreinscription > $effectifc->places - $effectifc->inscrits)) {

            $ID_ADHERENT = Session::get('ID_ADHERENT');
            $ID_ACTIVITE = $id;
            $donnees = array();

            if (isset($_POST['famille']) && $this->has_dupes($_POST['famille']) == true) {
                $d['info'] .= "Une erreur est survenue : vous ne pouvez pas incrire la même personne plusieurs fois !";
            } elseif (isset($_POST['ext']) && $this->has_dupes($_POST['ext']) == true) {
                $d['info'] .= "Une erreur est survenue : vous ne pouvez pas incrire la même personne plusieurs fois !";
            } else {


                if ($_POST['AUTO_PARTICIPATION'] == 1) {
                    $donnees['AUTO_PARTICIPATION'] = 1;
                    $adh = Session::get('ID_ADHERENT');
                } else $adh = "non";


                //// Liste des invités ////
                $modListeInvite = $this->loadModel('ListeInvite');
                $proj['projection'] = 'ID_INVITE';
                $proj['conditions'] = 'ID_INSCRIPTION = ' . $id;


                $listeinvites = $modListeInvite->find($proj);

                $valid = true;

                $colonnes = array('ID_INSCRIPTION', 'ID_INVITE');

                $donneesInvite['ID_INSCRIPTION'] = $id;
                if (isset($_POST['famille'])) {
                    foreach ($_POST['famille'] as $key) {
                        if ($key == 'none') {
                            // ne rien faire
                        } else {
                            foreach ($listeinvites as $i) {
                                if ($i->ID_INVITE == $key) {
                                    $valid = false;
                                    $d['info'] = 'Vous ne pouvez pas inscrire plusieurs fois la même personne !';
                                    break;
                                }
                            }
                            if ($valid) {
                                $donneesInvite['ID_INVITE'] = $key;
                                $modListeInvite->insert($colonnes, $donneesInvite);
                            } else {
                                break;
                            }
                        }

                    }
                }

                if (isset($_POST['ext'])) {

                    foreach ($_POST['ext'] as $key) {

                        if ($key == 'none') {
                            // ne rien faire
                        } else {
                            foreach ($listeinvites as $i) {
                                if ($i->ID_INVITE == $key) {
                                    $valid = false;
                                    $d['info'] = 'Vous ne pouvez pas inscrire plusieurs fois la même personne !';
                                    break;
                                }
                            }
                            if ($valid) {
                                $donneesInvite['ID_INVITE'] = $key;
                                $modListeInvite->insert($colonnes, $donneesInvite);
                            } else {
                                break;
                            }
                        }


                    }
                }

                $modListeInviteNom = $this->loadModel('ListeInviteNom');

                $proj['projection'] = 'ID_INVITE, STATUT';
                $data['MONTANT'] = $this->calculMontant($inscription->ID_ACTIVITE, $adh, $modListeInviteNom->find($proj));
                if($adh != -1){
                    $data['AUTO_PARTICIPATION'] = 1;
                }

                $tab = array('conditions' => array('ID' => $id), 'donnees' => $data);
                $modInscription->update($tab);

                if ($valid) {
                    $d['info'] .= "L'inscription à l'activité a été effectuée";
                } /* else {
                $d['info'] .= " Un problème est servenu lors de l'inscription à l'activité";
            }
            */
            }
            $this->set($d);
            $this->mesActivites($inscription->ID_ACTIVITE);
        }else{
            $d['info'] = "Une erreur est servenue : ce créneau de l'activité est plein !";
            $this->set($d);
            $this->formulaireInscription($id);
            $this->render('formulaireInscription');
        }



    }

    public function modificationActivite($id)
    {
// Vérification des places dispo :
        $modInscription = $this->loadModel('ActiviteParticipantsAdherent');
        $reqI['projection'] =
            'CASE 
    	        WHEN (i.AUTO_PARTICIPATION=1) THEN COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE)
    	        ELSE COUNT(li.ID_INVITE)
            END as inscrits,
            c.EFFECTIF_CRENEAU as places';
        $reqI['conditions'] = "i.ID_ACTIVITE = {$id} AND i.CRENEAU = {$_POST['CRENEAU']} AND i.ATTENTE = 0";
        $effectifc = $modInscription->findfirst($reqI);

        //compter les personnes en attente
        $reqIA['projection'] =
            'CASE 
    	        WHEN (i.AUTO_PARTICIPATION=1) THEN COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE)
    	        ELSE COUNT(li.ID_INVITE)
            END as inscrits,
            c.EFFECTIF_CRENEAU as places';
        $reqIA['conditions'] = "c.ID_ACTIVITE = {$id} AND c.NUM_CRENEAU = {$_POST['CRENEAU']} AND i.ATTENTE = 1";
        $effectifca = $modInscription->findfirst($reqIA);

        //combien de personnes vont être inscrits avec cette inscription
        $nombreinscription = 0;
        $nombreinscription += count($_POST['participant']);

        //récupération des données du formulaire
        $donnees['ID_ACTIVITE'] = $id;
        $donnees['ID_ADHERENT'] = $_SESSION['ID_ADHERENT'];

        //on place les variable d'auto_participation à 0 par défaut//
        $adh = "non";
        $donnees['AUTO_PARTICIPATION'] = 0;

        //on vérifie dans chaque participation s'il y a l'auto_inscription de l'utilisateur
        foreach ($_POST['participant'] as $participant) {
            if ($participant == 'AUTO_PARTICIPATION') {
                $adh = Session::get('ID_ADHERENT');
                $donnees['AUTO_PARTICIPATION'] = 1;
            }
        }
        //var_dump($_POST['CRENEAU']);
        $donnees['CRENEAU'] = $_POST['CRENEAU'];
        $donnees['DATE_INSCRIPTION'] = date('Y-m-d H:i:s');

        $inscription = true;

        $invites[] = "";
        unset($invites[0]);

        foreach ($_POST['participant'] as $participant) {
            if ($participant != 'AUTO_PARTICIPATION') {
                $invites[] += $participant;
            }
        }

        /*if(isset($invites)) {
            $donnees['MONTANT'] = $this->calculMontant($id, $adh, $invites);
        }
        else{
            $donnees['MONTANT'] = $this->calculMontant($id, $adh, NULL);
        }*/
////        var_dump($_POST);
        $donnees['MONTANT'] = $_POST['montant'];

        //SI il reste de la place dans la liste principale
        if (!($nombreinscription > $effectifc->places - $effectifc->inscrits)) {
            $colonnes = array('ID_ACTIVITE', 'ID_ADHERENT', 'AUTO_PARTICIPATION', 'CRENEAU', 'DATE_INSCRIPTION', 'MONTANT', 'ID_PRESTATION');
            $this->mailAdherent($donnees['ID_ADHERENT'], "principale", $id);
        }

        //SI il reste de la place dans la liste d'attente
        elseif(!($nombreinscription > ($effectifc->places*3) - $effectifca->inscrits)){
            $colonnes = array('ID_ACTIVITE', 'ID_ADHERENT', 'AUTO_PARTICIPATION', 'CRENEAU', 'DATE_INSCRIPTION', 'MONTANT', 'ATTENTE', 'ID_PRESTATION');
            $donnees['ATTENTE'] = 1;
            $d['info'] = "L'effectif de cette activité étant complet, vous avez été placé en liste d'attente";
            $this->mailAdherent($donnees['ID_ADHERENT'], "attente", $id);
        }

        //SI il n'y a pas de place pour ce créneau
        else{
            $d['info'] = "La liste d'attente est complète";
            $inscription=false;
            $this->mailAdherent($donnees['ID_ADHERENT'], "non inscrit", $id);
        }

        // Test si l'on n'est pas déjà inscrit !
        $modInscription = $this->loadModel('Inscription');
        $projection['conditions'] = "ID_ACTIVITE =" . $id . " AND ID_ADHERENT = " . $_SESSION['ID_ADHERENT'];
        $inscrit = $modInscription->findfirst($projection);

        if (isset($_POST['participant']) && $this->has_dupes($_POST['participant']) == true) {
            $d['info'] = "Une erreur est survenue : vous ne pouvez pas incrire la même personne plusieurs fois !";
            $inscription=false;
        }

        if(isset($_POST['prestationSecondaire'])){
            $count = 0;
            foreach ($_POST['participant'] as $key) {
                if ($_POST['prestationSecondaire'][$count * 2] == $_POST['prestationSecondaire'][$count * 2 + 1] && $_POST['prestationSecondaire'][$count * 2]!="none") {
////                    var_dump($_POST['prestationSecondaire'][$count * 2]);
////                    var_dump($count);
                    $inscription = false;
                    $d['info'] = "Vous ne pouvez inscrire un participant à deux prestations secondaires identiques";
                }
                $count+=1;
            }
        }


        if($inscription){
            ////var_dump($colonnes);
            ////var_dump($donnees);
            $projection['conditions'] = "ID_ADHERENT = " . $_SESSION['ID_ADHERENT'];

            //on cherche la prestation de l'adhérent
            // $donnees['ID_PRESTATION'] = null;
            $count = 0;
            foreach ($_POST['participant'] as $key) {
                if ($key=='AUTO_PARTICIPATION') {
                    $donnees['ID_PRESTATION'] = $_POST['prestationprincipale'][$count];
                    if ($_POST['prestationSecondaire'][$count * 2] == "none") {
                        if ($_POST['prestationSecondaire'][$count * 2 + 1] != "none") {
                            $colonnes[] = "PRESTATIONSEC1";
                            $donnees['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count * 2 + 1];
                        }
                    } else {
                        $colonnes[] = "PRESTATIONSEC1";
                        $donnees['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count * 2];
                        if ($_POST['prestationSecondaire'][$count * 2 + 1] != "none") {
                            $colonnes[] = "PRESTATIONSEC2";
                            $donnees['PRESTATIONSEC2'] = $_POST['prestationSecondaire'][$count * 2 + 1];
                        }
                    }
                    $count+=1;
                } else {
                    $count+=1;
                }
            }

            $modListeInvite = $this->loadModel('ListeInvite');
            $reqS['conditions'] = "ID_INSCRIPTION=$inscrit->ID";
//            $modInscription->delete($reqS);
            $modListeInvite->delete($reqS);
//            $IDInscription = $modInscription->insert($colonnes, $donnees);
////            var_dump($IDInscription);
//// Liste des invités ////
            $colonnes = array('ID_INSCRIPTION', 'ID_INVITE', 'ID_PRESTATION');
            $donneesInvite['ID_INSCRIPTION'] = $inscrit->ID;
            $count = 0;
            foreach ($_POST['participant'] as $key) {
////                var_dump($colonnes);
                unset($colonnes[4]);
                unset($colonnes[3]);
////                var_dump($colonnes);
                if ($key == 'none' or $key=='AUTO_PARTICIPATION') {
                    $count+=1;
                } else {
                    $donneesInvite['ID_INVITE'] = $key;
                    $donneesInvite['ID_PRESTATION'] = $_POST['prestationprincipale'][$count];
                    if ($_POST['prestationSecondaire'][$count * 2] == "none") {
                        if ($_POST['prestationSecondaire'][$count * 2 + 1] != "none") {
                            array_push($colonnes, "PRESTATIONSEC1");
                            $donneesInvite['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count * 2 + 1];
                        }
                    } else {
                        array_push($colonnes, "PRESTATIONSEC1");
                        $donneesInvite['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count * 2];
                        if ($_POST['prestationSecondaire'][$count * 2 + 1] != "none") {
                            array_push($colonnes, "PRESTATIONSEC2");
                            $donneesInvite['PRESTATIONSEC2'] = $_POST['prestationSecondaire'][$count * 2 + 1];
                        }
                    }
////                    var_dump($donneesInvite);

//                    echo"insertion dans la base de données";
//                    $tab = array('conditions' => array('ID_INSCRIPTION' => $inscrit->ID), 'donnees' => $donneesInvite);
////                    var_dump($tab);
//                    $modListeInvite->update($tab, true);
                    $modListeInvite->insert($colonnes, $donneesInvite);
                    $count+=1;
                }
            }

//si le code id est numerique c'est ok
            $IDInscription=$inscrit->ID;
            if (is_numeric($IDInscription)) {
                // On met le montant
                $modListeInviteNom = $this->loadModel('ListeInviteNom');
                $proj['projection'] = 'ID_INVITE, STATUT';
                $proj['conditions'] = 'ID_INSCRIPTION = ' . $IDInscription;
                $donnees['MONTANT'] = $_POST['montant'];

                //Verifications des places dans le créneau souhaité

                $creneau = $donnees['CRENEAU'];
                $modEffectif = $this->loadModel('ActiviteParticipantsAdherent');
                $projectionC['projection'] = "COUNT(li.ID_INVITE) as effectif";
                $projectionC['conditions'] = "c.ID_ACTIVITE = {$id} AND c.NUM_CRENEAU = $creneau";
                $effectifinv = $modEffectif->findfirst($projectionC);
                ////var_dump($resultE);

                $modEffectif = $this->loadModel('InscriptionCreneau');
                $projectionC['projection'] = "c.EFFECTIF_CRENEAU,COUNT(i.ID_ADHERENT) as effectif";
                $projectionC['conditions'] = "c.ID_ACTIVITE = {$id} AND c.NUM_CRENEAU = $creneau";
                $effectifadh = $modEffectif->findfirst($projectionC);

                if($effectifinv->effectif + $effectifadh->effectif + count($_POST['participant']) > $effectifadh->EFFECTIF_CRENEAU)
                    $donnees['ATTENTE'] = 1;
                else
                    $donnees['ATTENTE'] = 0;
                $tab = array('conditions' => array('ID' => $IDInscription), 'donnees' => $donnees);
                //var_dump($tab);
                $modInscription->update($tab);
                if(!isset($d['info'])){
                    $d['info'] = "L'inscription à l'activité a été effectuée";
                }
            } else {
                $d['info'] = "Problème pour s'inscrire à l'activité";
            }
//                echo "data";
////                var_dump($data);
//                echo "donnees";
////                var_dump($donnees);
//                echo "d";
////                var_dump($d);

            $this->set($d);
            $this->mesActivites($id);
            $this->render('mesActivites');

        }
        else {
            echo '<script type="text/javascript">window.alert("'.$d['info'].'");</script>';
            $this->formulaireInscription($id);
            $this->render('formulaireInscription');
        }
    }

    public function inscriptionActiviteBackup($id)
    {


        /*
         *
         *  Fonctionnement BDD :
         * Si l'ID_ADHERENT est saisi mais pas l'ID invité : cela signifie que l'adhérent s'auto-inscrit.
         * Si l'ID_ADHERENT est saisi ET l'ID invité AUSSI : cela signifie que l'invité s'insrit, et qu'il est lié à cet adhérent.
         *
         */

        // Vérification des places dispo :
        $modInscription = $this->loadModel('ActiviteParticipantsAdherent');
        $reqI['projection'] =
            'CASE 
    	        WHEN (i.AUTO_PARTICIPATION=1) THEN COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE)
    	        ELSE COUNT(li.ID_INVITE)
            END as inscrits,
            c.EFFECTIF_CRENEAU as places';
        $reqI['conditions'] = "i.ID_ACTIVITE = {$id} AND i.CRENEAU = {$_POST['CRENEAU']} AND i.ATTENTE = 0";
        // $projection['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $effectifc = $modInscription->findfirst($reqI);
        //        "SELECT COUNT(*) FROM liste_invites
        //join inscription on inscription.ID = liste_invites.ID_INSCRIPTION
        //where inscription.ID_ACTIVITE=163 and inscription.creneau = 3";

        //compter les personnes en attente
        $reqIA['projection'] =
            'CASE 
    	        WHEN (i.AUTO_PARTICIPATION=1) THEN COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE)
    	        ELSE COUNT(li.ID_INVITE)
            END as inscrits,
            c.EFFECTIF_CRENEAU as places';
        $reqIA['conditions'] = "c.ID_ACTIVITE = {$id} AND c.NUM_CRENEAU = {$_POST['CRENEAU']} AND i.ATTENTE = 1";
        $effectifca = $modInscription->findfirst($reqIA);

        //combien de personnes vont être inscrits avec cette inscription
        $nombreinscription = 0;
        if (isset($_POST['famille'])) $nombreinscription += count($_POST['famille']);
        if (isset($_POST['ext'])) $nombreinscription += count($_POST['ext']);
        if ($_POST['AUTO_PARTICIPATION'] == 1) $nombreinscription++;
        //echo 'nombreinscription';
        ////var_dump($nombreinscription);
        //echo'places';
        ////var_dump($effectifc->places);
        //echo'inscrits';
        ////var_dump($effectifc->inscrits);$donnees = array();
        //echo'places attente';
        ////var_dump(($effectifca->places*3));
        //echo'inscrits attente';
        ////var_dump(($effectifca->inscrits));
        $donnees['ID_ACTIVITE'] = $id;
        $donnees['ID_ADHERENT'] = $_SESSION['ID_ADHERENT'];
        if ($_POST['AUTO_PARTICIPATION'] == 1) {
            $adh = Session::get('ID_ADHERENT');

        } else {
            $adh = "non"; // l'adhérent ne participe pas
        }
        $donnees['AUTO_PARTICIPATION'] = $_POST['AUTO_PARTICIPATION'];
        $donnees['CRENEAU'] = $_POST['CRENEAU'];
        $donnees['DATE_INSCRIPTION'] = date('Y-m-d H:i:s');
        $inscription = true;
        if(isset($_POST['famille'])) {
            $donnees['MONTANT'] = $this->calculMontant($id, $adh, $_POST['famille']);
        }
        elseif (isset($_POST['ext'])){
            $donnees['MONTANT'] = $this->calculMontant($id, $adh, $_POST['ext']);
        }
        else{
            $donnees['MONTANT'] = $this->calculMontant($id, $adh, NULL);
        }
        //SI il reste de la place dans la liste principale
        if (!($nombreinscription > $effectifc->places - $effectifc->inscrits)) {
            $colonnes = array('ID_ACTIVITE', 'ID_ADHERENT', 'AUTO_PARTICIPATION', 'CRENEAU', 'DATE_INSCRIPTION', 'MONTANT');
            $this->mailAdherent($donnees['ID_ADHERENT'], "principale", $id);
        }
        //SI il reste de la place dans la liste d'attente
        elseif(!($nombreinscription > ($effectifc->places*3) - $effectifca->inscrits)){
            $colonnes = array('ID_ACTIVITE', 'ID_ADHERENT', 'AUTO_PARTICIPATION', 'CRENEAU', 'DATE_INSCRIPTION', 'MONTANT', 'ATTENTE');
            $donnees['ATTENTE'] = 1;
            $d['info'] = "L'effectif de cette activité étant complet, vous avez été placé en liste d'attente";
            $this->mailAdherent($donnees['ID_ADHERENT'], "attente", $id);
        }
        //SI il n'y a pas de place pour ce créneau
        else{
            $d['info'] = "La liste d'attente est complète";
            $inscription=false;
            $this->mailAdherent($donnees['ID_ADHERENT'], "non inscrit", $id);
        }
        if($inscription){
            $valid = true;
            //            $donnees = array();
            //            $donnees['ID_ACTIVITE'] = $id;
            //            $donnees['ID_ADHERENT'] = $_SESSION['ID_ADHERENT'];
            //            if ($_POST['AUTO_PARTICIPATION'] == 1) {
            //                $adh = Session::get('ID_ADHERENT');
            //
            //            } else {
            //                $adh = "non"; // l'adhérent ne participe pas
            //            }
            //            $donnees['AUTO_PARTICIPATION'] = $_POST['AUTO_PARTICIPATION'];
            //            $donnees['CRENEAU'] = $_POST['CRENEAU'];
            //            $donnees['DATE_INSCRIPTION'] = date('Y-m-d');
            //            if(isset($_POST['famille'])) {
            //                $donnees['MONTANT'] = $this->calculMontant($id, $adh, $_POST['famille']);
            //            }
            //            elseif (isset($_POST['ext'])){
            //                $donnees['MONTANT'] = $this->calculMontant($id, $adh, $_POST['ext']);
            //            }
            //            else{
            //                $donnees['MONTANT'] = $this->calculMontant($id, $adh, NULL);
            //            }
            //$donnees['DATE_PAIEMENT'] = date_create('0000-00-00');
            //$donnees['DATE_DESINSCRIPTION'] = date_create('0000-00-00');

            $modInscription = $this->loadModel('Inscription');
            // Test si l'on est pas déjà inscrit !
            $projection['conditions'] = "ID_ACTIVITE =" . $id . " AND ID_ADHERENT = " . $_SESSION['ID_ADHERENT'];
            $inscrit = $modInscription->findfirst($projection);
            if (!empty($inscrit)) {
                $d['info'] = "Une erreur est survenue : vous vous êtes déjà inscrit à cette activité !";
            } elseif (isset($_POST['famille']) && $this->has_dupes($_POST['famille']) == true) {
                $d['info'] = "Une erreur est survenue : vous ne pouvez pas incrire la même personne plusieurs fois !";
            } elseif (isset($_POST['ext']) && $this->has_dupes($_POST['ext']) == true) {
                $d['info'] = "Une erreur est survenue : vous ne pouvez pas incrire la même personne plusieurs fois !";
            } else {
                ////var_dump($colonnes);
                ////var_dump($donnees);
                $projection['conditions'] = "ID_ADHERENT = " . $_SESSION['ID_ADHERENT'];

                $IDInscription = $modInscription->insertAI($colonnes, $donnees);
                //// Liste des invités ////
                $modListeInvite = $this->loadModel('ListeInvite');
                $colonnes = array('ID_INSCRIPTION', 'ID_INVITE');
                $donneesInvite['ID_INSCRIPTION'] = $IDInscription;
                if (isset($_POST['famille'])) {
                    foreach ($_POST['famille'] as $key) {
                        if ($key == 'none') {
                            // ne rien faire
                        } else {
                            $donneesInvite['ID_INVITE'] = $key;
                            $modListeInvite->insert($colonnes, $donneesInvite);
                        }

                    }
                }
                if (isset($_POST['ext'])) {
                    foreach ($_POST['ext'] as $key) {
                        if ($key == 'none') {
                            // ne rien faire
                        } else {
                            $donneesInvite['ID_INVITE'] = $key;
                            $modListeInvite->insert($colonnes, $donneesInvite);
                        }
                    }
                }


                //si le code id est numerique c'est ok
                if (is_numeric($IDInscription)) {
                    // On met le montant
                    $modListeInviteNom = $this->loadModel('ListeInviteNom');
                    $proj['projection'] = 'ID_INVITE, STATUT';
                    $proj['conditions'] = 'ID_INSCRIPTION = ' . $IDInscription;
                    $data['MONTANT'] = $this->calculMontant($id, $adh, $modListeInviteNom->find($proj));
                    $tab = array('conditions' => array('ID' => $IDInscription), 'donnees' => $data);
                    $modInscription->update($tab);
                    if(!isset($d['info'])){
                        $d['info'] = "L'inscription à l'activité a été effectuée";
                    }
                } else {
                    $d['info'] = "Problème pour s'inscrire à l'activité";
                }
                //                echo "data";
                ////                var_dump($data);
                //                echo "donnees";
                ////                var_dump($donnees);
                //                echo "d";
                ////                var_dump($d);

                $this->set($d);
                $this->mesActivites($id);
                $this->render('mesActivites');
            }
        }
    }

    public function inscriptionActivite($id)
    {

        // Vérification des places dispo :
        $modInscription = $this->loadModel('ActiviteParticipantsAdherent');
        $reqI['projection'] =
            'CASE 
    	        WHEN (i.AUTO_PARTICIPATION=1) THEN COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE)
    	        ELSE COUNT(li.ID_INVITE)
            END as inscrits,
            c.EFFECTIF_CRENEAU as places';
        $reqI['conditions'] = "i.ID_ACTIVITE = {$id} AND i.CRENEAU = {$_POST['CRENEAU']} AND i.ATTENTE = 0";
        $effectifc = $modInscription->findfirst($reqI);

        //compter les personnes en attente
        $reqIA['projection'] =
            'CASE 
    	        WHEN (i.AUTO_PARTICIPATION=1) THEN COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE)
    	        ELSE COUNT(li.ID_INVITE)
            END as inscrits,
            c.EFFECTIF_CRENEAU as places';
        $reqIA['conditions'] = "c.ID_ACTIVITE = {$id} AND c.NUM_CRENEAU = {$_POST['CRENEAU']} AND i.ATTENTE = 1";
        $effectifca = $modInscription->findfirst($reqIA);

        //combien de personnes vont être inscrits avec cette inscription
        $nombreinscription = 0;
        $nombreinscription += count($_POST['participant']);

        //récupération des données du formulaire
        $donnees['ID_ACTIVITE'] = $id;
        $donnees['ID_ADHERENT'] = $_SESSION['ID_ADHERENT'];

        //on place les variable d'auto_participation à 0 par défaut//
        $adh = "non";
        $donnees['AUTO_PARTICIPATION'] = 0;

        //on vérifie dans chaque participation s'il y a l'auto_inscription de l'utilisateur
        foreach ($_POST['participant'] as $participant) {
//            echo "participant";
////            var_dump($participant);
            if ($participant == 'AUTO_PARTICIPATION') {
                $adh = Session::get('ID_ADHERENT');
                $donnees['AUTO_PARTICIPATION'] = 1;
            }
        }

        $donnees['CRENEAU'] = $_POST['CRENEAU'];
        $donnees['DATE_INSCRIPTION'] = date('Y-m-d H:i:s');
        $inscription = true;
        $invites[] = "";
        unset($invites[0]);
        foreach ($_POST['participant'] as $participant) {
            if ($participant != 'AUTO_PARTICIPATION') {
                $invites[] += $participant;
            }
        }
        /*if(isset($invites)) {
            echo "invites";
    ////            var_dump($invites);
            $donnees['MONTANT'] = $this->calculMontant($id, $adh, $invites);
        }
        else{
            $donnees['MONTANT'] = $this->calculMontant($id, $adh, NULL);
        }*/
        $donnees['MONTANT'] = $_POST['montant'];


        //SI il reste de la place dans la liste principale
        if (!($nombreinscription > $effectifc->places - $effectifc->inscrits)) {
            $colonnes = array('ID_ACTIVITE', 'ID_ADHERENT', 'AUTO_PARTICIPATION', 'CRENEAU', 'DATE_INSCRIPTION', 'MONTANT', 'ID_PRESTATION');
            $this->mailAdherent($donnees['ID_ADHERENT'], "principale", $id);
        }


        //SI il reste de la place dans la liste d'attente
        elseif(!($nombreinscription > ($effectifc->places*3) - $effectifca->inscrits)){
            $colonnes = array('ID_ACTIVITE', 'ID_ADHERENT', 'AUTO_PARTICIPATION', 'CRENEAU', 'DATE_INSCRIPTION', 'MONTANT', 'ATTENTE', 'ID_PRESTATION');
            $donnees['ATTENTE'] = 1;
            $d['info'] = "L'effectif de cette activité étant complet, vous avez été placé en liste d'attente";
            $this->mailAdherent($donnees['ID_ADHERENT'], "attente", $id);
        }


        //SI il n'y a pas de place pour ce créneau
        else{
            $d['info'] = "La liste d'attente est complète";
            $inscription=false;
            $this->mailAdherent($donnees['ID_ADHERENT'], "non inscrit", $id);
        }
        $modInscription = $this->loadModel('Inscription');


        // Test si l'on est pas déjà inscrit !
        $projection['conditions'] = "ID_ACTIVITE =" . $id . " AND ID_ADHERENT = " . $_SESSION['ID_ADHERENT'];
        $inscrit = $modInscription->findfirst($projection);

        if (!empty($inscrit)) {
            $d['info'] = "Une erreur est survenue : vous vous êtes déjà inscrit à cette activité !";
            $inscription=false;
        } elseif (isset($_POST['participant']) && $this->has_dupes($_POST['participant']) == true) {
            $d['info'] = "Une erreur est survenue : vous ne pouvez pas incrire la même personne plusieurs fois !";
            $inscription=false;
        }

        if(isset($_POST['prestationSecondaire'])){
            $count = 0;
            foreach ($_POST['participant'] as $key) {
                if ($_POST['prestationSecondaire'][$count * 2] == $_POST['prestationSecondaire'][$count * 2 + 1] && $_POST['prestationSecondaire'][$count * 2 + 1]!="none") {
                    $inscription = false;
                    $d['info'] = "Vous ne pouvez inscrire un participant à deux prestations secondaires identiques";
                }
            }
        }

        if($inscription){
            ////var_dump($colonnes);
            ////var_dump($donnees);
            $projection['conditions'] = "ID_ADHERENT = " . $_SESSION['ID_ADHERENT'];

            //on cherche la prestation de l'adhérent
            // $donnees['ID_PRESTATION'] = null;
            $count = 0;
            foreach ($_POST['participant'] as $key) {
                if ($key=='AUTO_PARTICIPATION') {
                    echo "prestations sec adherent";
                    //var_dump($_POST['prestationSecondaire'][$count*2]);
                    //var_dump($_POST['prestationSecondaire'][$count*2+1]);
                    $donnees['ID_PRESTATION'] = $_POST['prestationprincipale'][$count];

                    //test de prestations secondaire//
                    //si le premier select de prestation secondaire est vide
                    if($_POST['prestationSecondaire'][$count*2]=="none"){
                        //si le deuxieme select est rempli
                        if($_POST['prestationSecondaire'][$count*2+1]!="none") {
                            //on ajoute dans les colonnes prestationsec1 pour inserer des données dans cet colonne de la table
                            $colonnes[] = "PRESTATIONSEC1";
                            //on set les données d'insertion pour la premiere presta secondaire sur le deuxieme select
                            $donnees['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count*2+1];
                        }
                    }
                    //si le premier select est rempli
                    else{
                        //on ajoute dans les colonnes prestationsec1 pour inserer des données dans cet colonne de la table
                        $colonnes[] = "PRESTATIONSEC1";
                        //on set les données d'insertion pour la premiere presta secondaire sur le premier select
                        $donnees['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count*2];
                        //si le deuxieme select n'est pas vide
                        if($_POST['prestationSecondaire'][$count*2+1]!="none") {
                            //on ajoute l'insertion dans la colonne prestasec2 et on set la donnée à entrée sur le deuxieme select
                            $colonnes[] = "PRESTATIONSEC2";
                            $donnees['PRESTATIONSEC2'] = $_POST['prestationSecondaire'][$count*2+1];
                        }
                    }

                    /*if($_POST['prestationSecondaire'][$count*2]!="none")
                    $donnees['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count*2];
                    else
                        $donnees['PRESTATIONSEC1'] = null;
                    if($_POST['prestationSecondaire'][$count*2+1]!="none")
                    $donnees['PRESTATIONSEC2'] = $_POST['prestationSecondaire'][$count*2+1];
                    else
                        $donnees['PRESTATIONSEC2'] = null;*/
                    //var_dump($donnees);
                    //var_dump($colonnes);
                    $count+=1;
                } else {
                    $count+=1;
                }
            }

            $IDInscription = $modInscription->insertAI($colonnes, $donnees);
////            var_dump($IDInscription);

            //// Liste des invités ////
            $modListeInvite = $this->loadModel('ListeInvite');
            $donneesInvite['ID_INSCRIPTION'] = $IDInscription;
            $count = 0;
            foreach ($_POST['participant'] as $key) {
                $colonnes = array('ID_INSCRIPTION', 'ID_INVITE', 'ID_PRESTATION');
                if ($key == 'none' or $key=='AUTO_PARTICIPATION') {
                    $count+=1;
                } else {
                    echo"prestations sec invites";
                    //var_dump($_POST['prestationSecondaire'][$count*2]);
                    //var_dump($_POST['prestationSecondaire'][$count*2+1]);
                    $donneesInvite['ID_INVITE'] = $key;
                    $donneesInvite['ID_PRESTATION'] = $_POST['prestationprincipale'][$count];
                    if($_POST['prestationSecondaire'][$count*2]=="none"){
                        if($_POST['prestationSecondaire'][$count*2+1]!="none") {
                            $colonnes[] = "PRESTATIONSEC1";
                            $donneesInvite['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count*2+1];
                        }
                    }
                    else{
                        $colonnes[] = "PRESTATIONSEC1";
                        $donneesInvite['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count*2];
                        if($_POST['prestationSecondaire'][$count*2+1]!="none") {
                            $colonnes[] = "PRESTATIONSEC2";
                            $donneesInvite['PRESTATIONSEC2'] = $_POST['prestationSecondaire'][$count*2+1];
                        }
                    }

                    /* if($_POST['prestationSecondaire'][$count*2]!="none")
                         $donneesInvite['PRESTATIONSEC1'] = $_POST['prestationSecondaire'][$count*2];
                     else
                         $donneesInvite['PRESTATIONSEC1'] = null;
                     if($_POST['prestationSecondaire'][$count*2+1]!="none")
                         $donneesInvite['PRESTATIONSEC2'] = $_POST['prestationSecondaire'][$count*2+1];
                     else
                         $donneesInvite['PRESTATIONSEC2'] = null;*/

                    //var_dump($donneesInvite);
                    //var_dump($colonnes);
                    $modListeInvite->insert($colonnes, $donneesInvite);
                    $count+=1;
                }
            }

            //si le code id est numerique c'est ok
            $IDInscription=0;
            if (is_numeric($IDInscription)) {
                // On met le montant
                $modListeInviteNom = $this->loadModel('ListeInviteNom');
                $proj['projection'] = 'ID_INVITE, STATUT';
                $proj['conditions'] = 'ID_INSCRIPTION = ' . $IDInscription;
                $data['MONTANT'] = $this->calculMontant($id, $adh, $modListeInviteNom->find($proj));
                $tab = array('conditions' => array('ID' => $IDInscription), 'donnees' => $data);
////                var_dump($tab);
                $modInscription->update($tab);
                if(!isset($d['info'])){
                    $d['info'] = "L'inscription à l'activité a été effectuée";
                }
            } else {
                $d['info'] = "Problème pour s'inscrire à l'activité";
            }
            //                echo "data";
            ////                var_dump($data);
            //                echo "donnees";
            ////                var_dump($donnees);
            //                echo "d";
            ////                var_dump($d);

            $this->set($d);
            $this->mesActivites($id);
            $this->render('mesActivites');
        }
        else {
            echo '<script type="text/javascript">window.alert("'.$d['info'].'");</script>';
            $this->formulaireInscription($id);
            $this->render('formulaireInscription');
        }
    }



    function attente($idactivite){
        $modAttente = $this->loadModel('Attente');

    }


//    public function inscriptionActivite($id) {
//        $ID_ACTIVITE = $id;
//        $ID_ADHERENT = $_SESSION['ID_ADHERENT'];
//        $DATE_INSCRIPTION = date("Y-m-d");
//        $CRENEAU = 0;<<<<
//        $DATE_PAIEMENT = date("Y-m-d");
//        $NB_ENFANTS = 0;
//        $NB_EXT = 0;
//        $MONTANT = 100;
//        $DATE_DESINSCRIPTION = date("Y-m-d");
//        $modInscription = $this->loadModel('Inscription');
//        $donnees = array($ID_ACTIVITE, $ID_ADHERENT, $DATE_INSCRIPTION, $CRENEAU, $DATE_PAIEMENT, $NB_ENFANTS, $NB_EXT, $MONTANT, $DATE_DESINSCRIPTION);
//        $colonne = array('ID_ACTIVITE', 'ID_ADHERENT', 'DATE_INSCRIPTION', 'CRENEAU', 'DATE_PAIEMENT', 'NB_ENFANTS', 'NB_EXT', 'MONTANT', 'DATE_DESINSCRIPTION');
//        $ID_ACIVITE = $modInscription->insertAI($colonne, $donnees);
//    }
//put your code here
//    function detail($id) {
//        $ID = $id;
//        $modInscription = $this->loadModel('INSCRIPTION');
//        $i['inscription'] = $modInscription->findFirst(array('conditions' => array('ID' => $ID)));
//        $this->set($i);
//    }
//
//    function liste($id) {
//        $ID = trim($id);
//
//        $this->modIncription = $this->loadModel('INSCRIPTION');
//        $i['inscription'] = $this->modInscription->findFirst(array(
//            'conditions' => array('id' => $ID)
//        ));
//        if (empty($i['inscription'])) {
//            $this->e404('Clé invalide');
//        }
//        $this->set($i);
//    }
//
//
//}


    public function listerActiviteInscrit()
    {
        $modActiviteInscrit = $this->loadModel('ActiviteInscriptionCreneau'); //instancier le modele
        $projection['projection'] = "ACTIVITE.ID_ACTIVITE,INSCRIPTION.ATTENTE, ACTIVITE.NOM,DETAIL,VILLE,INDICATION_PARTICIPANT, DATE_CRENEAU, HEURE_CRENEAU, MONTANT, ADHERENT.NOM as an, ADHERENT.PRENOM as ap";
        $projection['conditions'] = 'INSCRIPTION.ID_ADHERENT = ' . $_SESSION['ID_ADHERENT'];
        $d['inscription'] = $modActiviteInscrit->find($projection);
        //  $projection ['projection'] = "ACTIVITE.ID_ACTIVITE,NOM,DETAIL,VILLE,NB_ENFANTS,NB_EXT,INDICATION_PARTICIPANT,MONTANT";
        // $projection['conditions'] = 'ID_ADHERENT = '.$_SESSION['ID_ADHERENT'];
        //  $params = array('projection' => $projection, 'condition' => $condition);
        //  $d['activites'] = $modActiviteInscrit->find($params);
////        var_dump($d['inscription']);
        $this->set($d);
    }

    function mesActivites($id)
    {
        $ID_ACTIVITE = $id;
        $modActiviteInscrit = $this->loadModel('ActiviteInscrit');
        //$projection ['projection']="activite.ID_ACTIVITE, activite.NOM, activite.DETAIL, activite.ADRESSE, activite.CP, activite.VILLE, activite.AGE_MINIMUM,,activite.DATE_PAIEMENT, activite.INDICATION_PARTICIPANT, activite.INFO_IMPORTANT_PARTICIPANT";
        $projection ['projection'] = "ACTIVITE.ID_ACTIVITE, ACTIVITE.ID_LEADER, ACTIVITE.NOM, ACTIVITE.DETAIL, ACTIVITE.ADRESSE, ACTIVITE.CP, ACTIVITE.VILLE, ACTIVITE.AGE_MINIMUM,ACTIVITE.PRIX_ADULTE,ACTIVITE.PRIX_ENFANT,ACTIVITE.PRIX_ADULTE_EXT,ACTIVITE.PRIX_ENFANT_EXT, ACTIVITE.INDICATION_PARTICIPANT, ACTIVITE.INFO_IMPORTANT_PARTICIPANT, INSCRIPTION.ATTENTE";
        $projection['conditions'] = "ACTIVITE.ID_ACTIVITE = " . $ID_ACTIVITE;
        $d['donnees'] = $modActiviteInscrit->findfirst($projection);

        // requete 2 pour récupérer le nom
        $modNomLeader = $this->loadModel('NomLeader');
        $projection ['projection'] = "ADHERENT.NOM as NOMLEADER, ADHERENT.PRENOM as PRENOMLEADER";
        $projection['conditions'] = "ID_ACTIVITE = " . $ID_ACTIVITE;
        // $d['nomleader'] = $modNomLeader->findfirst($projection);
        $d['leader'] = $modNomLeader->findfirst($projection);

        // requete 3 pour récupérer les info de l'inscription
        $modInscription = $this->loadModel('Inscription');
        $projectionI['conditions'] = "ID_ACTIVITE = {$ID_ACTIVITE} AND ID_ADHERENT = {$_SESSION['ID_ADHERENT']}";
        ////        var_dump($ID_ACTIVITE);
        ////        var_dump($_SESSION['ID_ADHERENT']);
        $d['inscription'] = $modInscription->findfirst($projectionI);
////                var_dump($d['inscription']);

        //requete 4 : on recupère la liste des invites
        $modListeInvite = $this->loadModel('ListeInviteNom');
        $projectionL['conditions'] = "ID_INSCRIPTION = {$d['inscription']->ID}";
        //$projectionL['conditions'] = "ID_INSCRIPTION = {$d['inscription']}";
        $d['invites'] = $modListeInvite->find($projectionL);
        ////        var_dump($d['invites']);
        $modCreneaudate = $this->loadModel('ListeCreneau');
        $projectionM['projection'] = "CRENEAU.DATE_PAIEMENT, CRENEAU.DATE_CRENEAU as date, CRENEAU.HEURE_CRENEAU as heure";
        $projectionM['conditions'] = "ID_ACTIVITE = {$ID_ACTIVITE} AND NUM_CRENEAU = {$d['inscription']->CRENEAU}";
        $d['creneau'] = $modCreneaudate->findfirst($projectionM);

        // Place liste d'attente:
        /*
        $d['position'] = $this->positionListeAttente($d['inscription']->ID);
        */
        $this->set($d);

        $this->render('mesActivites');


    }


    public function mailAdherent($idinscrit, $mess, $activite){

//        $mail = new mailConfig();
        $configMail = new mailConfig();
        $mail = $configMail->config();

        $modInscription = $this->loadModel('Adherent');
        $projection['projection'] = 'ADHERENT.mail';
        $projection['conditions'] = "ADHERENT.ID_adherent = {$idinscrit}";
        $result = $modInscription->find($projection);
        $modActivite = $this->loadModel("Activite");
        $projection['projection'] = "ACTIVITE.nom";
        $projection['conditions'] = "ACTIVITE.ID_ACTIVITE = {$activite}";
        $resulta = $modActivite->findfirst($projection);
        foreach($resulta as $nom){
            $nomactivite=$nom;
        }

        foreach($result as $dest){
            $mail->addAddress($dest->mail);
        }
        switch ($mess){
            case "principale":
                $mail->Subject="Inscription en liste principale";
                $mail->Body="Vous avez été inscrit dans la liste principale de l'activité $nomactivite";
                break;
            case "attente":
                $mail->Subject="Mise en liste d'attente";
                $mail->Body="Vous avez été placé en liste d'attente pour l'activité $nomactivite";
                break;
            case "non inscrit":
                $mail->Subject="Inscription impossible";
                $mail->Body="Vous ne pouvez pas vous inscrire pour l'activité $nomactivite, l'effectif de la liste d'attente est complet.";
                break;
        }
        $mail->send();
        $mail->smtpClose();
    }


}
//amicadreslrh@gmail.com
?>

