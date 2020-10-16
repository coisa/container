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

use CoiSA\Exception\Container\ContainerException;
use CoiSA\Exception\Container\NotFoundException;
use CoiSA\ServiceProvider\Exception\ServiceProviderExceptionInterface;
use CoiSA\ServiceProvider\ServiceProviderAggregator;
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
    private $instances = array();

    /**
     * Container constructor.
     *
     * @param array<ServiceProviderInterface> $serviceProviders
     */
    public function __construct(array $serviceProviders = array())
    {
        $this->serviceProviderAggregator = new ServiceProviderAggregator($serviceProviders);
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function has($id)
    {
        if (\array_key_exists($id, $this->instances)) {
            return true;
        }

        try {
            $this->serviceProviderAggregator->getFactory($id);
        } catch (ServiceProviderExceptionInterface $serviceProviderException) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function get($id)
    {
        if (false === \array_key_exists($id, $this->instances)) {
            $this->instances[$id] = $this->resolve($id);
        }

        return $this->instances[$id];
    }

    /**
     * @param string                                                                  $id
     * @param callable|\CoiSA\ServiceProvider\Factory\ServiceProviderFactoryInterface $factory
     *
     * @return $this
     */
    public function set($id, $factory)
    {
        $this->serviceProviderAggregator->setFactory($id, $factory);

        return $this;
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
     * @return mixed
     */
    private function resolve($id)
    {
        try {
            $factory = $this->serviceProviderAggregator->getFactory($id);
        } catch (ServiceProviderExceptionInterface $serviceProviderException) {
            throw NotFoundException::forNotFoundIdentifierFactory($id);
        }

        try {
            $instance = \call_user_func($factory, $this);
        } catch (\Exception $exception) {
            throw ContainerException::forExceptionResolvingIdentifier($exception, $id);
        }

        try {
            $extension = $this->serviceProviderAggregator->getExtension($id);

            return \call_user_func($extension, $this, $instance);
        } catch (ServiceProviderExceptionInterface $serviceProviderException) {
            return $instance;
        } catch (\Exception $exception) {
            throw ContainerException::forExceptionResolvingIdentifier($exception, $id);
        }
    }
}
