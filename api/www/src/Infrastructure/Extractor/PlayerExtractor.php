<?php declare(strict_types=1);

namespace Infrastructure\Extractor;

use Domain\Entity\Player;

/**
 * Class PlayerExtractor
 *
 * @package Infrastructure\Extractor
 */
class PlayerExtractor
{
    /**
     * @param Player $player
     * @return array
     */
    public function extract(Player $player): array
    {
        return [
            'id' => $player->getId()->getId(),
            'username' => $player->getUsername(),
            'health' => $player->getHealth()->getHealth()
        ];
    }
}