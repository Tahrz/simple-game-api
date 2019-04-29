<?php declare(strict_types=1);

namespace Infrastructure\Factory;

use Exception;
use Domain\VO\Uid;
use Domain\VO\Health;
use Domain\Entity\Monster;

/**
 * Class MonsterFactory
 *
 * @package Infrastructure\Factory
 */
class MonsterFactory
{
    /**
     * @param array $monster
     * @return Monster
     * @throws Exception
     */
    public function __invoke(array $monster): Monster
    {
        return new Monster(
            new Uid($monster['id']),
            $monster['name'],
            new Health($monster['health'])
        );
    }
}