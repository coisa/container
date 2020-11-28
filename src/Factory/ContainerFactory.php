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
     */
    public function create()
    {
        $serviceProviders         = \func_get_args();
        $aggregateServiceProvider = new AggregateServiceProvider($serviceProviders);

        return new Container($aggregateServiceProvider);
    }
}
