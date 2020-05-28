<?php

namespace CoiSA\Container\Test\Unit\Exception;

use CoiSA\Container\Exception\ContainerException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;

/**
 * Class ContainerExceptionTest
 *
 * @package CoiSA\Container\Test\Unit\Exception
 */
final class ContainerExceptionTest extends TestCase
{
    public function testCreateFromExceptionForIdentifierWillReturnContainerExceptionWithGivenPreviousException()
    {
        $exception = new \Exception(\uniqid('exception', true), \random_int(1, 1000));
        $containerException = ContainerException::createFromExceptionForIdentifier($exception, \uniqid('id', true));

        $this->assertInstanceOf(ContainerException::class, $containerException);
        $this->assertInstanceOf(ContainerExceptionInterface::class, $containerException);
        $this->assertSame($exception, $containerException->getPrevious());
    }
}
