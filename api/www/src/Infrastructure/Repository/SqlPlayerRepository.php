<?php declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Entity\Player;
use Domain\Entity\Monster;
use Domain\Entity\Monsters;
use Domain\Entity\Players;
use Domain\Service\Connector;
use Domain\Repository\PlayerRepository;
use Infrastructure\Factory\PlayerFactory;
use Infrastructure\Factory\MonsterFactory;

/**
 * Class SqlPlayerRepository
 *
 * @package Infrastructure\Repository
 */
class SqlPlayerRepository implements PlayerRepository
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * SqlPlayerRepository constructor.
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

        return $result ? (new PlayerFactory())($result) : null;
    }

    /**
     * @return Players
     */
    public function findAllPlayers(): Players
    {
        $result = $this->connector->findAll('players', []);

        //TODO some CollectorHelper;
        $players = new Players();
        foreach ($result as $player) {
            $players->add((new PlayerFactory())($player));
        }

        return $players;
    }

    /**
     * @param Player $player
     * @return Monsters|null
     */
    public function findPlayerOpenedMonsters(Player $player): ?Monsters
    {
        $result = $this->connector->customQuery(
            'SELECT m.id, m.name, m.health FROM players p 
                    JOIN player_opened_monsters pom ON p.id = pom.player
                    JOIN monsters m on pom.monster = m.id
                    WHERE p.username = :userName',
            [
                        'userName' => $player->getUsername()
            ]) ?? [];

        if (!$result) {
            return null;
        }

        $monsters = new Monsters();
        foreach ($result as $monster) {
            $monsters->add((new MonsterFactory())($monster));
        }

        return $monsters;
    }

    /**
     * @param Player $player
     * @param Monster $monster
     * @return bool
     */
    public function updatePlayerOpenedMonsters(Player $player, Monster $monster): bool
    {
        if ($canBeOpened = $this->canBeOpenedCheck($player, $monster)) {
            $this->connector->add('player_opened_monsters', [
                'player' => $player->getId()->getId(),
                'monster' => $monster->getId()->getId()
            ]);
        }

        return $canBeOpened;
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
}