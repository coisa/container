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

namespace CoiSA\Container\Factory;

use CoiSA\Container\Container;
use CoiSA\Container\ContainerInterface;
use CoiSA\Factory\AbstractFactory;
use CoiSA\Factory\Exception\InvalidArgumentException;
use CoiSA\ServiceProvider\AggregateServiceProvider;
use CoiSA\ServiceProvider\Exception\ReflectionException;
use CoiSA\ServiceProvider\LaminasConfigServiceProvider;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;

/**
 * Class ContainerFactory.
 *
 * @package CoiSA\Container\Factory
 */
final class ContainerFactory implements ContainerFactoryInterface
{
    /**
     * @var AggregateServiceProvider
     */
    private $aggregateServiceProvider;

    /**
     * ContainerFactory constructor.
     */
    public function __construct(AggregateServiceProvider $aggregateServiceProvider)
    {
        $this->aggregateServiceProvider = $aggregateServiceProvider;
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function create(): ContainerInterface
    {
        $serviceProviders = \func_get_args();
        $container        = new Container($this->aggregateServiceProvider);

        $this->registerServiceProviders($serviceProviders, $container);

        $container->setService(ContainerInterface::class, $container);
        $container->setAlias(PsrContainerInterface::class, ContainerInterface::class);

        if (class_exists(AbstractFactory::class)) {
            AbstractFactory::setContainer($container);
        }

        return $container;
    }

    /**
     * @param array<array<string, array>|callable|ServiceProviderInterface|string> $serviceProviders
     */
    private function registerServiceProviders(array $serviceProviders, Container $container): void
    {
        try {
            foreach ($serviceProviders as $serviceProvider) {
                $serviceProvider = $this->resolveServiceProvider($serviceProvider, $container);
                $container->register($serviceProvider);
            }
        } catch (\Throwable $throwable) {
            throw InvalidArgumentException::forInvalidArgumentType(
                'serviceProviders',
                'array<string|callable|' . ServiceProviderInterface::class . '|array<string, array>>',
                0,
                $throwable
            );
        }
    }

    /**
     * @param array<string,array>|callable|ServiceProviderInterface|string $serviceProvider
     *
     * @throws ReflectionException
     */
    private function resolveServiceProvider($serviceProvider, Container $container): ServiceProviderInterface
    {
        if (\is_string($serviceProvider)) {
            $serviceProvider = AbstractFactory::create($serviceProvider);
        }

        if (\is_callable($serviceProvider)) {
            $serviceProvider = \call_user_func($serviceProvider, $container);
        }

        if (\is_array($serviceProvider)) {
            $serviceProvider = new LaminasConfigServiceProvider($serviceProvider);
        }

        if (!$serviceProvider instanceof ServiceProviderInterface) {
            throw InvalidArgumentException::forInvalidArgumentType(
                'serviceProvider',
                'string|callable|' . ServiceProviderInterface::class . '|array<string,array>'
            );
        }

        return $serviceProvider;
    }
}
