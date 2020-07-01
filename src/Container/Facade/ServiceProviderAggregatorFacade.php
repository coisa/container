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

namespace CoiSA\Container\Facade;

use CoiSA\Container\Aggregator\ServiceProviderAggregator;
use CoiSA\Container\Factory\ServiceProviderAggregatorFactory;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

/**
 * Class ServiceProviderAggregatorFacade
 *
 * @package CoiSA\Container\Facade
 */
final class ServiceProviderAggregatorFacade
{
    /**
     * @param ServiceProviderInterface $container
     *
     * @return ServiceProviderAggregator
     */
    public static function prepend(ServiceProviderInterface $container)
    {
        return ServiceProviderAggregatorFactory::getInstance()->prepend($container);
    }

    /**
     * @param ServiceProviderInterface $container
     *
     * @return ServiceProviderAggregator
     */
    public static function append(ContainerInterface $container)
    {
        return ServiceProviderAggregatorFactory::getInstance()->append($container);
    }
}
