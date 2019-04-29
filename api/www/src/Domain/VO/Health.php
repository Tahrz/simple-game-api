<?php declare(strict_types=1);

namespace Domain\VO;

use Exception;

/**
 * Class Health
 *
 * @package Domain\VO
 */
final class Health
{
    /**
     * @var int
     */
    private $health;

    /**
     * Health constructor.
     *
     * @param int $health
     * @throws Exception
     */
    public function __construct(int $health)
    {
        if (($health < 0) || ($health > 100)) {
            throw new Exception('Health value must be from 0 to 100', 422);
        }

        $this->health = $health;
    }

    /**
     * @return int
     */
    public function getHealth(): int
    {
        return $this->health;
    }
}