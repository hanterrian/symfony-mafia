<?php

namespace App\Application\Command;

class NextPhaseCommand
{
    public function __construct(public string $gameCode)
    {
    }
}
