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
            'CoiSA\\Container\\Container' => array(
                'CoiSA\\Container\\Factory\\ContainerFactory',
                'factory'
            ),
            'CoiSA\\Container\\Aggregator\\ContainerAggregator' => array(
                'CoiSA\\Container\\Factory\\ContainerAggregatorFactory',
                'factory'
            ),
            'CoiSA\\Container\\ServiceProvider\\ContainerServiceProvider' => array(
                'CoiSA\\Container\\Factory\\ContainerServiceProviderFactory',
                'factory'
            ),
            'CoiSA\\Container\\Aggregator\\ServiceProviderAggregator' => array(
                'CoiSA\\Container\\Factory\\ServiceProviderAggregatorFactory',
                'factory'
            ),
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
