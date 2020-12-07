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

use CoiSA\Factory\AbstractFactory;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerAbstractFactory.
 *
 * @package CoiSA\Container\Factory
 */
final class ContainerAbstractFactory implements ContainerAbstractFactoryInterface
{
    /**
     * @return ContainerInterface
     */
    public static function create()
    {
        $serviceProviders         = \func_get_args();
        $aggregateServiceProvider = AbstractFactory::create('CoiSA\\ServiceProvider\\AggregateServiceProvider');
        $containerFactory         = new ContainerFactory($aggregateServiceProvider);

        return $containerFactory->create($serviceProviders);
    }
}
