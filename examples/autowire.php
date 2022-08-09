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

use CoiSA\Container\AggregateContainer;
use CoiSA\Container\Factory\ContainerAbstractFactory;
use Laminas\Di\Injector;

require_once 'vendor/autoload.php';

/** @var \Laminas\ConfigAggregator\ConfigAggregator $config */
// $config = require __DIR__ . '/config.php';

$coisaContainer = ContainerAbstractFactory::create(/* $config */);

return new AggregateContainer([
    $coisaContainer,
    (new Injector())->getContainer(),
]);
