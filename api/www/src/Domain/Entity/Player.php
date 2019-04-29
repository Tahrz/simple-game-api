<?php declare(strict_types=1);

namespace Domain\Entity;

use Domain\VO\Uid;
use Domain\VO\Health;

/**
 * Class Player
 *
 * @package Domain\Entity
 */
class Player
{
    /**
     * @var Uid
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var Health
     */
    private $health;

    /**
     * @var Monsters|null
     */
    private $openedMonsters;

    /**
     * Player constructor.
     *
     * @param Uid $id
     * @param string $username
     * @param Health $health
     */
    public function __construct(
        Uid $id,
        string $username,
        Health $health
    )
    {
        $this->id = $id;
        $this->username = $username;
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return Health
     */
    public function getHealth(): Health
    {
        return $this->health;
    }

    public function updateOpenedMonsters(Monsters $openedMonsters): void
    {
        $this->openedMonsters = $openedMonsters;
    }

    /**
     * @return Monsters|null
     */
    public function getOpenedMonsters(): ?Monsters
    {
        return $this->openedMonsters;
    }
}