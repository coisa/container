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

use CoiSA\Container\ServiceProvider\ContainerServiceProvider;

/**
 * Class ContainerServiceProviderSingleton
 *
 * @package CoiSA\Container\Singleton
 */
final class ContainerServiceProviderSingleton extends AbstractSingleton
{
    /**
     * @return callable[]
     */
    public static function getFactories()
    {
        return self::getInstance()->getFactories();
    }

    /**
     * @return callable[]
     */
    public static function getExtensions()
    {
        return self::getInstance()->getExtensions();
    }

    /**
     * @return ContainerServiceProvider
     */
    protected static function newInstance()
    {
        return new ContainerServiceProvider();
    }
}
