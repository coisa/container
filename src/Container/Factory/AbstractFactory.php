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

/**
 * Class AbstractFactory
 *
 * @package CoiSA\Container\Factory
 */
abstract class AbstractFactory implements FactoryInterface
{
    /**
     * @var array<object>
     */
    private static $instance = array();

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        # PHP 5.3 compatibility
        $className = \get_called_class();

        if (false === \array_key_exists($className, self::$instance)) {
            self::$instance[$className] = $className::newInstance();
        }

        return self::$instance[$className];
    }
}
