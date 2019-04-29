<?php declare(strict_types=1);

namespace Infrastructure\Factory;

use Exception;
use Domain\VO\Uid;
use Domain\VO\Health;
use Domain\Entity\Player;

/**
 * Class PlayerFactory
 *
 * @package Infrastructure\Factory
 */
class PlayerFactory
{
    /**
     * @param array $player
     * @return Player
     * @throws Exception
     */
    public function __invoke(array $player): Player
    {
        return new Player(
            new Uid($player['id']),
            $player['username'],
            new Health($player['health'])
        );
    }
}