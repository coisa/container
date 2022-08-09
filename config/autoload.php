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

namespace CoiSA\Container;

use CoiSA\Container\Factory\AggregateContainerAbstractFactory;
use CoiSA\Container\Factory\ContainerAbstractFactory;
use CoiSA\Factory\AbstractFactory;
use CoiSA\Factory\AbstractFactoryFactory;
use CoiSA\Factory\AliasFactory;
use Psr\Container\ContainerInterface as PsrContainer;

\call_user_func(
    function (
        AbstractFactoryFactory $aggregateContainerFactory,
        AbstractFactoryFactory $containerFactory,
        AliasFactory $aliasFactory
    ): void {
        AbstractFactory::setFactory(AggregateContainer::class, $aggregateContainerFactory);
        AbstractFactory::setFactory(Container::class, $containerFactory);
        AbstractFactory::setFactory(ContainerInterface::class, $aliasFactory);
        AbstractFactory::setFactory(PsrContainer::class, $aliasFactory);
    },
    new AbstractFactoryFactory(AggregateContainerAbstractFactory::class),
    new AbstractFactoryFactory(ContainerAbstractFactory::class),
    new AliasFactory(Container::class)
);
