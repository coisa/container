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

use CoiSA\Container\Aggregator\ServiceProviderAggregator;
use CoiSA\Container\Singleton\ServiceProviderAggregatorSingleton;
use Interop\Container\ServiceProviderInterface;

/**
 * Class Container
 *
 * @package CoiSA\Container
 */
final class Container implements ContainerInterface
{
    /**
     * @var ServiceProviderAggregator
     */
    private $serviceProviderAggregator;

    /**
     * @var mixed[]
     */
    private $shared = array();

    /**
     * Container constructor.
     *
     * @param null|ServiceProviderAggregator $serviceProviderAggregator
     */
    public function __construct(ServiceProviderAggregator $serviceProviderAggregator = null)
    {
        $this->serviceProviderAggregator = $serviceProviderAggregator
            ?: ServiceProviderAggregatorSingleton::getInstance();
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function has($id)
    {
        return \array_key_exists($id, $this->shared) || \is_callable($this->findFactory($id));
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
            $this->shared[$id] = $this->resolve($id);
        }

        return $this->shared[$id];
    }

    /**
     * {@inheritDoc}
     */
    public function register(ServiceProviderInterface $serviceProvider)
    {
        $this->serviceProviderAggregator->append($serviceProvider);

        return $this;
    }

    /**
     * @param string $id
     *
     * @return callable|false
     */
    private function findFactory($id)
    {
        $factories = \array_filter($this->serviceProviderAggregator->getFactories(), 'is_callable');

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
    private function resolve($id)
    {
        $factory = $this->findFactory($id);

        if (!$factory) {
            throw Exception\NotFoundException::createForIdentifier($id);
        }

        try {
            $instance = \call_user_func($factory, $this);

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
        $extensions = $this->serviceProviderAggregator->getExtensions();

        if (false === \array_key_exists($id, $extensions)) {
            return $object;
        }

        return \call_user_func($extensions[$id], $this, $object);
    }
}
