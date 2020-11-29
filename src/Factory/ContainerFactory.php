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
use CoiSA\ServiceProvider\AggregateServiceProvider;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerFactory.
 *
 * @package CoiSA\Container\Factory
 */
final class ContainerFactory implements FactoryInterface
{
    /**
     * @return ContainerInterface
     *
     * @TODO Add support to ServiceProvider string classname
     * @TODO Add support to ConfigProvider pattern
     */
    public function create()
    {
        $serviceProviders         = \func_get_args();
        $aggregateServiceProvider = new AggregateServiceProvider($serviceProviders);
        $container                = new Container($aggregateServiceProvider);

        AbstractFactory::setContainer($container);

        return $container;
    }
}
