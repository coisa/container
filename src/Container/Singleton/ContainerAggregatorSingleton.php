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

use CoiSA\Container\Aggregator\ContainerAggregator;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerAggregatorSingleton
 *
 * @package CoiSA\Container\Singleton
 */
final class ContainerAggregatorSingleton extends AbstractSingleton
{
    /**
     * @param ContainerInterface $container
     *
     * @return ContainerAggregator
     */
    public static function prepend(ContainerInterface $container)
    {
        return self::getInstance()->prepend($container);
    }

    /**
     * @param ContainerInterface $container
     *
     * @return ContainerAggregator
     */
    public static function append(ContainerInterface $container)
    {
        return self::getInstance()->append($container);
    }

    /**
     * @return ContainerAggregator
     */
    protected static function newInstance()
    {
        $container = ContainerSingleton::getInstance();

        return new ContainerAggregator(array($container));
    }
}
