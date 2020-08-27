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

namespace CoiSA\Container\Test\Unit\Exception;

use CoiSA\Container\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Class NotFoundExceptionTest
 *
 * @package CoiSA\Container\Test\Unit\Exception
 */
final class NotFoundExceptionTest extends TestCase
{
    public function testCreateForIdentifierWillReturnNotFoundException()
    {
        $notFoundException = NotFoundException::createForIdentifier(\uniqid('id', true));

        self::assertInstanceOf('CoiSA\\Container\\Exception\\NotFoundException', $notFoundException);
        self::assertInstanceOf('Psr\\Container\\NotFoundExceptionInterface', $notFoundException);
    }
}
