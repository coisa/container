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
use CoiSA\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerFactory.
 *
 * @package CoiSA\Container\Factory
 */
final class ContainerFactory implements FactoryInterface
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
     *
     * @TODO Add support to ServiceProvider string classname
     */
    public function create()
    {
        $serviceProviders         = \func_get_args();
        $aggregateServiceProvider = $this->aggregateServiceProviderFactory->create($serviceProviders);
        $container                = new Container($aggregateServiceProvider);

        AbstractFactory::setContainer($container);

        return $container;
    }
}
