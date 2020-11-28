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
use CoiSA\Container\Factory\ContainerFactory;
use CoiSA\Container\Test\Stub\ServiceProvider\ExampleOtherServiceProvider;
use CoiSA\Container\Test\Stub\ServiceProvider\ExampleServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$exampleServiceProvider = new ExampleServiceProvider();
$otherServiceProvider   = new ExampleOtherServiceProvider();

$containerFactory = new ContainerFactory();
$container        = $containerFactory->create(
    $exampleServiceProvider,
    $otherServiceProvider
);

\var_dump(
    // ExampleServiceProvider
    $container->has('CoiSA\\Container\\Test\\Stub\\ServiceProvider\\ExampleServiceProvider'),
    $exampleServiceProvider === $container->get('CoiSA\\Container\\Test\\Stub\\ServiceProvider\\ExampleServiceProvider'),
    $container->get('CoiSA\\Container\\Test\\Stub\\ServiceProvider\\ExampleServiceProvider'),

    // ExampleOtherServiceProvider
    $container->has('CoiSA\\Container\\Test\\Stub\\ServiceProvider\\ExampleOtherServiceProvider'),
    $otherServiceProvider === $container->get('CoiSA\\Container\\Test\\Stub\\ServiceProvider\\ExampleOtherServiceProvider'),
    $container->get('CoiSA\\Container\\Test\\Stub\\ServiceProvider\\ExampleOtherServiceProvider')
);

\var_dump(\memory_get_peak_usage(true) / 1024 / 1024);
