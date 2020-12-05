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
use CoiSA\Factory\FactoryInterface;
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
     * @var FactoryInterface
     */
    private $aggregateServiceProviderFactory;

    /**
     * ContainerFactory constructor.
     *
     * @param FactoryInterface|null $aggregateServiceProviderFactory
     */
    public function __construct(FactoryInterface $aggregateServiceProviderFactory = null)
    {
        $this->aggregateServiceProviderFactory = $aggregateServiceProviderFactory ?: AbstractFactory::getFactory(
            'CoiSA\\ServiceProvider\\AggregateServiceProvider'
        );
    }

    /**
     * @return ContainerInterface
     */
    public function create()
    {
        $serviceProviders         = $this->getServiceProviders(\func_get_args());
        $aggregateServiceProvider = $this->aggregateServiceProviderFactory->create($serviceProviders);
        $container                = new Container($aggregateServiceProvider);

        AbstractFactory::setContainer($container);

        return $container;
    }

    /**
     * @param array $serviceProviders
     *
     * @return array
     */
    private function getServiceProviders(array $serviceProviders)
    {
        foreach ($serviceProviders as &$serviceProvider) {
            if (\is_string($serviceProvider)) {
                $serviceProvider = new $serviceProvider();
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
        }

        return $serviceProviders;
    }
}
