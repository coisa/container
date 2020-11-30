<?php

/**
 * This file is part of coisa/container.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/coisa/container
 *
 * @copyright Copyright (c) 2019-2020 Felipe Sayão Lobato Abreu <github@felipeabreu.com.br>
 * @license   https://opensource.org/licenses/MIT MIT License
 */
namespace CoiSA\Container\Test\Unit\Factory;

use CoiSA\Container\Factory\ContainerFactory;
use CoiSA\Container\Test\Stub\ServiceProvider\ExampleOtherServiceProvider;
use CoiSA\Container\Test\Stub\ServiceProvider\ExampleServiceProvider;
use CoiSA\Factory\AbstractFactory;
use CoiSA\Factory\CallableFactory;
use CoiSA\ServiceProvider\AggregateServiceProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class ContainerFactoryTest.
 *
 * @package CoiSA\Container\Test\Unit\Factory
 */
final class ContainerFactoryTest extends TestCase
{
    /**
     * @var ContainerFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new ContainerFactory();
    }

    public function provideServiceProviders()
    {
        return array(
            array(),
            array(new ExampleServiceProvider()),
            array(new ExampleServiceProvider(), new ExampleOtherServiceProvider()),
            //array(ExampleServiceProvider::class),
            //array(ExampleServiceProvider::class, ExampleOtherServiceProvider::class),
        );
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testCreateWillReturnContainerWithGivenServiceProviders()
    {
        $serviceProviders         = \func_get_args();
        $aggregateServiceProvider = new AggregateServiceProvider($serviceProviders);

        AbstractFactory::setFactory(
            'CoiSA\\ServiceProvider\\AggregateServiceProvider',
            new CallableFactory(function() use ($aggregateServiceProvider) {
                return $aggregateServiceProvider;
            })
        );

        $container = \call_user_func_array(array($this->factory, 'create'), $serviceProviders);

        self::assertInstanceOf('CoiSA\\Container\\Container', $container);

        $reflectionProperty = new \ReflectionProperty('CoiSA\\Container\\Container', 'aggregateServiceProvider');
        $reflectionProperty->setAccessible(true);

        self::assertSame($aggregateServiceProvider, $reflectionProperty->getValue($container));
    }
}
