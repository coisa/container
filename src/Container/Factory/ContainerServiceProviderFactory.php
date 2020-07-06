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

use CoiSA\Container\ContainerInterface;
use CoiSA\Container\ServiceProvider\ContainerServiceProvider;
use CoiSA\Container\Singleton\ContainerServiceProviderSingleton;

/**
 * Class ContainerServiceProviderFactory
 *
 * @package CoiSA\Container\Factory
 */
final class ContainerServiceProviderFactory implements FactoryInterface
{
    /**
     * @return ContainerServiceProvider
     */
    public function factory(ContainerInterface $container)
    {
        return ContainerServiceProviderSingleton::getInstance();
    }
}
