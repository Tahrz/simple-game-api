<?php declare(strict_types=1);

namespace Domain\Entity;

use Utility\Collection\Collection;

/**
 * Class Players
 *
 * @package Domain\Entity
 */
final class Players extends Collection
{
    /**
     * @param Player $player
     */
    public function add(Player $player): void
    {
        $this->items[] = $player;
    }
}