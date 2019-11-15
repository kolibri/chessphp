<?php

declare(strict_types=1);

namespace Kolibri\Tests\Exception;

use Kolibri\Exception\InvalidPgnException;
use PHPUnit\Framework\TestCase;

class InvalidPgnExceptionTest extends TestCase
{
    public function testExcpetionMessageIsAsExpected(): void
    {
        $exception = new InvalidPgnException('foobar');

        static::assertSame("This is not a valid PGN string:\nfoobar", $exception->getMessage());
    }
}
