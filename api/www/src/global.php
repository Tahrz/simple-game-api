<?php declare(strict_types=1);

use Application\Service\SQLConnector;
use Application\Service\NoSQLConnector;
use Domain\Repository\PlayerRepository;
use Domain\Repository\MonsterRepository;
use Infrastructure\Repository\SqlPlayerRepository;
use Infrastructure\Repository\SqlMonsterRepository;
use Infrastructure\Repository\NoSqlPlayerRepository;
use Infrastructure\Repository\NoSqlMonsterRepository;


/**
 * @return MonsterRepository
 */
function monsterRepository(): MonsterRepository
{
    if (SQL_MODE) {
        return new SqlMonsterRepository(new SQLConnector());
    }

    return new NoSqlMonsterRepository(new NoSQLConnector());
}

/**
 * @return PlayerRepository
 */
function playerRepository(): PlayerRepository
{
    if (SQL_MODE) {
        return new SqlPlayerRepository(new SQLConnector());
    }

    return new NoSqlPlayerRepository(new NoSQLConnector());
}