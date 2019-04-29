<?php declare(strict_types=1);

namespace Tests\Unit\Entity;

use Tests\Helper\PlayerFaker;
use PHPUnit\Framework\TestCase;

/**
 * Class PlayerTest
 *
 * @package Tests\Unit\Entity
 */
class PlayerTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testItIsValidIntegrity()
    {
        $entity = (new PlayerFaker())->create();

        $reflectionClass = new \ReflectionClass($entity);
        $properties = [];
        $methods = [];

        foreach ($reflectionClass->getProperties() as $property) {
            $properties[] = $property->getName();
        }

        foreach ($reflectionClass->getMethods() as $method) {
            $methods[] = $method->getName();
        }

        static::assertEquals($properties, [
            'id',
            'username',
            'health',
            'openedMonsters'
        ]);

        static::assertEquals($methods, [
            '__construct',
            'getId',
            'getUsername',
            'getHealth',
            'updateOpenedMonsters',
            'getOpenedMonsters'
        ]);
    }
}