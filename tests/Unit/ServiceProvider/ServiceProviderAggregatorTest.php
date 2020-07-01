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

namespace CoiSA\Container\Test\Unit\ServiceProvider;

use CoiSA\Container\Aggregator\ServiceProviderAggregator;
use Interop\Container\ServiceProviderInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Class ServiceProviderAggregatorTest
 *
 * @package CoiSA\Container\Test\Unit\ServiceProvider
 */
final class ServiceProviderAggregatorTest extends TestCase
{
    /** @var ObjectProphecy|ServiceProviderInterface */
    private $serviceProvider;

    private $serviceProviderAggregator;

    public function setUp()
    {
        $this->serviceProvider           = $this->prophesize('Interop\\Container\\ServiceProviderInterface');
        $this->serviceProviderAggregator = new ServiceProviderAggregator(array(
            $this->serviceProvider->reveal()
        ));
    }

    public function testGetFactoriesWillReturnServiceProviderGetFactories()
    {
        $factories = array(
            \uniqid('key', true) => \uniqid('value', true)
        );

        $this->serviceProvider->getFactories()->willReturn($factories);

        $this->assertEquals($factories, $this->serviceProviderAggregator->getFactories());
    }
}
