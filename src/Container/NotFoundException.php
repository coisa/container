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

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class ContainerException
 *
 * @package CoiSA\Container
 */
final class NotFoundException extends ContainerException implements NotFoundExceptionInterface
{
}
