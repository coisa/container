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

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class NotFoundException
 *
 * @package CoiSA\Container\Exception
 */
final class NotFoundException extends ContainerException implements NotFoundExceptionInterface
{
    /**
     * @const string
     */
    const MESSAGE_TEMPLATE = 'No entry was found for "%s" identifier.';

    /**
     * @param string $id
     *
     * @return NotFoundException
     */
    public static function createForIdentifier(string $id)
    {
        return new self(\sprintf(self::MESSAGE_TEMPLATE, $id));
    }
}
