<?php declare(strict_types=1);

namespace Tests\Unit\Entity;

use Tests\Helper\MonsterFaker;
use PHPUnit\Framework\TestCase;

class MonsterTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testItIsValidIntegrity()
    {
        $entity = (new MonsterFaker())->create();

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
            'name',
            'health'
        ]);

        static::assertEquals($methods, [
            '__construct',
            'getId',
            'getName',
            'getHealth'
        ]);
    }
}