<?php

/**
 * This file is part of coisa/container.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/coisa/container
 * @copyright Copyright (c) 2019-2020 Felipe Sayão Lobato Abreu <github@felipeabreu.com.br>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

use CoiSA\Container\Facade\ContainerFacade;
use CoiSA\Container\Factory\ContainerAggregatorFactory;
use CoiSA\Container\Factory\ContainerFactory;
use CoiSA\Container\Factory\ContainerServiceProviderFactory;
use CoiSA\Container\Factory\ServiceProviderAggregatorFactory;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

class A implements ServiceProviderInterface
{
    public function getFactories()
    {
        return array(
            'a'  => array($this, 'getA'),
            'sa' => array('A', 'getStaticA'),
            'fa' => function (ContainerInterface $container) {
                return 'fa';
            },
        );
    }

    public function getA(ContainerInterface $container)
    {
        return 'a';
    }

    public function getStaticA(ContainerInterface $container)
    {
        return 'sa';
    }

    public function getExtensions()
    {
        return array(
            'a' => function (ContainerInterface $container, $previous) {
                \var_dump($previous);

                return 'a';
            }
        );
    }
}
class B implements ServiceProviderInterface
{
    public function getFactories()
    {
        return array();
    }

    public function getExtensions()
    {
        return array(
            'a' => function (ContainerInterface $container, $previous) {
                \var_dump($previous);

                return $previous . 'b';
            }
        );
    }
}

$container = ContainerFactory::getInstance();
$container->register(new A());
// or
ContainerFacade::register(new B());
// or inside a factory
$container->get('CoiSA\\Container\\Container')->register(new B());

\var_dump(
    $container->get('a'),
    $container->get('sa'),
    $container->get('fa')
);

\var_dump(
    $container->get('CoiSA\\Container\\Aggregator\\ContainerAggregator') === ContainerAggregatorFactory::getInstance(),
    $container->get('CoiSA\\Container\\ServiceProvider\\ContainerServiceProvider') === ContainerServiceProviderFactory::getInstance(),
    $container->get('CoiSA\\Container\\Aggregator\\ServiceProviderAggregator') === ServiceProviderAggregatorFactory::getInstance(),
    $container === $container->get('CoiSA\\Container\\Container'),
    $container === ContainerFactory::getInstance()
);

\var_dump(\memory_get_peak_usage(true) / 1024 / 1024);
