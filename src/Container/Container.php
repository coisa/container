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

use CoiSA\Container\ServiceProvider\ServiceProviderAggregator;
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
     * @var ServiceProviderInterface
     */
    private $serviceProvider;

    /**
     * @var null|ContainerInterface
     */
    private $rootContainer;

    /**
     * @var mixed[]
     */
    private $shared = array();

    /**
     * Container constructor.
     *
     * @param null|ServiceProviderInterface $serviceProvider
     * @param null|ContainerInterface       $rootContainer
     */
    public function __construct(ServiceProviderInterface $serviceProvider = null, ContainerInterface $rootContainer = null)
    {
        $this->serviceProvider = $serviceProvider instanceof ServiceProviderAggregator ? $serviceProvider
            : new ServiceProviderAggregator(\array_filter(array($serviceProvider)));

        $this->rootContainer = $rootContainer;
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function has($id)
    {
        return \is_callable($this->findFactory($id))
            || (null !== $this->rootContainer && $this->rootContainer->has($id));
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
     * @param ServiceProviderInterface $serviceProvider
     *
     * @return Container
     */
    public function register(ServiceProviderInterface $serviceProvider)
    {
        $this->serviceProvider->append($serviceProvider);

        return $this;
    }

    /**
     * @param string $id
     *
     * @return callable|false
     */
    private function findFactory($id)
    {
        $factories = \array_filter($this->serviceProvider->getFactories(), 'is_callable');

        if (\array_key_exists($id, $factories)) {
            return $factories[$id];
        }

        return false;
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

        if (!$factory && null !== $this->rootContainer) {
            $instance = $this->rootContainer->get($id);
        }

        if (!$factory && !isset($instance)) {
            throw Exception\NotFoundException::createForIdentifier($id);
        }

        try {
            $instance = $instance ?? \call_user_func($factory, $this);

            return $this->extend($id, $instance);
        } catch (\Exception $exception) {
            throw Exception\ContainerException::createFromExceptionForIdentifier($exception, $id);
        }
    }

    /**
     * @param string     $id
     * @param null|mixed $object
     *
     * @return mixed
     */
    private function extend($id, $object = null)
    {
        $extensions = $this->serviceProvider->getExtensions();

        if (false === \array_key_exists($id, $extensions)) {
            return $object;
        }

        return \call_user_func($extensions[$id], $this, $object);
    }
}
