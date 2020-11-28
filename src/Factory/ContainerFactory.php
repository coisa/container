<?php

namespace CoiSA\Container\Factory;

use CoiSA\Container\Container;
use CoiSA\Factory\FactoryInterface;
use CoiSA\ServiceProvider\AggregateServiceProvider;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerFactory
 *
 * @package CoiSA\Container\Factory
 */
final class ContainerFactory implements FactoryInterface
{
    /**
     * @return ContainerInterface
     */
    public function create()
    {
        $serviceProviders = func_get_args();
        $aggregateServiceProvider = new AggregateServiceProvider($serviceProviders);

        return new Container($aggregateServiceProvider);
    }
}
