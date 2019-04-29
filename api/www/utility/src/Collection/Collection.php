<?php declare(strict_types=1);

namespace Utility\Collection;

/**
 * Class Collection
 *
 * @package Utility\Collection
 */
class Collection
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}