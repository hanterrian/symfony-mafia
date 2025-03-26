<?php

namespace App\Domain\Enum;

enum GameStatus: string
{
    case LOBBY    = 'lobby';
    case NIGHT    = 'night';
    case DAY      = 'day';
    case VOTING   = 'voting';
    case FINISHED = 'finished';
}
