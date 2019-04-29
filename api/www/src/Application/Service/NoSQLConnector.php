<?php declare(strict_types=1);

namespace Application\Service;

use Domain\VO\Uid;
use MongoDB\Client;
use MongoDB\Database;
use MongoDB\BSON\ObjectId;
use Domain\Service\Connector;
use function MongoDB\BSON\toJSON;
use function MongoDB\BSON\fromPHP;

/**
 * Class NoSQLConnector
 *
 * @package Application\Service
 */
final class NoSQLConnector implements Connector
{
    /**
     * @var Database
     */
    private $connection;

    /**
     * NoSQLConnector constructor.
     */
    public function __construct()
    {
        $db = MONGO_DB;
        $this->connection = (new Client("mongodb://" . MONGO_DB_HOST . ":" . MONGO_DB_PORT))->$db;
    }

    /**
     * @param string $tableName
     * @param array $params
     * @return array
     */
    public function findAll(string $tableName, array $params): array
    {
        $itemsArray = [];
        $result = $this->connection->$tableName->find($params)->toArray();

        foreach ($result as $item) {
            array_push($itemsArray, json_decode(toJSON(fromPHP($item)), true));
        }

        return $itemsArray;
    }

    /**
     * @param string $tableName
     * @param array $params
     * @return array
     */
    public function findOne(string $tableName, array $params): array
    {
        $result = $this->connection->$tableName->findOne($params);

        return $result ? json_decode(toJSON(fromPHP($result)), true) : [];
    }

    /**
     * @param string $tableName
     * @param Uid $id
     * @param array $params
     */
    public function update(string $tableName, Uid $id, array $params): void
    {
        $this->connection->$tableName->updateOne([
            '_id' => new ObjectId($id->getId())
        ], [
            '$set' => $params
        ]);
    }

    /**
     * @param string $tableName
     * @param array $params
     */
    public function add(string $tableName, array $params): void
    {
        $this->connection->$tableName->insertOne($params);
    }

    /**
     * @param string $query
     * @param array $params
     * @return array
     */
    public function customQuery(string $query, array $params): array
    {
    }
}