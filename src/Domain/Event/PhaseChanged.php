<?php

namespace App\Domain\Event;

use App\Domain\Enum\GameStatus;

class PhaseChanged
{
    public function __construct(
        public readonly string     $gameId,
        public readonly string     $gameCode,
        public readonly GameStatus $newStatus
    )
    {
    }
}
