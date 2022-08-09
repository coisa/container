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

namespace CoiSA\Container;

use CoiSA\Exception\Container\ContainerException;
use CoiSA\Exception\Container\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

/**
 * Class AggregateContainer.
 *
 * @package CoiSA\Container
 */
final class AggregateContainer implements ContainerInterface, \IteratorAggregate
{
    /**
     * @var array<ContainerInterface>
     */
    private $containers = [];

    public function __construct(ContainerInterface ...$containers)
    {
        foreach ($containers as $container) {
            $this->append($container);
        }
    }

    /**
     * @return array
     */
    public function getContainers()
    {
        return $this->containers;
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new \ArrayIterator($this->containers);
    }

    /**
     * @return self
     */
    public function prepend(ContainerInterface $container)
    {
        $found = array_search($container, $this->containers, true);

        if ($found) {
            unset($this->containers[$found]);
        }

        array_unshift($this->containers, $container);

        return $this;
    }

    /**
     * @return self
     */
    public function append(ContainerInterface $container)
    {
        if (!\in_array($container, $this->containers, true)) {
            $this->containers[] = $container;
        }

        return $this;
    }

    public function has(string $id): bool
    {
        return array_reduce($this->containers, fn ($has, $container) => $has || $container->has($id), false);
    }

    /**
     * @return mixed
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw NotFoundException::forNotFoundIdentifierFactory($id);
        }

        foreach ($this->containers as $container) {
            try {
                return $container->get($id);
            } catch (ContainerExceptionInterface $containerException) {
            }
        }

        throw ContainerException::forExceptionResolvingIdentifier($containerException, $id);
    }
}
