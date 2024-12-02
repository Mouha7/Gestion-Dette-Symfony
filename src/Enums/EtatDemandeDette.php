<?php

namespace App\Enums;

enum EtatDemandeDette: string 
{
    case ENCOURS = 'En cours';
    case ANNULE = 'Annulée';
    case VALIDE = 'Validé';
}