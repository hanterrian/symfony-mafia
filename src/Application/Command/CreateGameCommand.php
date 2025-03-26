<?php

namespace App\Application\Command;

class CreateGameCommand
{
    public function __construct(public string $hostName)
    {
    }
}
