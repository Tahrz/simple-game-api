<?php declare(strict_types=1);

namespace Domain\Entity;

use Utility\Collection\Collection;

/**
 * Class Monsters
 *
 * @package Domain\Entity
 */
final class Monsters extends Collection
{
    /**
     * @param Monster $monster
     */
    public function add(Monster $monster): void
    {
        $this->items[] = $monster;
    }
}