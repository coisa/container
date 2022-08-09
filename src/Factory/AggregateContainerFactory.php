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

use CoiSA\Container\AggregateContainer;
use CoiSA\Container\ContainerInterface;
use CoiSA\Factory\AbstractFactory;
use Psr\Container\ContainerInterface as PsrContainerInterface;

/**
 * Class AggregateContainerFactory.
 *
 * @package CoiSA\Container\Factory
 */
final class AggregateContainerFactory implements ContainerFactoryInterface
{
    private ContainerInterface $container;

    /**
     * AggregateContainerFactory constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(): AggregateContainer
    {
        $containers         = \func_get_args();
        $aggregateContainer = new AggregateContainer(...$containers);

        $this->container->setService(AggregateContainer::class, $aggregateContainer);
        $this->container->setAlias(PsrContainerInterface::class, AggregateContainer::class);

        $aggregateContainer->prepend($this->container);

        AbstractFactory::setContainer($aggregateContainer);

        return $aggregateContainer;
    }
}
