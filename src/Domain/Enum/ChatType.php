<?php

namespace App\Domain\Enum;

enum ChatType: string
{
    case GENERAL = 'general';
    case MAFIA   = 'mafia';
}
