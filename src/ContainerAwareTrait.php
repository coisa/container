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

use Psr\Container\ContainerInterface as PsrContainer;

/**
 * Trait ContainerAwareTrait.
 *
 * @package CoiSA\Container
 */
trait ContainerAwareTrait
{
    /**
     * The container instance.
     */
    protected PsrContainer $container;

    /**
     * Sets a container.
     */
    public function setContainer(PsrContainer $container): void
    {
        $this->container = $container;
    }
}
