<?php

namespace App\Enums;

enum EtatDette: string
{
    case ENCOURS = 'En cours';
    case SOLDE = 'Soldée';
}