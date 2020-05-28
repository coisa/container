<?php

namespace CoiSA\Container\Test\Unit\Exception;

use CoiSA\Container\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Container\NotFoundExceptionInterface;

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

        $this->assertInstanceOf(NotFoundException::class, $notFoundException);
        $this->assertInstanceOf(NotFoundExceptionInterface::class, $notFoundException);
    }
}
