<?php declare(strict_types=1);

namespace Infrastructure\Extractor;

use Domain\Entity\Monster;

/**
 * Class MonsterExtractor
 *
 * @package Infrastructure\Extractor
 */
class MonsterExtractor
{
    /**
     * @param Monster $monster
     * @return array
     */
    public function extract(Monster $monster): array
    {
        return [
            'id' => $monster->getId()->getId(),
            'name' => $monster->getName()
        ];
    }
}