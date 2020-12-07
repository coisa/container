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
namespace CoiSA\Container\Factory;

use CoiSA\Container\Container;
use CoiSA\Factory\AbstractFactory;
use CoiSA\Factory\Exception\InvalidArgumentException;
use CoiSA\ServiceProvider\AggregateServiceProvider;
use CoiSA\ServiceProvider\LaminasConfigServiceProvider;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

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

    /**,
     * ContainerFactory constructor.
     *
     * @param AggregateServiceProvider|null $aggregateServiceProvider
     */
    public function __construct(AggregateServiceProvider $aggregateServiceProvider = null)
    {
        $this->aggregateServiceProvider = $aggregateServiceProvider ?: AbstractFactory::create(
            'CoiSA\\ServiceProvider\\AggregateServiceProvider'
        );
    }

    /**
     * @return ContainerInterface
     *
     * @throws \CoiSA\Factory\Exception\ReflectionException
     * @throws \CoiSA\Factory\Exception\InvalidArgumentException
     */
    public function create()
    {
        $serviceProviders = \func_get_args();
        $container        = new Container($this->aggregateServiceProvider);

        foreach ($serviceProviders as $serviceProvider) {
            if (\is_string($serviceProvider)) {
                $serviceProvider = AbstractFactory::create($serviceProvider);
            }

            if (\is_callable($serviceProvider)) {
                $serviceProvider = \call_user_func($serviceProvider);
            }

            if (\is_array($serviceProvider)) {
                $serviceProvider = new LaminasConfigServiceProvider($serviceProvider);
            }

            if (!$serviceProvider instanceof ServiceProviderInterface) {
                throw InvalidArgumentException::forInvalidArgumentType(
                    'serviceProviders',
                    'array<Interop\\Container\\ServiceProviderInterface|callable|array|string>'
                );
            }

            $container->register($serviceProvider);
        }

        AbstractFactory::setContainer($container);

        return $container;
    }
}
