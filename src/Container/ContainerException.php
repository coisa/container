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

use Psr\Container\ContainerExceptionInterface;

/**
 * Class ContainerException
 *
 * @package CoiSA\Container
 */
class ContainerException extends \Exception implements ContainerExceptionInterface
{
    /**
     * @const string
     */
    private const MESSAGE_TEMPLATE = 'Error message "%s" while retrieving the entry "%s".';

    /**
     * @param string $id
     *
     * @return static
     */
    public static function createFromThrowableForIdentifier(\Throwable $throwable, string $id): self
    {
        return new self(
            \sprintf(self::MESSAGE_TEMPLATE, $throwable->getMessage(), $id),
            $throwable->getCode(),
            $throwable
        );
    }
}
