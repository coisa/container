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
use CoiSA\Factory\FactoryInterface;
use CoiSA\ServiceProvider\AggregateServiceProvider;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Class ContainerFactoryTest.
 *
 * @package CoiSA\Container\Test\Unit\Factory
 */
final class ContainerFactoryTest extends TestCase
{
    /**
     * @var ObjectProphecy|AggregateServiceProvider
     */
    private $aggregateServiceProvider;

    /**
     * @var ObjectProphecy|FactoryInterface
     */
    private $factory;

    /**
     * @var ContainerFactory
     */
    private $containerFactory;

    public function setUp()
    {
        $this->aggregateServiceProvider = $this->prophesize('CoiSA\\ServiceProvider\\AggregateServiceProvider');
        $this->factory                  = $this->prophesize('CoiSA\\Factory\\FactoryInterface');

        $this->factory->create(Argument::any())->willReturn(
            $this->aggregateServiceProvider->reveal()
        );

        AbstractFactory::setFactory(
            'CoiSA\\ServiceProvider\\AggregateServiceProvider',
            $this->factory->reveal()
        );

        $this->containerFactory = new ContainerFactory($this->factory->reveal());
    }

    public function provideServiceProviders()
    {
        return array(
            array(),
            array(new ExampleServiceProvider()),
            array(new ExampleServiceProvider(), new ExampleOtherServiceProvider()),
        );
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testConstructWithoutFactoryWillCreateAbstractFactoryForAggregateServiceProvider()
    {
        $serviceProviders = \func_get_args();

        $this->factory->create($serviceProviders)->shouldBeCalledOnce();

        $this->containerFactory = new ContainerFactory();

        \call_user_func_array(array($this->containerFactory, 'create'), $serviceProviders);
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testCreateWillCallConstructorFactoryCreateWithGivenServiceProviders()
    {
        $serviceProviders = \func_get_args();

        $this->factory->create($serviceProviders)->shouldBeCalledOnce();

        \call_user_func_array(array($this->containerFactory, 'create'), $serviceProviders);
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testCreateWillReturnContainerWithGivenServiceProviders()
    {
        $serviceProviders = \func_get_args();

        $container = \call_user_func_array(array($this->containerFactory, 'create'), $serviceProviders);

        self::assertInstanceOf('CoiSA\\Container\\Container', $container);

        $reflectionProperty = new \ReflectionProperty('CoiSA\\Container\\Container', 'aggregateServiceProvider');
        $reflectionProperty->setAccessible(true);

        self::assertSame($this->aggregateServiceProvider->reveal(), $reflectionProperty->getValue($container));
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testCreateWillSetContainerForAbstractFactory()
    {
        $serviceProviders  = \func_get_args();

        $container = \call_user_func_array(array($this->containerFactory, 'create'), $serviceProviders);

        $reflectionProperty = new \ReflectionProperty('CoiSA\\Factory\\FactoryAbstractFactory', 'container');
        $reflectionProperty->setAccessible(true);

        self::assertSame($container, $reflectionProperty->getValue());
    }
}
