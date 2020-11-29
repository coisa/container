<?php

/**
 * This file is part of coisa/container.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/coisa/container
 *
 * @copyright Copyright (c) 2019-2020 Felipe Sayão Lobato Abreu <github@felipeabreu.com.br>
 * @license   https://opensource.org/licenses/MIT MIT License
 */
namespace CoiSA\Container\Factory;

use CoiSA\Container\AggregateContainer;
use CoiSA\Factory\AbstractFactory;
use CoiSA\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class AggregateContainerFactory.
 *
 * @package CoiSA\Container\Factory
 */
final class AggregateContainerFactory implements FactoryInterface
{
    /**
     * @return ContainerInterface
     */
    public function create()
    {
        $containers         = \func_get_args();
        $aggregateContainer = new AggregateContainer($containers);

        AbstractFactory::setContainer($aggregateContainer);

        return $aggregateContainer;
    }
}
