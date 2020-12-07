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

use CoiSA\Container\Test\Stub\ServiceProvider\ExampleOtherServiceProvider;
use CoiSA\Factory\AbstractFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$exampleServiceProvider = 'CoiSA\\Container\\Test\\Stub\\ServiceProvider\\ExampleServiceProvider';
$otherServiceProvider   = new ExampleOtherServiceProvider();

$container = AbstractFactory::create(
    'Psr\\Container\\ContainerInterface',
    $exampleServiceProvider,
    $otherServiceProvider
);
// or
//$container = CoiSA\Container\Factory\ContainerAbstractFactory::create(
//    $exampleServiceProvider,
//    $otherServiceProvider
//);

\var_dump(
    // ExampleServiceProvider
    $container->has($exampleServiceProvider),
    $container->get($exampleServiceProvider),

    // ExampleOtherServiceProvider
    $container->has(\get_class($otherServiceProvider)),
    $otherServiceProvider === $container->get(\get_class($otherServiceProvider)),
    $container->get(\get_class($otherServiceProvider))
);

\var_dump(
    AbstractFactory::getFactory($exampleServiceProvider) instanceof CoiSA\Factory\ContainerFactory,
    AbstractFactory::getFactory($exampleServiceProvider)
);

\var_dump(
    \memory_get_peak_usage(true) / 1024 / 1024
);
