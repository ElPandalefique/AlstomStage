<?php

class InvitePrestation extends Model {
    //put your code here
        var $table = 'INSCRIPTION
        LEFT OUTER JOIN LISTE_INVITES ON INSCRIPTION.ID = LISTE_INVITES.ID_INSCRIPTION
        LEFT OUTER JOIN INVITE ON ID_PERS_EXTERIEUR = LISTE_INVITES.ID_INVITE
        ';

}
