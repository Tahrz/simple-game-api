<?php declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\VO\Uid;
use Domain\Entity\Monster;
use MongoDB\BSON\ObjectId;
use Domain\Entity\Monsters;
use Domain\Service\Connector;
use Domain\Repository\MonsterRepository;
use Infrastructure\Factory\MonsterFactory;

/**
 * Class NoSqlMonsterRepository
 *
 * @package Infrastructure\Repository
 */
class NoSqlMonsterRepository implements MonsterRepository
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
     * @param Uid $id
     * @return Monster|null
     */
    public function findMonster(Uid $id): ?Monster
    {
        $result = $this->connector->findOne('monsters', ['_id' => (new ObjectId($id->getId()))]);

        return $result ? (new MonsterFactory())(array_merge($result, ['id' => $result['_id']['$oid']])) : null;
    }

    /**
     * @return Monsters
     */
    public function findAllMonsters(): Monsters
    {
        $result = $this->connector->findAll('monsters', []);
        $monsters = new Monsters();

        foreach ($result as $monster) {
            $monsters->add((new MonsterFactory())(array_merge($monster, ['id' => $monster['_id']['$oid']])));
        }

        return $monsters;
    }
}