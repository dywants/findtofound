<?php

namespace App\Enum;

enum PieceCondition: string
{
    case Excellent = 'Excellent';
    case Bon = 'Bon';
    case Moyen = 'Moyen';
    case Mauvais = 'Mauvais';
}