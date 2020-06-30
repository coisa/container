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

use Psr\Container\ContainerInterface as PsrContainer;

/**
 * Interface ContainerAwareInterface
 *
 * @package CoiSA\Container
 */
interface ContainerAwareInterface
{
    /**
     * Sets a container instance on object.
     *
     * @param PsrContainer $container
     *
     * @return void
     */
    public function setContainer(PsrContainer $container);
}
