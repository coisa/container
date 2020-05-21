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

declare(strict_types=1);

namespace CoiSA\Container;

use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class Container
 *
 * @package CoiSA\Container
 */
final class Container implements ContainerInterface
{
    /**
     * @var ServiceProviderInterface[]
     */
    private $serviceProviders;

    /**
     * @var callable[]
     */
    private $factories;

    /**
     * @var mixed[]
     */
    private $shared;

    /**
     * Container constructor.
     *
     * @param ServiceProviderInterface ...$serviceProviders
     */
    public function __construct(ServiceProviderInterface ...$serviceProviders)
    {
        $this->serviceProviders = \array_reverse($serviceProviders);
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function has($id)
    {
        return \is_callable($this->findFactory($id));
    }

    /**
     * {@inheritDoc}
     *
     * @return mixed
     */
    public function get($id)
    {
        if (false === \array_key_exists($id, $this->shared)) {
            $this->shared[$id] = $this->build($id);
        }

        return $this->shared[$id];
    }

    /**
     * @param string $id
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     *
     * @return mixed
     */
    private function build(string $id)
    {
        $factory = $this->findFactory($id);

        if (!$factory) {
            throw NotFoundException::createForIdentifier($id);
        }

        try {
            $instance = \call_user_func($factory, $this);
            // @TODO service provider extension
        } catch (\Throwable $throwable) {
            throw ContainerException::createFromThrowableForIdentifier($throwable, $id);
        }

        return $instance;
    }

    /**
     * @param string $id
     *
     * @return null|callable
     */
    private function findFactory(string $id)
    {
        if (false === \array_key_exists($id, $this->factories)) {
            foreach ($this->serviceProviders as $serviceProvider) {
                $this->factories[$id] = $serviceProvider->getFactories()[$id] ?? null;

                if (\is_callable($this->factories[$id])) {
                    break;
                }
            }
        }

        return $this->factories[$id] ?? null;
    }
}
