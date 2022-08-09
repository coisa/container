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

namespace CoiSA\Container\Test\Stub\ServiceProvider;

use CoiSA\ServiceProvider\Factory\ServiceFactory;
use CoiSA\ServiceProvider\ServiceProvider;

/**
 * Class ExampleServiceProvider.
 *
 * @package CoiSA\Container\Test\Stub\ServiceProvider
 */
final class ExampleServiceProvider extends ServiceProvider
{
    /**
     * ExampleServiceProvider constructor.
     */
    public function __construct(array $options = [])
    {
        $this->setFactory(static::class, new ServiceFactory($this));
        $this->setFactory('options', new ServiceFactory($options));
    }
}
