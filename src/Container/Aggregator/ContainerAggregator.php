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

namespace CoiSA\Container\Aggregator;

use CoiSA\Container\Exception;
use Psr\Container\ContainerInterface;

/**
 * Class ContainerAggregator
 *
 * @package CoiSA\Container\Aggregator
 */
final class ContainerAggregator implements ContainerInterface
{
    /**
     * @var array<ContainerInterface>
     */
    private $containers = array();

    /**
     * ContainerAggregator constructor.
     *
     * @param array<ContainerInterface> $containers
     */
    public function __construct(array $containers = array())
    {
        foreach ($containers as $container) {
            $this->append($container);
        }
    }

    /**
     * @return array
     */
    public function getContainers(): array
    {
        return $this->containers;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return self
     */
    public function prepend(ContainerInterface $container)
    {
        \array_unshift($this->containers, $container);

        return $this;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return self
     */
    public function append(ContainerInterface $container)
    {
        $this->containers[] = $container;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has($id)
    {
        return \array_reduce($this->containers, function ($has, $container) use ($id) {
            return $has || $container->has($id);
        }, false);
    }

    /**
     * @param string $id
     *
     * @throws Exception\NotFoundException
     *
     * @return mixed
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw Exception\NotFoundException::createForIdentifier($id);
        }

        return \array_reduce($this->containers, function ($object, $container) use ($id) {
            return $object || ($container->has($id) ? $container->get($id) : false);
        });
    }
}
