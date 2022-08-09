<?php

declare(strict_types=1);

/**
 * This file is part of coisa/container.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/coisa/container
 * @copyright Copyright (c) 2019-2022 Felipe Sayão Lobato Abreu <github@felipeabreu.com.br>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace CoiSA\Container\Factory;

use CoiSA\Container\ContainerInterface;
use CoiSA\Factory\AbstractFactory;
use CoiSA\ServiceProvider\AggregateServiceProvider;

/**
 * Class ContainerAbstractFactory.
 *
 * @package CoiSA\Container\Factory
 */
final class ContainerAbstractFactory implements ContainerAbstractFactoryInterface
{
    public static function create(): ContainerInterface
    {
        $serviceProviders         = \func_get_args();
        $aggregateServiceProvider = AbstractFactory::create(AggregateServiceProvider::class);
        $containerFactory         = new ContainerFactory($aggregateServiceProvider);

        return $containerFactory->create($serviceProviders);
    }
}
