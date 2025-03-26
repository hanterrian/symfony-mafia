<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Game\Game;
use App\Domain\Player\Player;
use App\Domain\Repository\GameRepositoryInterface;
use App\Infrastructure\Doctrine\Entity\GameEntity;
use App\Infrastructure\Doctrine\Entity\PlayerEntity;
use Doctrine\ORM\EntityManagerInterface;

class GameRepository implements GameRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function save(Game $game): void
    {
        $entity = new GameEntity($game->getId(), $game->getCode(), $game->getHostName());
        $entity->setStatus($game->getStatus());

        foreach ($game->getPlayers() as $player) {
            $playerEntity = new PlayerEntity(
                $player->getId(),
                $player->getName(),
                $player->getRole(),
                $entity,
                $player->isHost()
            );
            $playerEntity->setIsAlive($player->isAlive());
            $this->em->persist($playerEntity);
        }

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function findByCode(string $code): ?Game
    {
        $entity = $this->em->getRepository(GameEntity::class)->findOneBy(['code' => $code]);
        return $entity ? $this->toDomain($entity) : null;
    }

    public function find(string $id): ?Game
    {
        $entity = $this->em->getRepository(GameEntity::class)->find($id);
        return $entity ? $this->toDomain($entity) : null;
    }

    private function toDomain(GameEntity $entity): Game
    {
        $game = new Game($entity->getId(), $entity->getCode(), $entity->getHostName(), $entity->getStatus());

        foreach ($entity->getPlayers() as $playerEntity) {
            $player = new Player(
                $playerEntity->getId(),
                $playerEntity->getName(),
                $playerEntity->getRole(),
                $playerEntity->isHost(),
                $playerEntity->isAlive()
            );
            $game->addPlayer($player);
        }

        return $game;
    }
}
