<?php declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\VO\Uid;
use Domain\Entity\Monster;
use Domain\Entity\Monsters;
use Domain\Service\Connector;
use Domain\Repository\MonsterRepository;
use Infrastructure\Factory\MonsterFactory;

/**
 * Class SqlMonsterRepository
 *
 * @package Infrastructure\Repository
 */
class SqlMonsterRepository implements MonsterRepository
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * SqlMonsterRepository constructor.
     *
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param Uid $uid
     * @return Monster|null
     */
    public function findMonster(Uid $uid): ?Monster
    {
        $result = $this->connector->findOne('monsters', ['id' => $uid->getId()]);

        return $result ? (new MonsterFactory())($result) : null;
    }

    /**
     * @return Monsters
     */
    public function findAllMonsters(): Monsters
    {
        $result = $this->connector->findAll('monsters', []);
        $monsters = new Monsters();

        foreach ($result as $monster) {
            $monsters->add((new MonsterFactory())($monster));
        }

        return $monsters;
    }
}