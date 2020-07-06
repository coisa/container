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

use CoiSA\Container\Container;
use CoiSA\Container\Singleton\ContainerSingleton;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerFactory
 *
 * @package CoiSA\Container
 */
final class ContainerFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return Container
     */
    public function factory(ContainerInterface $container)
    {
        return ContainerSingleton::getInstance();
    }
}
