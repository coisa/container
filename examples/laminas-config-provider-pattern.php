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

use CoiSA\Factory\AbstractFactory;
use Psr\Container\ContainerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$config = [
    'dependencies' => [
        'factories' => [
            stdClass::class => fn (ContainerInterface $container) => new stdClass(),
        ],
        'aliases' => [
            'db' => stdClass::class,
        ],
    ],
];

$container = AbstractFactory::create(ContainerInterface::class, $config);

// If you don't have coisa/factory installed in your project use:
// $container = CoiSA\Container\Factory\ContainerAbstractFactory::create($config);

var_dump($container->get('config'));
var_dump($container->get('db'));
