<?php

namespace App\Enum;

enum PlayerRole: string
{
    case HOST     = 'host';
    case MAFIA    = 'mafia';
    case DOCTOR   = 'doctor';
    case SHERIFF  = 'sheriff';
    case CIVILIAN = 'civilian';
}
