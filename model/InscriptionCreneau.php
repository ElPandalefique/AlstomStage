<?php

class InscriptionCreneau extends Model {
    //put your code here
        var $table = 'CRENEAU c
LEFT JOIN INSCRIPTION i on c.NUM_CRENEAU = i.CRENEAU AND c.ID_ACTIVITE = i.ID_ACTIVITE';

    
}
