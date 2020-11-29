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
use CoiSA\Container\Factory\AggregateContainerFactory;
use CoiSA\Container\Factory\ContainerFactory;
use CoiSA\Factory\AbstractFactory;

$aggregateContainerFactory = new AggregateContainerFactory();
$containerFactory          = new ContainerFactory();

AbstractFactory::setFactory('CoiSA\\Container\\AggregateContainer', $aggregateContainerFactory);
AbstractFactory::setFactory('CoiSA\\Container\\Container', $containerFactory);
AbstractFactory::setFactory('CoiSA\\Container\\ContainerInterface', $containerFactory);
AbstractFactory::setFactory('Psr\\Container\\ContainerInterface', $containerFactory);
