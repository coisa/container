<?php

namespace CoiSA\Container\Test\Stub\ServiceProvider;

use CoiSA\ServiceProvider\Factory\ServiceFactory;
use CoiSA\ServiceProvider\ServiceProvider;

/**
 * Class ExampleServiceProvider
 *
 * @package CoiSA\Container\Test\Stub\ServiceProvider
 */
final class ExampleServiceProvider extends ServiceProvider
{
    /**
     * ExampleServiceProvider constructor.
     */
    public function __construct()
    {
        $this->setFactory(\get_called_class(), new ServiceFactory($this));
    }
}
