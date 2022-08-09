<?php

declare(strict_types=1);

/**
 * This file is part of coisa/container.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/coisa/container
 * @copyright Copyright (c) 2019-2022 Felipe Sayão Lobato Abreu <github@felipeabreu.com.br>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace CoiSA\Container\Test\Unit\Factory;

use CoiSA\Container\Factory\ContainerFactory;
use CoiSA\Container\Test\Stub\ServiceProvider\ExampleOtherServiceProvider;
use CoiSA\Container\Test\Stub\ServiceProvider\ExampleServiceProvider;
use CoiSA\ServiceProvider\AggregateServiceProvider;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Class ContainerFactoryTest.
 *
 * @package CoiSA\Container\Test\Unit\Factory
 *
 * @internal
 * @coversNothing
 */
final class ContainerFactoryTest extends TestCase
{
    /**
     * @var AggregateServiceProvider|ObjectProphecy
     */
    private $aggregateServiceProvider;

    /**
     * @var ContainerFactory
     */
    private $containerFactory;

    protected function setUp(): void
    {
        $this->aggregateServiceProvider = $this->prophesize('CoiSA\\ServiceProvider\\AggregateServiceProvider');
        $this->containerFactory         = new ContainerFactory($this->aggregateServiceProvider->reveal());
    }

    public function provideServiceProviders()
    {
        return [
            [],
            [new ExampleServiceProvider()],
            [new ExampleServiceProvider(), new ExampleOtherServiceProvider()],
        ];
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testCreateWillCallConstructorFactoryCreateWithGivenServiceProviders(): void
    {
        $serviceProviders = \func_get_args();

        foreach ($serviceProviders as $serviceProvider) {
            $this->aggregateServiceProvider->append($serviceProvider)->shouldBeCalledOnce();
        }

        \call_user_func_array([$this->containerFactory, 'create'], $serviceProviders);
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testCreateWillReturnContainerWithGivenServiceProviders(): void
    {
        $serviceProviders = \func_get_args();

        $container = \call_user_func_array([$this->containerFactory, 'create'], $serviceProviders);

        static::assertInstanceOf('CoiSA\\Container\\Container', $container);

        $reflectionProperty = new \ReflectionProperty('CoiSA\\Container\\Container', 'aggregateServiceProvider');
        $reflectionProperty->setAccessible(true);

        static::assertSame($this->aggregateServiceProvider->reveal(), $reflectionProperty->getValue($container));
    }

    /**
     * @dataProvider provideServiceProviders
     */
    public function testCreateWillSetContainerForAbstractFactory(): void
    {
        $serviceProviders  = \func_get_args();

        $container = \call_user_func_array([$this->containerFactory, 'create'], $serviceProviders);

        $reflectionProperty = new \ReflectionProperty('CoiSA\\Factory\\FactoryAbstractFactory', 'container');
        $reflectionProperty->setAccessible(true);

        static::assertSame($container, $reflectionProperty->getValue());
    }
}
