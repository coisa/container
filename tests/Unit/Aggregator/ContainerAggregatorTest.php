<?php

namespace CoiSA\Container\Test\Unit\Aggregator;

use CoiSA\Container\Aggregator\ContainerAggregator;
use PHPUnit\Framework\TestCase;

/**
 * Class ContainerAggregator
 *
 * @package CoiSA\Container\Test\Unit\Aggregator
 */
final class ContainerAggregatorTest extends TestCase
{
    public function provideContainersMock()
    {
        $containers = array();
        $length = \mt_rand(1, 10);

        for ($i = 0; $i <= $length; $i++) {
            $container = $this->prophesize('Psr\\Container\\ContainerInterface');
            $containers[] = $container->reveal();
        }

        return array(
            array($containers)
        );
    }

    /**
     * @dataProvider provideContainersMock
     */
    public function testConstructorWillAppendContainers(array $containers)
    {
        $containerAggregator = new ContainerAggregator($containers);

        self::assertEquals($containers, $containerAggregator->getContainers());
    }

    public function testGetContainersWithoutContainersWillReturnEmptyArray()
    {
        $containerAggregator = new ContainerAggregator();

        self::assertEmpty($containerAggregator->getContainers());
    }

    /**
     * @dataProvider provideContainersMock
     */
    public function testGetContainersWillReturnAppendedContainers(array $containers)
    {
        $containerAggregator = new ContainerAggregator();

        foreach ($containers as $container) {
            $containerAggregator->append($container);
        }

        self::assertEquals($containers, $containerAggregator->getContainers());
    }

    public function testHasWithoutAnyContainerWillReturnFalse()
    {
        $containerAggregator = new ContainerAggregator();

        self::assertFalse($containerAggregator->has(\uniqid('id', true)));
    }
}
