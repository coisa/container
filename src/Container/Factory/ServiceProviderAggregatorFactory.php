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
use Interop\Container\ServiceProviderInterface;

/**
 * Class ServiceProviderAggregatorFactory
 *
 * @package CoiSA\Container\Factory
 */
final class ServiceProviderAggregatorFactory
{
    /**
     * @var ServiceProviderAggregator
     */
    private static $serviceProviderAggregator;

    /**
     * @return ServiceProviderAggregator
     */
    public static function getDefault()
    {
        if (!static::$serviceProviderAggregator) {
            static::$serviceProviderAggregator = new ServiceProviderAggregator();
        }

        return static::$serviceProviderAggregator;
    }

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @return ServiceProviderAggregator
     */
    public static function prepend(ServiceProviderInterface $serviceProvider)
    {
        $serviceProviderAggregator = static::getDefault();

        return $serviceProviderAggregator->prepend($serviceProvider);
    }

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @return ServiceProviderAggregator
     */
    public static function append(ServiceProviderInterface $serviceProvider)
    {
        $serviceProviderAggregator = static::getDefault();

        return $serviceProviderAggregator->append($serviceProvider);
    }
}
