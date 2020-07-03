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

namespace CoiSA\Container\Exception;

use Psr\Container\ContainerExceptionInterface;

/**
 * Class ContainerException
 *
 * @package CoiSA\Container\Exception
 */
class ContainerException extends \Exception implements ContainerExceptionInterface
{
    /**
     * @const string
     */
    const MESSAGE_TEMPLATE = 'Error message "%s" while retrieving the entry "%s".';

    /**
     * @param string $id
     *
     * @return ContainerException
     */
    public static function createFromExceptionForIdentifier(\Exception $exception, $id)
    {
        return new self(
            \sprintf(self::MESSAGE_TEMPLATE, $exception->getMessage(), $id),
            $exception->getCode(),
            $exception
        );
    }
}
