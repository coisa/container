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
use CoiSA\Factory\AbstractFactory;
use CoiSA\Factory\AliasFactory;

\call_user_func(
    function($aggregateContainerFactory, $containerFactory, $aliasFactory) {
        AbstractFactory::setFactory('CoiSA\\Container\\AggregateContainer', $aggregateContainerFactory);
        AbstractFactory::setFactory('CoiSA\\Container\\Container', $containerFactory);
        AbstractFactory::setFactory('CoiSA\\Container\\ContainerInterface', $aliasFactory);
        AbstractFactory::setFactory('Psr\\Container\\ContainerInterface', $aliasFactory);
    },
    'CoiSA\\Container\\Factory\\AggregateContainerFactory',
    'CoiSA\\Container\\Factory\\ContainerFactory',
    new AliasFactory('CoiSA\\Container\\Container')
);
