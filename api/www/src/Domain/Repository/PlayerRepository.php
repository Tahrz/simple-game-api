<?php declare(strict_types=1);

namespace Domain\Repository;

use Domain\Entity\Player;
use Domain\Entity\Monster;
use Domain\Entity\Players;
use Domain\Entity\Monsters;

/**
 * Interface PlayerRepository
 *
 * @package Domain\Repository
 */
interface PlayerRepository
{
    /**
     * @param string $userName
     * @return Player|null
     */
    public function findPlayer(string $userName): ?Player;

    /**
     * @param Player $player
     * @return Monsters|null
     */
    public function findPlayerOpenedMonsters(Player $player): ?Monsters;

    /**
     * @param Player $player
     * @param Monster $monster
     * @return bool
     */
    public function updatePlayerOpenedMonsters(Player $player, Monster $monster): bool;

    /**
     * @return Players
     */
    public function findAllPlayers(): Players;
}