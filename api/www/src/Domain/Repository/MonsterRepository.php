<?php declare(strict_types=1);

namespace Domain\Repository;

use Domain\VO\Uid;
use Domain\Entity\Monster;
use Domain\Entity\Monsters;

/**
 * Interface MonsterRepository
 *
 * @package Domain\Repository
 */
interface MonsterRepository
{
    /**
     * @param Uid $id
     * @return Monster|null
     */
    public function findMonster(Uid $id): ?Monster;

    /**
     * @return Monsters
     */
    public function findAllMonsters(): Monsters;
}