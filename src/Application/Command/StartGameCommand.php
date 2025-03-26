<?php

namespace App\Application\Command;

class StartGameCommand
{
    public function __construct(public string $gameCode)
    {
    }
}
