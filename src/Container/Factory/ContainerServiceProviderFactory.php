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

use CoiSA\Container\ServiceProvider\ContainerServiceProvider;

final class ContainerServiceProviderFactory
{
    /**
     * @var ContainerServiceProvider
     */
    private static $containerServiceProvider;

    /**
     * @return ContainerServiceProvider
     */
    public static function getDefault()
    {
        if (!static::$containerServiceProvider) {
            static::$containerServiceProvider = new ContainerServiceProvider();
        }

        return static::$containerServiceProvider;
    }
}
