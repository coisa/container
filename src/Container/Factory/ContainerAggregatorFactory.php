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
use CoiSA\Container\Singleton\ContainerAggregatorSingleton;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerAggregatorFactory
 *
 * @package CoiSA\Container\Factory
 */
final class ContainerAggregatorFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return ContainerAggregator
     */
    public function factory(ContainerInterface $container)
    {
        return ContainerAggregatorSingleton::getInstance();
    }
}
