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

use Psr\Container\ContainerInterface;

/**
 * Class Container
 *
 * @package CoiSA\Container
 */
final class Container implements ContainerInterface
{
    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function has($id)
    {
        return false;
    }

    /**
     * {@inheritDoc}
     *
     * @return mixed
     */
    public function get($id)
    {
    }
}
