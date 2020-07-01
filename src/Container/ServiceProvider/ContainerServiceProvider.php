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

namespace CoiSA\Container\ServiceProvider;

use CoiSA\Container\Aggregator\ContainerAggregator;
use CoiSA\Container\Aggregator\ServiceProviderAggregator;
use CoiSA\Container\Container;
use CoiSA\Container\Factory\ContainerAggregatorFactory;
use CoiSA\Container\Factory\ContainerFactory;
use CoiSA\Container\Factory\ContainerServiceProviderFactory;
use CoiSA\Container\Factory\ServiceProviderAggregatorFactory;
use Interop\Container\ServiceProviderInterface;

/**
 * Class ContainerServiceProvider
 *
 * @package CoiSA\Container\ServiceProvider
 */
final class ContainerServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFactories()
    {
        return array(
            Container::class                 => array(ContainerFactory::class, 'getInstance'),
            ContainerAggregator::class       => array(ContainerAggregatorFactory::class, 'getInstance'),
            self::class                      => array(ContainerServiceProviderFactory::class, 'getInstance'),
            ServiceProviderAggregator::class => array(ServiceProviderAggregatorFactory::class, 'getInstance'),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getExtensions()
    {
        return array();
    }
}
