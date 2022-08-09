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

use CoiSA\Container\Factory\ContainerAbstractFactory;
use CoiSA\Container\Test\Stub\ServiceProvider\ExampleOtherServiceProvider;
use CoiSA\Container\Test\Stub\ServiceProvider\ExampleServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceProvider = new ExampleOtherServiceProvider();

$container = ContainerAbstractFactory::create(
    // Register service-provider using full-qualified class name
    ExampleServiceProvider::class,

    // Register service-provider using an object instance
    $serviceProvider

    // You can also register service-provider using Laminas ConfigProvider pattern dependencies array maping
    // @see examples/laminas-config-provider-pattern.php for more details

    // Or a callable
    // fn (ContainerInterface $container) => new ExampleServiceProvicer($container->get('options')),

    // ...keep adding the service-providers of your application
);

// You would be able to access the service-provider instance using the container
var_dump($container->has(ExampleServiceProvider::class), $container->get(ExampleServiceProvider::class));
var_dump($container->has(ExampleOtherServiceProvider::class), $container->get(ExampleOtherServiceProvider::class));

// If you register a service-provider using an object instance, you can access it using the container
var_dump($serviceProvider === $container->get(ExampleOtherServiceProvider::class));

// Memory usage
var_dump(memory_get_peak_usage(true) / 1024 / 1024);