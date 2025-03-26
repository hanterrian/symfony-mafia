<?php

namespace App\Domain\Repository;

use App\Domain\Game\Game;

interface GameRepositoryInterface
{
    public function save(Game $game): void;

    public function findByCode(string $code): ?Game;

    public function find(string $id): ?Game;
}
