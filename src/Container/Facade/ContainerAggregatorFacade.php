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

use CoiSA\Container\Aggregator\ContainerAggregator;
use CoiSA\Container\Factory\ContainerAggregatorFactory;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerAggregatorFacade
 *
 * @package CoiSA\Container\Facade
 */
final class ContainerAggregatorFacade
{
    /**
     * @param ContainerInterface $container
     *
     * @return ContainerAggregator
     */
    public static function prepend(ContainerInterface $container)
    {
        return ContainerAggregatorFactory::getInstance()->prepend($container);
    }

    /**
     * @param ContainerInterface $container
     *
     * @return ContainerAggregator
     */
    public static function append(ContainerInterface $container)
    {
        return ContainerAggregatorFactory::getInstance()->append($container);
    }
}
