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

use CoiSA\Container\Exception\ContainerException;
use PHPUnit\Framework\TestCase;

/**
 * Class ContainerExceptionTest
 *
 * @package CoiSA\Container\Test\Unit\Exception
 */
final class ContainerExceptionTest extends TestCase
{
    public function testCreateFromExceptionForIdentifierWillReturnContainerExceptionWithGivenPreviousException()
    {
        $exception          = new \Exception(\uniqid('exception', true), \mt_rand(1, 1000));
        $containerException = ContainerException::createFromExceptionForIdentifier($exception, \uniqid('id', true));

        $this->assertInstanceOf('CoiSA\Container\Exception\ContainerException', $containerException);
        $this->assertInstanceOf('Psr\Container\ContainerExceptionInterface', $containerException);
        $this->assertSame($exception, $containerException->getPrevious());
    }
}
