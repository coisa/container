<?php

/**
 * This file is part of coisa/container.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/coisa/container
 * @copyright Copyright (c) 2019-2020 Felipe Sayão Lobato Abreu <github@felipeabreu.com.br>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace CoiSA\Container\Factory;

use CoiSA\Container\Aggregator\ServiceProviderAggregator;
use CoiSA\Container\ContainerInterface;
use CoiSA\Container\Singleton\ServiceProviderAggregatorSingleton;

/**
 * Class ServiceProviderAggregatorFactory
 *
 * @package CoiSA\Container\Factory
 */
final class ServiceProviderAggregatorFactory implements FactoryInterface
{
    /**
     * @return ServiceProviderAggregator
     */
    public function factory(ContainerInterface $container)
    {
        return ServiceProviderAggregatorSingleton::getInstance();
    }
}
