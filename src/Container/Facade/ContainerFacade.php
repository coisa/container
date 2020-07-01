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

namespace CoiSA\Container\Facade;

use CoiSA\Container\Container;
use CoiSA\Container\Factory\ContainerFactory;
use Interop\Container\ServiceProviderInterface;

/**
 * Class ContainerFacade
 *
 * @package CoiSA\Container\Facade
 */
final class ContainerFacade
{
    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @return Container
     */
    public static function register(ServiceProviderInterface $serviceProvider)
    {
        return ContainerFactory::getInstance()->register($serviceProvider);
    }
}
