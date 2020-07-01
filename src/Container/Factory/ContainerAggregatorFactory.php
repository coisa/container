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

use CoiSA\Container\Aggregator\ContainerAggregator;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerAggregatorFactory
 *
 * @package CoiSA\Container\Factory
 */
final class ContainerAggregatorFactory
{
    /**
     * @var ContainerAggregator
     */
    private static $containerAggregator;

    /**
     * @return ContainerAggregator
     */
    public static function getDefault()
    {
        if (!static::$containerAggregator) {
            static::$containerAggregator = new ContainerAggregator();
            static::$containerAggregator->prepend(ContainerFactory::getDefault());
        }

        return static::$containerAggregator;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return ContainerAggregator
     */
    public static function prepend(ContainerInterface $container)
    {
        $containerAggregator = static::getDefault();

        return $containerAggregator->prepend($container);
    }

    /**
     * @param ContainerInterface $container
     *
     * @return ContainerAggregator
     */
    public static function append(ContainerInterface $container)
    {
        $containerAggregator = static::getDefault();

        return $containerAggregator->append($container);
    }
}
