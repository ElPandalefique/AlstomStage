<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\mailConfig;
require("../core/phpmailer/mailConfig.php");

class ActiviteAdminController extends Controller {

    public function liste() {
        $modActivite = $this->loadModel('ActiviteAdmin'); //instancier le modele 
        $modCreneau = $this->loadModel('ActiviteCreneauAdmin');
        $projection['projection'] = "ID_LEADER,ID_ACTIVITE,NOM,DETAIL,ADRESSE,CP,VILLE,INDICATION_PARTICIPANT,INFO_IMPORTANT_PARTICIPANT,
        AGE_MINIMUM,FORFAIT,TARIF_FORFAIT,TARIF_UNIT,OUVERT_EXT,COUT_ADULTE,COUT_ENFANT,STATUT,DATE_CREATION,PRIX_ADULTE,
        PRIX_ENFANT,PRIX_ADULTE_EXT,PRIX_ENFANT_EXT";
        $d['activite'] = $modActivite->find($projection);
        $d['creneau'] = $modCreneau->find(array('conditions' => 1));
        $this->set($d);
    }

    function detail($id) {
        $ID_ACTIVITE = $id;
        $modActivite = $this->loadModel('ActiviteAdmin');
        $d['activite'] = $modActivite->findFirst(array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE)));

        // requete 2 pour récupérer le nom
        $modNomLeader = $this->loadModel('NomLeader');
        $projection ['projection'] = "ADHERENT.NOM as NOMLEADER, ADHERENT.PRENOM as PRENOMLEADER";
        $projection['conditions'] = "ID_ACTIVITE = " . $ID_ACTIVITE;
        // $d['nomleader'] = $modNomLeader->findfirst($projection);
        $d['leader'] = $modNomLeader->findfirst($projection);

        //prestations
        $modPresta = $this->loadModel('Prestation');
        $projection['projection'] = "COUT, AGEMIN, AGEMAX, LIBELLE, OUVERT_EXT, PRIX";
        $projection['conditions'] = "ID_ACTIVITE = $ID_ACTIVITE AND SECONDAIRE = 0";
        $d['prestationsPrincipales'] = $modPresta->find($projection, true);
        $projection['conditions'] = "ID_ACTIVITE = $ID_ACTIVITE AND SECONDAIRE = 1";
        $d['prestationsSecondaires'] = $modPresta->find($projection);

        // prestataires
        $modPrestataire = $this->loadModel('Prestataire');
        $projection = "ID,NOM";
        $params = array('projection' => $projection);
        $d['prestataires'] = $modPrestataire->find($params);

        $this->set($d);
    }

    function modifierbackup($id) {
        $ID_ACTIVITE = $id;
        $modActivite = $this->loadModel('ActiviteAdmin');
        //recup les données du form
        $donnees = array();
        $donnees["ID_DOMAINE"] = 1;
        $donnees["NOM"] = $_POST["NOM"];
        $donnees["DETAIL"] = $_POST["DETAIL"];

        $donnees["ADRESSE"] = $_POST["ADRESSE"];
        $donnees["CP"] = $_POST["CP"];
        $donnees["VILLE"] = $_POST["VILLE"];
        $donnees["INDICATION_PARTICIPANT"] = $_POST["INDICATION_PARTICIPANT"];
        $donnees["INFO_IMPORTANT_PARTICIPANT"] = $_POST["INFO_IMPORTANT_PARTICIPANT"];
        $donnees["STATUT"] = $_POST["STATUT"];
        $donnees["ID_PRESTATAIRE"] = $_POST["ID_PRESTATAIRE"];
        $donnees["FORFAIT"] = $_POST["TYPE_FORFAIT"];
        $donnees["COUT_ADULTE"] = $_POST["COUT_ADULTE"];


        $donnees["TARIF_FORFAIT"] = $_POST["TARIF_FORFAIT"];
        $donnees["COUT_ENFANT"] = $_POST["COUT_ENFANT"];
        $donnees["AGE_MINIMUM"] = $_POST["AGE_MINIMUM"];
        $donnees["OUVERT_EXT"] = $_POST["OUVERT_EXT"];
        if(isset($_POST["PRIX_ADULTE"])) {
            $donnees["PRIX_ADULTE"] = $_POST["PRIX_ADULTE"];
            var_dump($_POST["PRIX_ADULTE"]);
        }
        else{
            $donnees["PRIX_ADULTE"] = $_POST["COUT_ADULTE"];
        }
        if($_POST["PRIX_ADULTE_EXT"]!='') {
            $donnees["PRIX_ADULTE_EXT"] = $_POST["PRIX_ADULTE_EXT"];
            var_dump($_POST["PRIX_ADULTE_EXT"]);
        }
        else{
            $donnees["PRIX_ADULTE_EXT"] = 0;
        }
        if($_POST["PRIX_ENFANT"]!='') {
            $donnees["PRIX_ENFANT"] = $_POST["PRIX_ENFANT"];
        }
        else{
            $donnees["PRIX_ENFANT"] = 0;
        }
        if($_POST["PRIX_ENFANT_EXT"]!='') {
            $donnees["PRIX_ENFANT_EXT"] = $_POST["PRIX_ENFANT_EXT"];
        }
        else{
            $donnees["PRIX_ENFANT_EXT"] = 0;
        }


        $tab = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE), 'donnees' => $donnees);
//appeler la methode update
        $modActivite->update($tab);
        $d['info'] = "Activité modifié";
//charger le tableau
        $this->liste();
        $this->render('liste');

        $this->mailc($ID_ACTIVITE, "modifier");
    }

    function modifier($id) {
        $ID_ACTIVITE = $id;
        $modActivite = $this->loadModel('ActiviteAdmin');
        //recup les données du form
        $donnees = array();
        $donnees["ID_DOMAINE"] = 1;
        $donnees["NOM"] = $_POST["NOM"];
        $donnees["DETAIL"] = $_POST["DETAIL"];

        $donnees["ADRESSE"] = $_POST["ADRESSE"];
        $donnees["CP"] = $_POST["CP"];
        $donnees["VILLE"] = $_POST["VILLE"];
        $donnees["INDICATION_PARTICIPANT"] = $_POST["INDICATION_PARTICIPANT"];
        $donnees["INFO_IMPORTANT_PARTICIPANT"] = $_POST["INFO_IMPORTANT_PARTICIPANT"];
        $donnees["STATUT"] = $_POST["STATUT"];
        $donnees["ID_PRESTATAIRE"] = $_POST["ID_PRESTATAIRE"];
        $donnees["FORFAIT"] = $_POST["TYPE_FORFAIT"];

        //préparation de la récup des prestations
        $modPresta = $this->loadModel('Prestation');
        $colonnesPresta=array('ID_ACTIVITE', 'ID_PRESTATION', 'COUT', 'AGEMIN', 'AGEMAX', 'LIBELLE', 'OUVERT_EXT','SECONDAIRE', 'PRIX');
        $count=0;
        $modPresta->delete(array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE)));

        foreach ($_POST['Libelle'] as $libelle){
            //récupération de chaque valeur dans des variables pour facilité la compréhension
            $post = "OUVERT_EXTERNE".($count+1);
            $cout = $_POST['COUT'][$count];
            $agemin = $_POST['AGE_MIN'][$count];
            $agemax = $_POST['AGE_MAX'][$count];
            $ouvertext = $_POST["$post"];
            $prix = $_POST['PRIX'][$count];


            //ajout des données dans pour l'insertion
            $donneesPresta['ID_ACTIVITE']=$ID_ACTIVITE;
            $donneesPresta['ID_PRESTATION'] = $count+1;
            $donneesPresta['COUT'] = $cout;
            $donneesPresta['AGE_MIN'] = $agemin;
            $donneesPresta['AGE_MAX'] = $agemax;
            $donneesPresta['LIBELLE'] = $libelle;
            $donneesPresta['OUVERT_EXT'] = $ouvertext;
            $donneesPresta['SECONDAIRE'] = 0;
            $donneesPresta['PRIX'] = $prix;

            /*if(isset($_POST["PRIX"])) {
                $donnees["PRIX"] = $_POST["PRIX"];
                var_dump($_POST["PRIX"]);
            }
            else{
                $donnees["PRIX"] = $_POST["COUT"];
            }*/

            //insertion dans la base de données
            $modPresta->insert($colonnesPresta, $donneesPresta);

            //ajout d'une valeur du count pour selectionner la prestation suivante de l'activité
            $count+=1;

        }

        if(isset($_POST['LibelleSecondaire'])){
            $countsec = 0;
            var_dump($_POST['COUTSecondaire']);

            foreach ($_POST['LibelleSecondaire'] as $libelle){
                //récupération de chaque valeur dans des variables pour facilité la compréhension
                $post = "OUVERT_EXTERNESecondaire".($countsec+1);
                $cout = $_POST['COUTSecondaire'][$countsec];
                var_dump($cout);
                var_dump($countsec);
                $agemin = $_POST['AGE_MINSecondaire'][$countsec];
                $agemax = $_POST['AGE_MAXSecondaire'][$countsec];
                $ouvertext = $_POST["$post"];
                $prix = $_POST['PRIXSecondaire'][$countsec];


                //ajout des données dans pour l'insertion
                $donneesPresta['ID_ACTIVITE']=$ID_ACTIVITE;
                $donneesPresta['ID_PRESTATION'] = $count+1;
                $donneesPresta['COUT'] = $cout;
                $donneesPresta['AGE_MIN'] = $agemin;
                $donneesPresta['AGE_MAX'] = $agemax;
                $donneesPresta['LIBELLE'] = $libelle;
                $donneesPresta['OUVERT_EXT'] = $ouvertext;
                $donneesPresta['SECONDAIRE'] = 1;
                $donneesPresta['PRIX'] = $prix;

                //insertion dans la base de données
                var_dump($colonnesPresta);
                var_dump($donneesPresta);
                $modPresta->insert($colonnesPresta, $donneesPresta);

                //ajout d'une valeur du count pour selectionner la prestation suivante de l'activité
                $countsec+=1;
                $count+=1;

            }
        }



        $tab = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE), 'donnees' => $donnees);
//appeler la methode update
        $modActivite->update($tab);
        $d['info'] = "Activité modifié";
//charger le tableau
        $this->liste();
        $this->render('liste');

        $this->mailc($ID_ACTIVITE, "modifier");
    }

    function inscrits($id)
    {
        /*  $modInscription = $this->loadModel('ActiviteParticipantsLeader');

          $adinfo = $modInscription->find($projection);

          $modInvites = $this->loadModel('ActiviteParticipants');
          $projection['projection'] = "INVITE.PRENOM,INVITE.NOM";

          foreach ($adinfo as $i) {
              $projection['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$id} AND INSCRIPTION.CRENEAU = {$i->CRENEAU}";
              $invites = $modInvites->find($projection);
              foreach ($invites as $p) {
                  $listeinvites[] = array('NOM' => $p->NOM, 'PRENOM' => $p->PRENOM);
              }
              $participants[] = array('ID_ACTIVITE' => $id, 'CRENEAU' => $i->CRENEAU, 'MONTANT' => $i->MONTANT, 'PRENOM' => $i->PRENOM, 'NOM' => $i->NOM, 'AUTO_PARTICIPATION' => $i->AUTO_PARTICIPATION,
                  'LISTE_INVITE' => $listeinvites);

          }

          $d['donnees'] = $participants;*/
        //PRESTATION.LIBELLE as LIBELLE,
        $modInscription = $this->loadModel('ActiviteParticipantsLeader');
        $projection['projection'] = 'INSCRIPTION.DATE_INSCRIPTION, INSCRIPTION.DATE_PAIEMENT, INSCRIPTION.ID,CRENEAU.NUM_CRENEAU, CRENEAU.DATE_CRENEAU, CRENEAU.HEURE_CRENEAU,INSCRIPTION.PAYE, INSCRIPTION.CRENEAU, INSCRIPTION.ID_ADHERENT, MONTANT, AUTO_PARTICIPATION, INSCRIPTION.ID_ACTIVITE, ADHERENT.NOM as ADN, ADHERENT.PRENOM as ADP,ADHERENT.TELEPHONE, GROUP_CONCAT(INVITE.NOM, " ", INVITE.PRENOM separator "<br>") as INN,  INSCRIPTION.ATTENTE as ATTENTE, INSCRIPTION.ID_PRESTATION as PRESTATION, INSCRIPTION.PRESTATIONSEC1 as PrestationSecondaire1, INSCRIPTION.PRESTATIONSEC2 as PrestationSecondaire2';
        $projection['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$id} AND INSCRIPTION.ATTENTE = 0";
        $projection['groupby'] = "INSCRIPTION.DATE_INSCRIPTION ";
        $projection['orderby'] = "INSCRIPTION.CRENEAU";
        //$projection['order by'] = "INSCRIPTION.DATE_INSCRIPTION";
        //var_dump($projection);
        $result = $modInscription->find($projection);
        $d['inscrits'] = $result;


        $modPresta = $this->loadModel('InvitePrestation');
        $proj['projection'] = 'LISTE_INVITES.ID_PRESTATION as PRESTATION, LISTE_INVITES.PRESTATIONSEC1 as PrestationSecondaire1, LISTE_INVITES.PRESTATIONSEC2 as PrestationSecondaire2, INVITE.NOM, INVITE.PRENOM';
        $proj['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$id} AND INSCRIPTION.ATTENTE = 0";
//        $proj['groupby'] = "INSCRIPTION.ID ";
        //var_dump($projection);
        $resultPI = $modPresta->find($proj);
        $d['prestationI'] = $resultPI;

        //récupération du nom des prestations des adherents
        $modPrestation = $this->loadModel('InscriptionPrestation');
        $proj['projection'] = 'PRESTATION.LIBELLE, PRESTATION.PRIX';
        $proj['conditions'] = "PRESTATION.ID_ACTIVITE = $id";
        $resultP = $modPrestation->find($proj);
        $d['prestation'] = $resultP;


        $projection['groupby'] = "INSCRIPTION.DATE_INSCRIPTION ";
        $projection['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$id} AND INSCRIPTION.ATTENTE = 1";
        $projection['orderby'] = "INSCRIPTION.DATE_INSCRIPTION";
        $resultA = $modInscription->find($projection);
        $d['inscritsA'] = $resultA;
        //var_dump($result);
        //var_dump($resultA);

        //Récuperer les effectifs des créneaux
        $modEffectif = $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(li.ID_INVITE) as effectif";
        $projectionC['conditions'] = "i.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 0";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultE = $modEffectif->find($projectionC);
        $d['effectifsInvite'] = $resultE;
        //var_dump($resultE);

        $modEffectif = $this->loadModel('InscriptionCreneau');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(i.ID_ADHERENT) as effectif";
        $projectionC['conditions'] = "i.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 0";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultEff = $modEffectif->find($projectionC);
        $d['effectifs'] = $resultEff;

        //Récuperer les personnes qui ne participent pas mais qui ont inscrit des invités
        $modEffectifInvite= $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU, c.NUM_CRENEAU, COUNT(i.ID) as effectif";
        $projectionC['conditions'] = "i.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 0 AND i.AUTO_PARTICIPATION=0";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultEI = $modEffectifInvite->find($projectionC);
        $d['effectifInvite'] = $resultEI;

        $this->set($d);
        $this->render('inscrits');

    }

    public function gerer($id)
    {

        // Récupérer l'adhérent et l'activité associé.
        $modInscription = $this->loadModel('Inscription');
        $projection['projection'] = 'CRENEAU, ID, ID_ACTIVITE, ID_ADHERENT, PAYE, DATE_PAIEMENT';
        $projection['conditions'] = "ID = " . $id;
        $d['donnees'] = $modInscription->findfirst($projection);

        $modCreneau = $this->loadModel('ActiviteCreneauAdmin');
        $projection['projection'] = 'NUM_CRENEAU, DATE_CRENEAU, HEURE_CRENEAU';
        $projection['conditions'] = "STATUT = 'O' AND ID_ACTIVITE = ". $d['donnees']->ID_ACTIVITE;
        $d['creneaux'] = $modCreneau->find($projection);


        // Rendu du formulaire
        $this->set($d);
        $this->render('gerer');
    }

    public function gererAttente($id)
    {

        // Récupérer l'adhérent et l'activité associé.
        $modInscription = $this->loadModel('Inscription');
        $projection['projection'] = 'CRENEAU, ID, ID_ACTIVITE, ID_ADHERENT, PAYE, DATE_PAIEMENT';
        $projection['conditions'] = "ID = " . $id;
        $d['donnees'] = $modInscription->findfirst($projection);

        $modCreneau = $this->loadModel('ActiviteCreneauAdmin');
        $projection['projection'] = 'NUM_CRENEAU, DATE_CRENEAU, HEURE_CRENEAU';
        $projection['conditions'] = "STATUT = 'O' AND ID_ACTIVITE = ". $d['donnees']->ID_ACTIVITE;
        $d['creneaux'] = $modCreneau->find($projection);

        //echo'var_dump d';
        //var_dump($d);
        // Rendu du formulaire
        $this->set($d);
        $this->render('gererAttente');

    }

    public function passagePrincipale($id){
        $modParticipants = $this->loadModel('ActiviteParticipantsAdherent');
        $reqI['projection'] = '
            COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE) as inscrits,
            c.EFFECTIF_CRENEAU as places';
        $reqI['conditions'] = "c.ID_ACTIVITE = {$id} AND c.NUM_CRENEAU = {$_POST['creneau']} AND i.ATTENTE = 0" ;
        $effectifc = $modParticipants->findfirst($reqI);
        $modInscription = $this->loadModel('ActiviteParticipantsLeader');
        $projection['projection'] = 'INSCRIPTION.DATE_INSCRIPTION, INSCRIPTION.DATE_PAIEMENT, INSCRIPTION.ID as ID, CRENEAU.DATE_CRENEAU, CRENEAU.HEURE_CRENEAU,INSCRIPTION.PAYE, INSCRIPTION.CRENEAU, INSCRIPTION.ID_ADHERENT, MONTANT, AUTO_PARTICIPATION as ap, INSCRIPTION.ID_ACTIVITE, ADHERENT.NOM as ADN, ADHERENT.PRENOM as ADP, COUNT(INVITE.ID_PERS_EXTERIEUR) as INN, INSCRIPTION.ATTENTE as ATTENTE';

        $projection['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$id} AND INSCRIPTION.ATTENTE = 1 AND INSCRIPTION.ID_ADHERENT = $_POST[idadh]";
        $resultA = $modInscription->findfirst($projection);
        $nombreinscription = intval($resultA->ap) + intval($resultA->INN);


        //compte les personnes qui ne sont pas en auto-participation
        $modEffectifInvite= $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = "COUNT(i.ID) as effectif";
        $projectionC['conditions'] = "c.ID_ACTIVITE = {$id} AND c.NUM_CRENEAU = {$_POST['creneau']} AND i.ATTENTE = 0 AND i.AUTO_PARTICIPATION=0";
        $resultEI = $modEffectifInvite->findfirst($projectionC, true);

        $inscrits = $effectifc->inscrits-$resultEI->effectif;
        //var_dump($inscrits);

        if (!($nombreinscription > $effectifc->places - $inscrits)) {
            $donnees['ATTENTE'] = 0;
            $tab = array('conditions' => array('ID' => $_POST['id']), 'donnees' => $donnees);
            //var_dump($resultA->ID);
            //var_dump($id);
            $this->mailSolo($resultA->ID, "principale", $id);
            $modInscription->update($tab);
            $d['info'] = "Passage en liste principale effectué";
        }
        else{
            $d['info'] = "Passage en liste principale impossible, l'effectif est complet";
        }
        $this->set($d);
        $this->inscrits($id);
    }

    function archivage($id) {

        $modActivite = $this->loadModel('ActiviteAdmin');
//recup les données du formulaire
        if (isset($_POST['ids'])) {
            $donnees = array();
            $donnees['STATUT'] = 'F';
            $ids = $_POST['ids'];
            foreach ($ids as $id) {
                $tab = array('conditions' => 'ID_ACTIVITE = ' . $id, 'donnees' => $donnees);
                try {
                    $modActivite->update($tab);
                } catch (PDOException $e) {
                    $info .= "<br>Erreur";
                }
            }

        }
        $this->liste();
        $this->render('liste');
    }

    function formulaireCreneau($id) {
        $modActivite = $this->loadModel('ActiviteAdmin');
        $modCreneau = $this->loadModel('ActiviteCreneauAdmin');
        $modPresta = $this->loadModel('Prestation');
        if (strpos($id, '_') !== FALSE) {
            $ids = explode("_", $id);
            // NUM_ACTIVITE : $ids[1]
            $ID_ACTIVITE = $ids[0];
            $NUM_CRENEAU = $ids[1];
            $d['creneauP'] = $modCreneau->find(array('conditions' => array('CRENEAU.NUM_CRENEAU' => $NUM_CRENEAU, 'CRENEAU.ID_ACTIVITE' => $ID_ACTIVITE)));
        } else {
            $ID_ACTIVITE = $id;
        }
        $d['prestations'] = $modPresta->find(array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE)));
        $d['activite'] = $modActivite->findFirst(array('conditions' => array('ACTIVITE.ID_ACTIVITE' => $ID_ACTIVITE)));
        $d['creneauG'] = $modCreneau->find(array('conditions' => array('CRENEAU.ID_ACTIVITE' => $ID_ACTIVITE)));
        $this->set($d);
    }

    function creerCreneau($id) {
        $ID_ACTIVITE = $id;

        //$modActivite = $this->loadModel('ActiviteAdmin');
        $donnees["ID_ACTIVITE"] = $ID_ACTIVITE;
        $donnees["DATE_CRENEAU"] = $_POST['DATE_CRENEAU'];
        $donnees["HEURE_CRENEAU"] = $_POST['HEURE_CRENEAU'];
        if(isset($_POST['DATE_PAIEMENT'])) {
            $donnees["DATE_PAIEMENT"] = $_POST['DATE_PAIEMENT'];
        }
        else{
            $donnees["DATE_PAIEMENT"] = '2000-01-01';
        }
        $donnees["EFFECTIF_CRENEAU"] = $_POST["EFFECTIF_CRENEAU"];
        $donnees["COMMENTAIRE"] = "";
        $donnees["STATUT"] = 'A';

        // Récupération du nombre de créneau pour une activité
        $modActivite = $this->loadModel('ActiviteAdmin');
        $modCreneau = $this->loadModel('ActiviteCreneauAdmin');
        $proj['activite'] = $modActivite->findFirst(array('conditions' => array('ACTIVITE.ID_ACTIVITE' => $ID_ACTIVITE)));
        $proj['creneau'] = $modCreneau->find(array('conditions' => array('CRENEAU.ID_ACTIVITE' => $ID_ACTIVITE)));
        $nbCreneau = 0;
        foreach ($proj['creneau'] as $c) {
            $nbCreneau = $nbCreneau + 1;
        }
        $donnees["NUM_CRENEAU"] = $nbCreneau + 1;

        var_dump($donnees);
        $colonnes = array('ID_ACTIVITE', 'DATE_CRENEAU', 'HEURE_CRENEAU', 'DATE_PAIEMENT', 'EFFECTIF_CRENEAU', 'COMMENTAIRE', 'STATUT', 'NUM_CRENEAU' );
        //appeler la méthode insert
        $modCreneau->insert($colonnes, $donnees);

        $this->liste();
        //$this->redirect('liste');
        header('Location: ../liste');
    }

    function modifierCreneau($id) {
        $modCreneau = $this->loadModel('ActiviteCreneauAdmin');

        $ids = explode("_", $id);
        $ID_ACTIVITE = $ids[0];
        $NUM_CRENEAU = $ids[1];

        $modActivite = $this->loadModel('ActiviteAdmin');
        $donnees["ID_ACTIVITE"] = $ID_ACTIVITE;
        $donnees["DATE_CRENEAU"] = $_POST['DATE_CRENEAU'];
        $donnees["HEURE_CRENEAU"] = $_POST['HEURE_CRENEAU'];
        $donnees["EFFECTIF_CRENEAU"] = $_POST["EFFECTIF_CRENEAU"];
        $donnees["STATUT"] = $_POST["STATUT"];
        $donnees["COMMENTAIRE"] = $_POST["COMMENTAIRE"];
        $colonnes = array('ID_ACTIVITE', 'DATE_CRENEAU', 'HEURE_CRENEAU', 'EFFECTIF_CRENEAU', 'STATUT', 'NUM_CRENEAU', 'COMMENTAIRE');
        $tab = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE, 'NUM_CRENEAU' => $NUM_CRENEAU), 'donnees' => $donnees);
        //appeler la methode update
//        $this->mailLeader($ID_ACTIVITE);
        $modCreneau->update($tab);
        $this->liste();
        header('Location: ../liste');
    }

    function supprimerCreneau($id) {
        if ($id != FALSE) {
            $modCreneau = $this->loadModel('ActiviteCreneauAdmin');
            $ids = explode("_", $id);
            $ID_ACTIVITE = $ids[0];
            $NUM_CRENEAU = $ids[1];
            //$modActivite = $this->loadModel('ActiviteAdmin');
            $tab = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE, 'NUM_CRENEAU' => $NUM_CRENEAU));
            //appeler la methode delete
            $modCreneau->delete($tab);
        }
        $this->liste();
        header('Location: ../liste');
    }

    public function paye($id)
    {
        // Récupérer l'adhérent et l'activité associé.
        $modInscription = $this->loadModel('Inscription');
        $projection['projection'] = 'ID_ACTIVITE, ID_ADHERENT';
        $projection['conditions'] = "ID = " . $id;
        $infoi = $modInscription->findfirst($projection);

        $donnees["PAYE"] = 1;
        $donnees["DATE_PAIEMENT"] = date("Y-m-d");
        $tab = array('conditions' => array('ID_ADHERENT' => $infoi->ID_ADHERENT, 'ID_ACTIVITE' => $infoi->ID_ACTIVITE), 'donnees' => $donnees);
        $modInscription->update($tab);

        $d['info'] = "Le paiement de l'adhérent a été validé avec succès.";
        $this->mailSolo($id, "paye", $infoi->ID_ACTIVITE);
        $this->set($d);
        $this->gerer($id);
    }

    public function deplacerCreneau($id){

        // Récupérer l'adhérent et l'activité associé.
        $modInscription = $this->loadModel('Inscription');
        $projection['projection'] = 'ID_ACTIVITE, ID_ADHERENT';
        $projection['conditions'] = "ID = " . $id;
        $infoi = $modInscription->findfirst($projection);

        $donnees["CRENEAU"] = $_POST["CRENEAU"];
        $tab = array('conditions' => array('ID' => $id), 'donnees' => $donnees);
        $modInscription->update($tab);

        $d['info'] = "Le créneau de l'adhérent a été déplacé avec succès.";
        $this->mailSolo($id, "creneauAdherent", $infoi->ID_ACTIVITE);
//        $this->set($d);
//        $this->gerer($id);
        $this->inscrits($infoi->ID_ACTIVITE);

    }

    public function desinscrire($id){
        $modInscription = $this->loadModel('Inscription');
        $projection['projection'] = 'ID_ACTIVITE, ID_ADHERENT';
        $projection['conditions'] = "ID = " . $id;
        $infoi = $modInscription->findfirst($projection);

        $tab = array('conditions' => array('ID' => $id));
        $this->mailSolo($id, "desinscrire", $infoi->ID_ACTIVITE);
        $modInscription->delete($tab);

        $d['info'] = "L'adhérent a été désinscrit avec succès.";
        $this->set($d);
        $this->inscrits($infoi->ID_ACTIVITE);
    }

    public function mailLeader($idactivite, $mail)
    {
        //Récupérer adresse leader
        $modInscription = $this->loadModel('NomLeader');
        $projection['projection'] = 'ADHERENT.mail';
        $projection['conditions'] = "ACTIVITE.ID_ACTIVITE = {$idactivite} and ACTIVITE.ID_LEADER=ADHERENT.ID_ADHERENT";
        $result = $modInscription->find($projection);
        foreach($result as $dest){
            $mail->addAddress($dest->mail);
        }
    }

    public function mailSolo($idinscrit, $mess, $activite){

        $configMail = new mailConfig();
        $mail = $configMail->config();

        //récupération adresse participant
        $modInscription = $this->loadModel('ActiviteParticipantsLeader');
        $projection['projection'] = 'ADHERENT.mail';
        $projection['conditions'] = "INSCRIPTION.ID = {$idinscrit}";
        $result = $modInscription->find($projection);

        //récupération nom activité
        $nomactivite=$this->nomActivite($activite);
        /*$modActivite = $this->loadModel("ActiviteInscrit");
        $projection['projection'] = "ACTIVITE.nom";
        $projection['conditions'] = "ACTIVITE.ID_ACTIVITE = {$activite}";
        $resulta = $modActivite->findfirst($projection);
        var_dump($result);
        var_dump($resulta);
        var_dump($mess);
        foreach($resulta as $nom){
            $nomactivite=$nom;
        }*/

        foreach($result as $dest){
            $mail->addAddress($dest->mail);
        }
        switch ($mess){
            case "paye":
                $mail->Subject="Paiement confirmé";
                $mail->Body="Votre paiement à été confirmé pour l'activité $nomactivite";
                break;
            case "desinscrire":
                $mail->Subject="Désinscription";
                $mail->Body="Vous avez été désinscrit de l'activité $nomactivite";
                break;
            case "creneauAdherent":
                $mail->Subject="Modification créneau";
                $mail->Body="Vous avez été changé de créneau sur l'activité $nomactivite";
                break;
            case "principale":
                $mail->Subject="Passage en liste principale";
                $mail->Body="Vous avez été changé en liste principale sur l'activité $nomactivite";
                break;
        }
        $mail->send();
        $mail->smtpClose();
        //        var_dump($mail);
    }

    public function mailc($idactivite, $mess){

        //config mail
        $configMail = new mailConfig();
        $mail = $configMail->config();

        //récupération du mail du leader
        $this->mailLeader($idactivite, $mail);

        //récupération des mails des admins
        $this->mailAdmin($mail);

        //récupération nom activité
        $nomactivite = $this->nomActivite($idactivite);

        $mail->Subject="Activité modifiée par un administrateur";
        $mail->Body="L'activité $nomactivite à été modifiée par un administrateur";

        $mail->send();
    }

    public function mailAdmin($mail){
        $modInscription = $this->loadModel('Adherent');
        $projection['projection'] = 'ADHERENT.mail';
        $projection['conditions'] = "Adherent.grade = 'A'";
        $result = $modInscription->find($projection);
        foreach($result as $dest){
            $mail->addAddress($dest->mail);
        }
        return $result;
    }

    public function nomActivite($idactivite){
        $modActivite = $this->loadModel("Activite");
        $projection['projection'] = "ACTIVITE.nom";
        $projection['conditions'] = "ACTIVITE.ID_ACTIVITE = {$idactivite}";
        $result = $modActivite->findfirst($projection);
        var_dump($result);
        foreach ($result as $nom){
            $nomactivite = $nom;
        }
        return $nomactivite;
    }

}
