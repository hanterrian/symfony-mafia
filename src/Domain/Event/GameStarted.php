<?php

namespace App\Domain\Event;

class GameStarted
{
    public function __construct(
        public readonly string $gameId,
        public readonly string $gameCode
    )
    {
    }
}
