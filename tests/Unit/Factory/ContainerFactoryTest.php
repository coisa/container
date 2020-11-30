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
use CoiSA\Factory\ProphecyFactory;
use PHPUnit\Framework\Assert;
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
    public function testCreateWillCallAbstractFactoryCreateForAggregateServiceProviderWithGivenServiceProviders()
    {
        $serviceProviders         = \func_get_args();
        $aggregateServiceProvider = $this->prophesize('CoiSA\\ServiceProvider\\AggregateServiceProvider');

        AbstractFactory::setFactory(
            'CoiSA\\ServiceProvider\\AggregateServiceProvider',
            new ProphecyFactory(
                $aggregateServiceProvider,
                function ($objectProphecy, array $arguments) use ($serviceProviders) {
                    Assert::assertEquals($serviceProviders, $arguments[0]);
                }
            )
        );

        \call_user_func_array(array($this->factory, 'create'), $serviceProviders);
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testCreateWillReturnContainerWithGivenServiceProviders()
    {
        $serviceProviders         = \func_get_args();
        $aggregateServiceProvider = $this->prophesize('CoiSA\\ServiceProvider\\AggregateServiceProvider');

        AbstractFactory::setFactory(
            'CoiSA\\ServiceProvider\\AggregateServiceProvider',
            new ProphecyFactory($aggregateServiceProvider)
        );

        $container = \call_user_func_array(array($this->factory, 'create'), $serviceProviders);

        self::assertInstanceOf('CoiSA\\Container\\Container', $container);

        $reflectionProperty = new \ReflectionProperty('CoiSA\\Container\\Container', 'aggregateServiceProvider');
        $reflectionProperty->setAccessible(true);

        self::assertSame($aggregateServiceProvider->reveal(), $reflectionProperty->getValue($container));
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testCreateWillSetContainerForAbstractFactory()
    {
        $serviceProviders         = \func_get_args();
        $aggregateServiceProvider = $this->prophesize('CoiSA\\ServiceProvider\\AggregateServiceProvider');

        AbstractFactory::setFactory(
            'CoiSA\\ServiceProvider\\AggregateServiceProvider',
            new ProphecyFactory($aggregateServiceProvider)
        );

        $container = \call_user_func_array(array($this->factory, 'create'), $serviceProviders);

        $reflectionProperty = new \ReflectionProperty('CoiSA\\Factory\\FactoryAbstractFactory', 'container');
        $reflectionProperty->setAccessible(true);

        self::assertSame($container, $reflectionProperty->getValue());
    }
}
