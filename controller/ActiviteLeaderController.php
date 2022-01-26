<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\mailConfig;
require("../core/phpmailer/mailConfig.php");

class ActiviteLeaderController extends Controller
{

    function creer()
    {
        $modActivite = $this->loadModel('ActiviteLeader');
        $modPrestataire = $this->loadModel('Prestataire');
        $d['activite'] = $modActivite->find(array('conditions' => 1));
        $d['action'] = "creer";
        $projection = "ID,NOM";
        $params = array('projection' => $projection);
        $d['prestataires'] = $modPrestataire->find($params);
        $this->set($d);
    }

    //méthode créer
    function backupnouveau($id)
    {
        $modActivite = $this->loadModel('ActiviteLeader');
        //recup les données du formulaire
        $donnees = array();
        $donnees["COUT_ADULTE"] = 0;
        $donnees["COUT_ENFANT"] = 0;
        $donnees["TARIF_FORFAIT"] = 0;
        $donnees["ID_DOMAINE"] = 1;
        $donnees["ID_LEADER"] = $_SESSION['ID_ADHERENT'];
        $donnees["ID_PRESTATAIRE"] = $_POST["ID_PRESTATAIRE"];
        $donnees["NOM"] = $_POST["NOM"];
        $donnees["DETAIL"] = $_POST["DETAIL"];
        $donnees["DATE_CREATION"] = date("Y-m-d");
        $donnees["ADRESSE"] = $_POST["ADRESSE"];
        $donnees["VILLE"] = $_POST["VILLE"];
        $donnees["CP"] = $_POST["CP"];
        $donnees["INDICATION_PARTICIPANT"] = $_POST["INDICATION_PARTICIPANT"];
        $donnees["INFO_IMPORTANT_PARTICIPANT"] = $_POST["INFO_IMPORTANT_PARTICIPANT"];
        $donnees["FORFAIT"] = $_POST["TYPE_FORFAIT"];
        if ($_POST["TYPE_FORFAIT"] == 'U') {
            // Choix "Unitaire"

            $donnees["COUT_ADULTE"] = $_POST["COUT_ADULTE"];
            if ($_POST["OUVERT_ENFANT"] == 1) {
                $donnees["COUT_ENFANT"] = $_POST["COUT_ENFANT"];
            }
        } else {
            // Choix "Forfait"
            $donnees["TARIF_FORFAIT"] = $_POST["TARIF_FORFAIT"];
            // TODO: Ajouter le coût et re vérifier la requête
        }

        if ($_POST["OUVERT_ENFANT"] == 0) {
            $donnees["AGE_MINIMUM"] = 18;

        } else {
            $donnees["AGE_MINIMUM"] = $_POST["AGE_MINIMUM"];

        }
        $donnees["OUVERT_EXT"] = $_POST["OUVERT_EXT"];
        $donnees["STATUT"] = 'A';

        $colonnes = array('COUT_ADULTE', 'COUT_ENFANT', 'TARIF_FORFAIT', 'ID_DOMAINE', 'ID_LEADER', 'ID_PRESTATAIRE', 'NOM', 'DETAIL', 'DATE_CREATION', 'ADRESSE', 'VILLE', 'CP', 'INDICATION_PARTICIPANT', 'INFO_IMPORTANT_PARTICIPANT', 'FORFAIT', 'AGE_MINIMUM', 'OUVERT_EXT', 'STATUT');
        //appeler la méthode insertAI

        $ID_ACTIVITE = $modActivite->insertAI($colonnes, $donnees);
        if (is_numeric($ID_ACTIVITE)) {
            $d['info'] = "La création de l'activité " . $donnees["NOM"] . " a été effectuée";
            // $d['activite'] = $modActivite->findFirst(array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE)));
            //$modActivite = $this->loadModel('ActiviteLeader');
            //$modCreneau = $this->loadModel('ActiviteCreneauAdmin');
            //$d['activite'] = $modActivite->find(array('conditions' => 1));
            // $d['creneau'] = $modCreneau->find(array('conditions' => 1));
        } else {
            $d['info'] = "Problème pour créer l'activité";
        }
        //dans tous les cas
        //charger le tableau
        $this->set($d);
        $this->formulaireCreneau($ID_ACTIVITE);
        $this->mail($ID_ACTIVITE, "creer");
    }

    function nouveau($id)
    {
        $modActivite = $this->loadModel('ActiviteLeader');
        //recup les données du formulaire
        $donnees = array();
        $donnees["TARIF_FORFAIT"] = 0;
        $donnees["ID_DOMAINE"] = 1;
        $donnees["ID_LEADER"] = $_SESSION['ID_ADHERENT'];
        $donnees["ID_PRESTATAIRE"] = $_POST["ID_PRESTATAIRE"];
        $donnees["NOM"] = $_POST["NOM"];
        $donnees["DETAIL"] = $_POST["DETAIL"];
        $donnees["DATE_CREATION"] = date("Y-m-d");
        $donnees["ADRESSE"] = $_POST["ADRESSE"];
        $donnees["VILLE"] = $_POST["VILLE"];
        $donnees["CP"] = $_POST["CP"];
        $donnees["INDICATION_PARTICIPANT"] = $_POST["INDICATION_PARTICIPANT"];
        $donnees["INFO_IMPORTANT_PARTICIPANT"] = $_POST["INFO_IMPORTANT_PARTICIPANT"];
        $donnees["FORFAIT"] = $_POST["TYPE_FORFAIT"];

        //récupération des données des prestations apres la méthode d'insertion car on les inserera un par un avec des foreach et il faut bien s'assurer que l'insertion est valide

        $colonnes = array('TARIF_FORFAIT', 'ID_DOMAINE', 'ID_LEADER', 'ID_PRESTATAIRE', 'NOM', 'DETAIL', 'DATE_CREATION', 'ADRESSE', 'VILLE', 'CP', 'INDICATION_PARTICIPANT', 'INFO_IMPORTANT_PARTICIPANT', 'FORFAIT');
        //appeler la méthode insertAI
//        var_dump($colonnes);
//        var_dump($donnees);

        $ID_ACTIVITE = $modActivite->insertAI($colonnes, $donnees);
        if (is_numeric($ID_ACTIVITE)) {
            $d['info'] = "La création de l'activité " . $donnees["NOM"] . " a été effectuée";

            //préparation de l'insertion dans la table prestation de la base de données
            $modPresta = $this->loadModel('Prestation');
            $colonnesPresta=array('ID_ACTIVITE', 'ID_PRESTATION', 'COUT', 'AGEMIN', 'AGEMAX', 'LIBELLE', 'OUVERT_EXT');

            //compte du nombre de prestation
            $count =0;

            //limites d'age
            $limmin = 0;
            $limmax = 99;

            //opération pour chaque créneau en se servant du libelle, étant obligatoire
            foreach ($_POST['Libelle'] as $libelle){
                //récupération de chaque valeur dans des variables pour facilité la compréhension
                $post = "OUVERT_EXTERNE".$count;
                $cout = $_POST['COUT'][$count];
                $agemin = $_POST['AGE_MIN'][$count];
                $agemax = $_POST['AGE_MAX'][$count];
                $ouvertext = $_POST["$post"];


                //ajout des données dans pour l'insertion
                $donneesPresta['ID_ACTIVITE']=$ID_ACTIVITE;
                $donneesPresta['ID_PRESTATION'] = $count+1;
                $donneesPresta['COUT'] = $cout;
                $donneesPresta['AGE_MIN'] = $agemin;
                $donneesPresta['AGE_MAX'] = $agemax;
                $donneesPresta['LIBELLE'] = $libelle;
                $donneesPresta['OUVERT_EXT'] = $ouvertext;

                //insertion dans la base de données
                $modPresta->insert($colonnesPresta, $donneesPresta);

                //ajout d'une valeur du count pour selectionner la prestation suivante de l'activité
                $count+=1;

            }




            //début d'insertion des différentes prestations



            // $d['activite'] = $modActivite->findFirst(array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE)));
            //$modActivite = $this->loadModel('ActiviteLeader');
            //$modCreneau = $this->loadModel('ActiviteCreneauAdmin');
            //$d['activite'] = $modActivite->find(array('conditions' => 1));
            // $d['creneau'] = $modCreneau->find(array('conditions' => 1));
        } else {
            $d['info'] = "Problème pour créer l'activité";
        }
        //dans tous les cas
        //charger le tableau
        $this->set($d);
        $this->formulaireCreneau($ID_ACTIVITE);
        $this->mail($ID_ACTIVITE, "creer");
    }

    /*   function modifier($id)
       {
           $ID_ACTIVITE = $id;
           $modActivite = $this->loadModel('ActiviteLeader');
           //recup les données du form
           $donnees = array();
           //$donnees["ID_DOMAINE"] = 1;

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
           $donnees["PRIX_ADULTE"] = $_POST["PRIX_ADULTE"];
           $donnees["PRIX_ADULTE_EXT"] = $_POST["PRIX_ADULTE_EXT"];
           $donnees["PRIX_ENFANT"] = $_POST["PRIX_ENFANT"];

           $donnees["PRIX_ENFANT_EXT"] = $_POST["PRIX_ENFANT_EXT"];


           $tab = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE), 'donnees' => $donnees);
            //appeler la methode update
           $modActivite->update($tab);
           $d['info'] = "Activité modifié";
            //charger le tableau
           $this->set($d);
           $this->liste();
           $this->render('liste');
       }*/

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
        $modInscription = $this->loadModel('ActiviteParticipantsLeader');
        $projection['projection'] = 'INSCRIPTION.DATE_INSCRIPTION, INSCRIPTION.DATE_PAIEMENT, INSCRIPTION.ID,CRENEAU.NUM_CRENEAU, CRENEAU.DATE_CRENEAU, CRENEAU.HEURE_CRENEAU,INSCRIPTION.PAYE, INSCRIPTION.CRENEAU, INSCRIPTION.ID_ADHERENT, MONTANT, AUTO_PARTICIPATION, INSCRIPTION.ID_ACTIVITE, ADHERENT.NOM as ADN, ADHERENT.PRENOM as ADP, GROUP_CONCAT(INVITE.NOM, " ", INVITE.PRENOM separator "<br>") as INN, INSCRIPTION.ATTENTE as ATTENTE';
        $projection['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$id} AND INSCRIPTION.ATTENTE = 0";
//        $projection['groupby'] = "CRENEAU.DATE_CRENEAU";
        $projection['groupby'] = "INSCRIPTION.DATE_INSCRIPTION ";
        $projection['orderby'] = "INSCRIPTION.CRENEAU";

        //$projection['order by'] = "INSCRIPTION.DATE_INSCRIPTION";
        //var_dump($projection);
        $result = $modInscription->find($projection);
        $projection['groupby'] = "INSCRIPTION.DATE_INSCRIPTION ";
        $projection['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$id} AND INSCRIPTION.ATTENTE = 1";
        $projection['orderby'] = "INSCRIPTION.DATE_INSCRIPTION";
        $resultA = $modInscription->find($projection);
        //var_dump($result);
        //var_dump($resultA);

        //Récuperer les effectifs des créneaux
        $modEffectif = $this->loadModel('ActiviteParticipantsAdherent');
        $projectionC['projection'] = 'c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU,
        COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE)as effectif';

        //test sur le serveur sql directement, mais visiblement il ne prend pas en compte le auto_participation requis à 1...
        //select c.EFFECTIF_CRENEAU, c.DATE_CRENEAU, c.HEURE_CRENEAU,
        //(select COUNT(li.ID_INVITE) where i.ID_ACTIVITE = 163 AND c.STATUT = 'O' AND i.ATTENTE = 0) as effectif_passif,
        //(select COUNT(i.ID) where i.ID_ACTIVITE = 163 AND c.STATUT = 'O' AND i.ATTENTE = 0 AND i.AUTO_PARTICIPATION = 1) as effectif_actif

        //COUNT(DISTINCT i.ID) + COUNT(li.ID_INVITE)as effectif';
        $projectionC['conditions'] = "i.ID_ACTIVITE = {$id} AND c.STATUT = 'O' AND i.ATTENTE = 0";
        $projectionC['groupby'] = "c.NUM_CRENEAU, c.ID_ACTIVITE";
        $resultE = $modEffectif->find($projectionC, true);

        $d['inscrits'] = $result;
        $d['inscritsA'] = $resultA;
        $d['effectifs'] = $resultE;
        $this->set($d);
        $this->render('inscrits');

    }

    function detail($id)
    {
        $ID_ACTIVITE = $id;
        $modActivite = $this->loadModel('ActiviteLeader');
        $d['activite'] = $modActivite->findFirst(array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE)));
        // requete 2 pour récupérer le nom
        $modNomLeader = $this->loadModel('NomLeader');
        $projection ['projection'] = "ADHERENT.NOM as NOMLEADER, ADHERENT.PRENOM as PRENOMLEADER";
        $projection['conditions'] = "ID_ACTIVITE = " . $ID_ACTIVITE;
        // $d['nomleader'] = $modNomLeader->findfirst($projection);
        $d['leader'] = $modNomLeader->findfirst($projection);
        //prestations
        $modPresta = $this->loadModel('Prestation');
        $projection['projection'] = "COUT, AGEMIN, AGEMAX, LIBELLE, OUVERT_EXT";
        $d['prestations'] = $modPresta->find($projection);
        // prestataires
        $modPrestataire = $this->loadModel('Prestataire');
        $projection = "ID,NOM";
        $params = array('projection' => $projection);
        $d['prestataires'] = $modPrestataire->find($params);
        $this->set($d);
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

        if (!($nombreinscription > $effectifc->places - $effectifc->inscrits)) {
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

    function modifierbackup($id)
    {
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
        //$donnees["STATUT"] = $_POST["STATUT"];
        $donnees["ID_PRESTATAIRE"] = $_POST["ID_PRESTATAIRE"];
        $donnees["FORFAIT"] = $_POST["TYPE_FORFAIT"];

        $donnees["TARIF_FORFAIT"] = $_POST["TARIF_FORFAIT"];



        $donnees["OUVERT_EXT"] = $_POST["OUVERT_EXT"];

        $tab = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE), 'donnees' => $donnees);
        //appeler la methode update
        $modActivite->update($tab);
        $d['info'] = "Activité modifié";
        //charger le tableau
        $this->liste();
        $this->render('liste');
        $this->mail($ID_ACTIVITE, "modifier");
    }

    function modifier($id)
    {
        $ID_ACTIVITE = $id;
        $modActivite = $this->loadModel('ActiviteAdmin');

        //préparation de la récup des prestations
        $modPresta = $this->loadModel('Prestation');
        $colonnesPresta=array('ID_ACTIVITE', 'ID_PRESTATION', 'COUT', 'AGEMIN', 'AGEMAX', 'LIBELLE', 'OUVERT_EXT');
        $count=0;

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
        //$donnees["STATUT"] = $_POST["STATUT"];
        $donnees["ID_PRESTATAIRE"] = $_POST["ID_PRESTATAIRE"];
        $donnees["FORFAIT"] = $_POST["TYPE_FORFAIT"];

       // $req['conditions'] = 'ID_ACTIVITE' => $ID_ACTIVITE;
       // $tabPresta = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE));
        $modPresta->delete(array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE)));

        foreach ($_POST['Libelle'] as $libelle){
            //récupération de chaque valeur dans des variables pour facilité la compréhension
            $post = "OUVERT_EXTERNE".($count+1);
            $cout = $_POST['COUT'][$count];
            $agemin = $_POST['AGE_MIN'][$count];
            $agemax = $_POST['AGE_MAX'][$count];
            $ouvertext = $_POST["$post"];


            //ajout des données dans pour l'insertion
            $donneesPresta['ID_ACTIVITE']=$ID_ACTIVITE;
            $donneesPresta['ID_PRESTATION'] = $count+1;
            $donneesPresta['COUT'] = $cout;
            $donneesPresta['AGE_MIN'] = $agemin;
            $donneesPresta['AGE_MAX'] = $agemax;
            $donneesPresta['LIBELLE'] = $libelle;
            $donneesPresta['OUVERT_EXT'] = $ouvertext;

            //insertion dans la base de données
            $modPresta->insert($colonnesPresta, $donneesPresta);

            //ajout d'une valeur du count pour selectionner la prestation suivante de l'activité
            $count+=1;

        }

        $tab = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE), 'donnees' => $donnees);
        //appeler la methode update
        $modActivite->update($tab);
        $d['info'] = "Activité modifié";
        //charger le tableau
        $this->liste();
        $this->render('liste');
        $this->mail($ID_ACTIVITE, "modifier");
    }

    //    public function liste() {
    //        $modActiviteLeader = $this->loadModel('ActiviteLeader'); //instancier le modele 
    //        $d['activiteleader'] = $modActiviteLeader->find(array('conditions' => 1));
    //        $this->set($d);
    //    }
    public function liste()
    {
        $modActiviteLeader = $this->loadModel('ActiviteLeader'); //instancier le modele 
        $modCreneau = $this->loadModel('ActiviteCreneauAdmin');
        $projection['projection'] = "ID_LEADER,ID_ACTIVITE,ID_PRESTATAIRE,NOM,DETAIL,ADRESSE,CP,VILLE,INDICATION_PARTICIPANT,INFO_IMPORTANT_PARTICIPANT,AGE_MINIMUM,FORFAIT,TARIF_FORFAIT,TARIF_UNIT,OUVERT_EXT,COUT_ADULTE,COUT_ENFANT,STATUT";
        $projection['conditions'] = "ID_LEADER = " . $_SESSION['ID_ADHERENT'];
        $d['leader'] = array("leader", $projection['conditions']);
        $d['activite'] = $modActiviteLeader->find($projection);
        $d['creneau'] = $modCreneau->find(array('conditions' => 1));

        //passer les informations à la vue qui s'appellera liste.php
        $this->set($d);
        //methode pour afficher le formulaire de création du tournois


        /* function supprimer($id){

          $modActivite=$this->loadModel('ActiviteLeader');
          //recup les données du formulaire
          if (isset($_POST['ids'])) {
          $ids = $_POST['ids'];
          foreach ($ids as $id) {
          $tab=array('conditions'=> 'ID_ACTIVITE = '.$id);
          $modActivite->delete($tab);

          }
          try {
          $modActivite->delete($tab);
          } catch (PDOException $e) {
          $info = $info . "<br>Erreur";

          }
          }
          $this-> liste();
          $this->render('liste');
          }
         * 
         */
    }


    function formulaireCreneau($id)
    {
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
        $this->render('formulaireCreneau');
    }

    function creerCreneau($id)
    {
        $ID_ACTIVITE = $id;

        //$modActivite = $this->loadModel('ActiviteAdmin');
        $donnees["ID_ACTIVITE"] = $ID_ACTIVITE;
        $donnees["DATE_CRENEAU"] = $_POST['DATE_CRENEAU'];
        $donnees["HEURE_CRENEAU"] = $_POST['HEURE_CRENEAU'];
        $donnees["DATE_PAIEMENT"] = $_POST['DATE_PAIEMENT'];
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

        //        var_dump($donnees);
        $colonnes = array('ID_ACTIVITE', 'DATE_CRENEAU', 'HEURE_CRENEAU', 'DATE_PAIEMENT', 'EFFECTIF_CRENEAU', 'COMMENTAIRE', 'STATUT', 'NUM_CRENEAU' );
        //appeler la méthode insert
        $modCreneau->insert($colonnes, $donnees);

        //        $this->mail($ID_ACTIVITE);
        $this->liste();

        $this->redirect('liste');
        header('Location: ../liste');
    }

    function modifierCreneau($id)
    {
        $modCreneau = $this->loadModel('ActiviteCreneauAdmin');

        $ids = explode("_", $id);
        $ID_ACTIVITE = $ids[0];
        $NUM_CRENEAU = $ids[1];

        //$modActivite = $this->loadModel('ActiviteAdmin');
        $donnees["ID_ACTIVITE"] = $ID_ACTIVITE;
        $donnees["DATE_CRENEAU"] = $_POST['DATE_CRENEAU'];
        $donnees["HEURE_CRENEAU"] = $_POST['HEURE_CRENEAU'];
        $donnees["EFFECTIF_CRENEAU"] = $_POST["EFFECTIF_CRENEAU"];
        if(isset($_POST["STATUT"]))
            $donnees["STATUT"] = $_POST["STATUT"];
        else
            $donnees["STATUT"]='A';
        if(isset($_POST["COMMENTAIRE"]))
            $donnees["COMMENTAIRE"] = $_POST["COMMENTAIRE"];
        else
            $donnees["COMMENTAIRE"]='';
        //        var_dump($donnees);
        //        var_dump($ID_ACTIVITE);
        //        var_dump($NUM_CRENEAU);
        $colonnes = array('ID_ACTIVITE', 'DATE_CRENEAU', 'HEURE_CRENEAU', 'EFFECTIF_CRENEAU', 'STATUT', 'NUM_CRENEAU', 'COMMENTAIRE');
        $tab = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE, 'NUM_CRENEAU' => $NUM_CRENEAU),'donnees' => $donnees);
        //appeler la methode update
        $modCreneau->update($tab);
        $this->mailc($ID_ACTIVITE, "modifier", $NUM_CRENEAU);
        $this->liste();
        header('Location: ../liste');
    }

    function supprimerCreneau($id)
    {
        if ($id != FALSE) {
            $modCreneau = $this->loadModel('ActiviteCreneauAdmin');
            $ids = explode("_", $id);
            $ID_ACTIVITE = $ids[0];
            $NUM_CRENEAU = $ids[1];
            //$modActivite = $this->loadModel('ActiviteAdmin');
            $tab = array('conditions' => array('ID_ACTIVITE' => $ID_ACTIVITE, 'NUM_CRENEAU' => $NUM_CRENEAU));
            //appeler la methode delete
            $this->mailc($ID_ACTIVITE, "supprimer", $NUM_CRENEAU);
            $modCreneau->delete($tab);
        }
        $this->liste();
        header('Location: ../liste');
    }

    function ouvrir($id)
    {
        if ($id != FALSE) {
            $modActivite = $this->loadModel("ActiviteLeader");
            $donnees["STATUT"] = 'O';
            $tab = array('conditions' => array('ID_ACTIVITE' => $id), 'donnees' => $donnees);
            $modActivite->update($tab);

        }
        $this->liste();
        $this->render('liste');
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

    public function mail($idactivite, $mess){

        $configMail = new mailConfig();
        $mail = $configMail->config();

        //récupérer le nom de l'activité
        $nomactivite=$this->nomActivite($idactivite);


        switch ($mess){
            case "creer":
                $mail->Subject="Activité créée";
                $mail->Body="L'activité $nomactivite à été créée";
                break;
            case "modifier":
                $mail->Subject="Activité modifiée";
                $mail->Body="L'activité $nomactivite à été modifiée";
                break;

        }

        //Récupérer adresse leader
        $this->mailLeader($idactivite, $mail);

        //Récupérer adresses admins
        $this->mailAdmin($mail);

        $mail->send();
        $mail->smtpClose();
    }

    public function mailrappel($idactivite){

        $configMail = new mailConfig();
        $mail = $configMail->config();

        //récupérer le nom de l'activité
        $nomactivite=$this->nomActivite($idactivite);

        $this->mailAdherent($idactivite, $mail);

        $mail->Subject="Rappel du leader sur l'activité $nomactivite";
        $mail->Body="Bonjour, le leader vous envoi un rappel concernant l'activité $nomactivite, veuillez vérifier si votre créneau est proche ou si il y a eu des modifications";

        $mail->send();

        $this->inscrits($idactivite);
    }

    public function mailc($idactivite, $mess, $creneau){

        $configMail = new mailConfig();
        $mail = $configMail->config();

        //récupérer les adresses mail des adhérents à l'activité et au créneau voulu
        $this->mailAdherents($idactivite, $creneau, $mail);

        //récupérer le nom de l'activité
        $nomactivite = $this->nomActivite($idactivite);

        //récupérer la date et l'heure du créneau
        $modCreneau = $this->loadModel('Creneau');
        $projection['projection'] = 'Creneau.date_creneau as date, creneau.heure_creneau as heure';
        $projection['conditions'] = "Creneau.ID_ACTIVITE = {$idactivite} and Creneau.NUM_CRENEAU= {$creneau}";
        $resultc = $modCreneau->findfirst($projection);
        $date = $resultc->date;
        $heure = $resultc->heure;

        //récupérer l'adresse mail du leader de l'activité
        $this->mailLeader($idactivite, $mail);
//        $modInscription = $this->loadModel('ActiviteParticipantsLeader');
//        $projection['projection'] = 'ADHERENT.mail';
//        $projection['conditions'] = "ACTIVITE.ID_ACTIVITE = {$idactivite} and ACTIVITE.ID_LEADER=ADHERENT.ID_ADHERENT";
//        var_dump($projection);
//        $resultb = $modInscription->find($projection);


//        foreach($resultb as $dest){
//            $mail->addAddress($dest->mail);
//        }
        //ajout de la recherche des admins
        /*$modAdmin = $this->loadModel("Adherent");
        $projection['projection'] = 'ADHERENT.mail';
        $projection['conditions'] = "ADHERENT.GRADE = 'A'";
        $result = $modInscription->find($projection);*/
        $this->mailAdmin($mail);

        switch ($mess){
            case "modifier":
                $mail->Subject="Créneau modifié";
                $mail->Body="Le créneau du $date à $heure de l'activité $nomactivite à été modifié";

                break;
            case "supprimer":
                $mail->Subject="Créneau supprimé";
                $mail->Body="Le créneau du $date à $heure de l'activité $nomactivite à été supprimée";
                break;

        }
        $mail->send();
        $mail->smtpClose();

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

    public function mailAdherents($idactivite, $creneau, $mail){
        $modInscription = $this->loadModel('ActiviteParticipantsLeader');
        $projection['projection'] = 'ADHERENT.mail';
        $projection['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$idactivite} and INSCRIPTION.CRENEAU= {$creneau}";
        $result = $modInscription->find($projection);
        foreach($result as $dest){
            $mail->addAddress($dest->mail);
        }
    }

    public function mailAdherent($idactivite, $mail){
        $modInscription = $this->loadModel('ActiviteParticipantsLeader');
        $projection['projection'] = 'ADHERENT.mail';
        $projection['conditions'] = "INSCRIPTION.ID_ACTIVITE = {$idactivite}";
        $result = $modInscription->find($projection);
        foreach($result as $dest){
            $mail->addAddress($dest->mail);
        }
    }

    public function nomActivite($idactivite){
        $modActivite = $this->loadModel("Activite");
        $projection['projection'] = "ACTIVITE.nom";
        $projection['conditions'] = "ACTIVITE.ID_ACTIVITE = {$idactivite}";
        $result = $modActivite->findfirst($projection);
        //var_dump($result);
        foreach ($result as $nom){
            $nomactivite = $nom;
        }
        return $nomactivite;
    }

}

