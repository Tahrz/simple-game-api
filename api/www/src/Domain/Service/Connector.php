<?php declare(strict_types=1);

namespace Domain\Service;

use Domain\VO\Uid;

/**
 * Interface Connector
 *
 * @package Domain\Service
 */
interface Connector
{
    /**
     * @param string $tableName
     * @param array $params
     * @return array
     */
    public function findOne(string $tableName, array $params): array;

    /**
     * @param string $tableName
     * @param array $params
     * @return array
     */
    public function findAll(string $tableName, array $params): array;

    /**
     * @param string $tableName
     * @param Uid $id
     * @param array $params
     */
    public function update(string $tableName, Uid $id, array $params): void;

    /**
     * @param string $tableName
     * @param array $params
     */
    public function add(string $tableName, array $params): void;

    /**
     * @param string $query
     * @param array $params
     * @return array
     */
    public function customQuery(string $query, array $params): array;
}