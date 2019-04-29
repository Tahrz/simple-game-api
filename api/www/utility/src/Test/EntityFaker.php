<?php declare(strict_types=1);

namespace Utility\Test;

use Faker\Factory;

/**
 * Class EntityFaker
 *
 * @package Utility\Test
 */
abstract class EntityFaker
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * EntityFaker constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }
}