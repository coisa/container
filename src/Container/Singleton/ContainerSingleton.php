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

use CoiSA\Container\Container;
use Interop\Container\ServiceProviderInterface;

/**
 * Class ContainerSingleton
 *
 * @package CoiSA\Container\Singleton
 */
final class ContainerSingleton extends AbstractSingleton
{
    /**
     * @return Container
     */
    public static function newInstance()
    {
        $containerServiceProvider  = ContainerServiceProviderSingleton::getInstance();
        $serviceProviderAggregator = ServiceProviderAggregatorSingleton::getInstance();

        $serviceProviderAggregator->prepend($containerServiceProvider);

        return new Container($serviceProviderAggregator);
    }

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @return Container
     */
    public static function register(ServiceProviderInterface $serviceProvider)
    {
        return self::getInstance()->register($serviceProvider);
    }
}
