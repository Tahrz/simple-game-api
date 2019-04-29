<?php declare(strict_types=1);

namespace Tests\Helper;

use Domain\VO\Uid;
use Domain\VO\Health;
use Domain\Entity\Player;
use Utility\Test\EntityFaker;

/**
 * Class MonsterFaker
 *
 * @package Tests\Helper
 */
class PlayerFaker extends EntityFaker
{
    /**
     * @return Player
     * @throws \Exception
     */
    public function create(): Player
    {
        return new Player(
            new Uid(substr($this->faker->slug, 0, 24)),
            $this->faker->text(20),
            new Health($this->faker->numberBetween(1, 100))
        );
    }
}