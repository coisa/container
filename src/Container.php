<?php

/**
 * This file is part of coisa/container.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/coisa/container
 *
 * @copyright Copyright (c) 2019-2020 Felipe Sayão Lobato Abreu <github@felipeabreu.com.br>
 * @license   https://opensource.org/licenses/MIT MIT License
 */
namespace CoiSA\Container;

use CoiSA\Exception\Container\ContainerException;
use CoiSA\Exception\Container\NotFoundException;
use CoiSA\Factory\AbstractFactory;
use CoiSA\ServiceProvider\AggregateServiceProvider;
use CoiSA\ServiceProvider\Exception\ServiceProviderExceptionInterface;
use Interop\Container\ServiceProviderInterface;

/**
 * Class Container.
 *
 * @package CoiSA\Container
 */
final class Container implements ContainerInterface
{
    /**
     * @var AggregateServiceProvider
     */
    private $aggregateServiceProvider;

    /**
     * @var mixed[]
     */
    private $instances = array();

    /**
     * Container constructor.
     *
     * @param AggregateServiceProvider|null $aggregateServiceProvider
     */
    public function __construct(AggregateServiceProvider $aggregateServiceProvider = null)
    {
        $this->aggregateServiceProvider = $aggregateServiceProvider ?: AbstractFactory::create(
            'CoiSA\\ServiceProvider\\AggregateServiceProvider'
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function has($id)
    {
        if (\array_key_exists($id, $this->instances)) {
            return true;
        }

        try {
            $this->aggregateServiceProvider->getFactory($id);
        } catch (ServiceProviderExceptionInterface $serviceProviderException) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
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
        $this->aggregateServiceProvider->setFactory($id, $factory);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function register(ServiceProviderInterface $serviceProvider)
    {
        $this->aggregateServiceProvider->append($serviceProvider);

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
            $factory = $this->aggregateServiceProvider->getFactory($id);
        } catch (ServiceProviderExceptionInterface $serviceProviderException) {
            throw NotFoundException::forNotFoundIdentifierFactory($id);
        }

        try {
            $instance = \call_user_func($factory, $this);
        } catch (\Exception $exception) {
            throw ContainerException::forExceptionResolvingIdentifier($exception, $id);
        }

        try {
            $extension = $this->aggregateServiceProvider->getExtension($id);

            return \call_user_func($extension, $this, $instance);
        } catch (ServiceProviderExceptionInterface $serviceProviderException) {
            return $instance;
        } catch (\Exception $exception) {
            throw ContainerException::forExceptionResolvingIdentifier($exception, $id);
        }
    }
}
