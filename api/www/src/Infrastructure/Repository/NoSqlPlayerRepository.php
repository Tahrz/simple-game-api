<?php declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Entity\Player;
use Domain\Entity\Players;
use MongoDB\BSON\ObjectId;
use Domain\Entity\Monster;
use Domain\Entity\Monsters;
use Domain\Service\Connector;
use Domain\Repository\PlayerRepository;
use Infrastructure\Factory\PlayerFactory;
use Infrastructure\Factory\MonsterFactory;
/**
 * Class NoSqlPlayerRepository
 *
 * @package Infrastructure\Repository
 */
class NoSqlPlayerRepository implements PlayerRepository
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
     * @param string $userName
     * @return Player|null
     */
    public function findPlayer(string $userName): ?Player
    {
        $result = $this->connector->findOne('players', ['username' => $userName]);

        if (!$result) {
            return null;
        }

        /* @var Player $player */
        $player = (new PlayerFactory())(array_merge($result, ['id' => $result['_id']['$oid']]));

        if (isset($result['opened_monsters'])) {
            $player->updateOpenedMonsters($this->getOpenedMonsters($result['opened_monsters']));
        }

        return $player;
    }

    /**
     * @param Player $player
     * @return Monsters|null
     */
    public function findPlayerOpenedMonsters(Player $player): ?Monsters
    {
        if ($player->getOpenedMonsters()) {
            $result = $this->connector->findAll('monsters', [
                '_id' => ['$in' => $this->getMonstersOpenedByPlayerAsArray($player)]
            ]);

            return $this->hydrateMonsters($result);
        }

        return null;
    }

    /**
     * @param Player $player
     * @param Monster $monster
     * @return bool
     */
    public function updatePlayerOpenedMonsters(Player $player, Monster $monster): bool
    {
        if ($canBeOpened = $this->canBeOpenedCheck($player, $monster)) {

            $openedMonsters = $this->getMonstersOpenedByPlayerAsArray($player);
            $this->connector->update('players', $player->getId(),
                [
                    'opened_monsters' => array_merge($openedMonsters, [
                        (new ObjectId($monster->getId()->getId()))
                    ])
                ]
            );
        }

        return $canBeOpened;
    }

    /**
     * @return Players
     */
    public function findAllPlayers(): Players
    {
        $result = $this->connector->findAll('players', []);
        $players = new Players();

        foreach ($result as $player) {
            $players->add((new PlayerFactory())(array_merge($player, ['id' => $player['_id']['$oid']])));
        }

        return $players;
    }

    /**
     * @param Player $player
     * @return array
     */
    private function getMonstersOpenedByPlayerAsArray(Player $player): array
    {
        $openedMonsters = [];

        if ($player->getOpenedMonsters()) {
            foreach ($player->getOpenedMonsters()->getItems() as $item) {
                array_push($openedMonsters, new ObjectId($item->getId()->getId()));
            }
        }

        return $openedMonsters;
    }


    /**
     * @param Player $player
     * @param Monster $monster
     * @return bool
     */
    private function canBeOpenedCheck(Player $player, Monster $monster): bool
    {
        $canBeOpened = true;

        if ($alreadyOpenedMonsters = $this->findPlayerOpenedMonsters($player)) {
            foreach ($alreadyOpenedMonsters->getItems() as $alreadyOpenedMonster) {
                if ($alreadyOpenedMonster->getId()->getId() === $monster->getId()->getId()) {
                    $canBeOpened = false;
                }
            }
        }

        return $canBeOpened;
    }

    /**
     * @param array $openedMonsters
     * @return Monsters
     */
    private function getOpenedMonsters(array $openedMonsters): Monsters
    {
        $arrayMonsters = $this->connector->findAll('monsters', [
            '_id' => ['$in' => $this->prepareObjectIdMonsters($openedMonsters)]
        ]);

        return $this->hydrateMonsters($arrayMonsters);
    }

    /**
     * @param array $openedMonsters
     * @return array
     */
    private function prepareObjectIdMonsters(array $openedMonsters): array
    {
        $monsters = [];
        foreach ($openedMonsters as $monster) {
            array_push($monsters, new ObjectId($monster['$oid']));
        }

        return $monsters;
    }

    /**
     * @param array $arrayMonsters
     * @return Monsters
     */
    private function hydrateMonsters(array $arrayMonsters): Monsters
    {
        $monsters = new Monsters();
        foreach ($arrayMonsters as $arrayMonster) {
            $monsters->add(((new MonsterFactory())(array_merge($arrayMonster, ['id' => $arrayMonster['_id']['$oid']]))));
        }

        return $monsters;
    }
}