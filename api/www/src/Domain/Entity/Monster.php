<?php declare(strict_types=1);

namespace Domain\Entity;

use Domain\VO\Uid;
use Domain\VO\Health;

/**
 * Class Monster
 *
 * @package Domain\Entity
 */
class Monster
{
    /**
     * @var Uid
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Health
     */
    private $health;

    /**
     * Monster constructor.
     *
     * @param Uid $id
     * @param string $name
     * @param Health $health
     */
    public function __construct(
        Uid $id,
        string $name,
        Health $health
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->health = $health;
    }

    /**
     * @return Uid
     */
    public function getId(): Uid
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Health
     */
    public function getHealth(): Health
    {
        return $this->health;
    }
}