<?php

namespace App\Application\Command;

class JoinGameCommand
{
    public function __construct(
        public string $gameCode,
        public string $playerName
    )
    {
    }
}
