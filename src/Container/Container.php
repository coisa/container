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

namespace CoiSA\Container;

use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

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
    private $serviceProvider;

    /**
     * @var mixed[]
     */
    private $shared;

    /**
     * Container constructor.
     *
     * @param ServiceProviderInterface $serviceProvider
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
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
     * @throws Exception\NotFoundException
     * @throws Exception\ContainerException
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
     * @throws Exception\NotFoundException
     * @throws Exception\ContainerException
     *
     * @return mixed
     */
    private function build($id)
    {
        $factory = $this->findFactory($id);

        if (!$factory) {
            throw Exception\NotFoundException::createForIdentifier($id);
        }

        try {
            $instance = \call_user_func($factory, $this);
            // @TODO service provider extension
        } catch (\Exception $exception) {
            throw Exception\ContainerException::createFromExceptionForIdentifier($exception, $id);
        }

        return $instance;
    }

    /**
     * @param string $id
     *
     * @return null|callable
     */
    private function findFactory($id)
    {
        $factories = \array_filter($this->serviceProvider->getFactories(), 'is_callable');

        if (\array_key_exists($id, $factories)) {
            return $factories[$id];
        }
    }
}
