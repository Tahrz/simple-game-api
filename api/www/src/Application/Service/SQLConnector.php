<?php declare(strict_types=1);

namespace Application\Service;

use PDO;
use PDOException;
use Domain\VO\Uid;
use Domain\Service\Connector;

/**
 * Class SQLConnector
 *
 * @package Application\Service
 */
final class SQLConnector implements Connector
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';user=' . DB_USER . ';password=' . DB_PASSWORD
            );
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param string $tableName
     * @param array $params
     * @return array
     */
    public function findAll(string $tableName, array $params): array
    {
        $paramsList = '*';
        if ($params) {
            $paramsKeyValueList = $this->prepareValues($params);
        }

        $preparedQuery = $this->connection->prepare('SELECT ' . $paramsList . ' FROM ' . $tableName . ($params ? ' WHERE ' . $paramsKeyValueList : ''));
        $preparedQuery->execute($params);
        $result = $preparedQuery->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }

    /**
     * @param string $tableName
     * @param array $params
     * @return array
     */
    public function findOne(string $tableName, array $params): array
    {
        $paramsList = '*';
        $paramsKeyValueList = $this->prepareValues($params);
        $preparedQuery = $this->connection->prepare('SELECT ' . $paramsList . ' FROM ' . $tableName . ' WHERE ' . $paramsKeyValueList);
        $preparedQuery->execute($params);
        $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }

    /**
     * @param string $tableName
     * @param Uid $id
     * @param array $params
     */
    public function update(string $tableName, Uid $id, array $params): void
    {
    }

    /**
     * @param string $tableName
     * @param array $params
     */
    public function add(string $tableName, array $params): void
    {
        $preparedData = $this->prepareColumnsAndValues($params);
        $preparedQuery = $this->connection->prepare(
            'INSERT INTO ' . $tableName . ' (' . $preparedData['columns'] . ')' .
            ' VALUES ' . '(' . $preparedData['paramsKeyValueList'] . ')'
        );
        $preparedQuery->execute($params);

        if ($preparedQuery->errorCode() !== '00000') {
            throw new PDOException($preparedQuery->errorInfo()[2]);
        }

        $preparedQuery->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     * @param array $params
     * @return array
     */
    public function customQuery(string $query, array $params): array
    {
        $preparedQuery = $this->connection->prepare($query);
        $preparedQuery->execute($params);
        $result = $preparedQuery->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }

    /**
     * @param array $params
     * @return string
     */
    private function prepareValues(array $params): string
    {
        $paramsKeyValueList = '';
        foreach ($params as $key => $param) {
            $paramsKeyValueList .= $key . ' = :' . $key;
            if ($key !== array_keys($params)[count($params) - 1]) {
                $paramsKeyValueList .= ',';
            }
        }

        return $paramsKeyValueList;
    }

    /**
     * @param array $params
     * @return array
     */
    private function prepareColumnsAndValues(array $params): array
    {
        $paramsKeyValueList = '';
        $columns = '';

        foreach ($params as $key => $param) {
            $paramsKeyValueList .= ':' . $key;
            $columns .= $key;
            if ($key !== array_keys($params)[count($params) - 1]) {
                $paramsKeyValueList .= ', ';
                $columns .= ', ';
            }
        }

        return [
            'columns' => $columns,
            'paramsKeyValueList' => $paramsKeyValueList
        ];
    }
}