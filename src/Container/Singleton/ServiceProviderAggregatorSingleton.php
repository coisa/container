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

namespace CoiSA\Container\Singleton;

use CoiSA\Container\Aggregator\ServiceProviderAggregator;
use Interop\Container\ServiceProviderInterface;

/**
 * Class ServiceProviderAggregatorSingleton
 *
 * @package CoiSA\Container\Singleton
 */
final class ServiceProviderAggregatorSingleton extends AbstractSingleton
{
    /**
     * @param ServiceProviderInterface $container
     *
     * @return ServiceProviderAggregator
     */
    public static function prepend(ServiceProviderInterface $container)
    {
        return self::getInstance()->prepend($container);
    }

    /**
     * @param ServiceProviderInterface $container
     *
     * @return ServiceProviderAggregator
     */
    public static function append(ServiceProviderInterface $container)
    {
        return self::getInstance()->append($container);
    }

    /**
     * @return ServiceProviderAggregator
     */
    protected static function newInstance()
    {
        $containerServiceProvider = ContainerServiceProviderSingleton::getInstance();

        return new ServiceProviderAggregator(array($containerServiceProvider));
    }
}
