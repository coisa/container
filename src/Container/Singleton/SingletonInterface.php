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

/**
 * Interface SingletonInterface
 *
 * @package CoiSA\Container\Factory
 */
interface SingletonInterface
{
    /**
     * Return a shared instance of an object.
     *
     * @return mixed
     */
    public static function getInstance();
}
