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

use CoiSA\Container\Container;
use Interop\Container\ServiceProviderInterface;

/**
 * Class ContainerFactory
 *
 * @package CoiSA\Container
 */
final class ContainerFactory
{
    /**
     * @var Container
     */
    private static $container;

    /**
     * @return Container
     */
    public static function getDefault()
    {
        if (!static::$container) {
            $serviceProviderAggregator = ServiceProviderAggregatorFactory::getDefault();
            $serviceProviderAggregator->prepend(ContainerServiceProviderFactory::getDefault());

            static::$container = new Container($serviceProviderAggregator);
        }

        return static::$container;
    }

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @return Container
     */
    public static function register(ServiceProviderInterface $serviceProvider)
    {
        return static::getDefault()->register($serviceProvider);
    }
}
