<?php

declare(strict_types=1);

namespace Kolibri\Exception;

use Throwable;

class InvalidPgnException extends \InvalidArgumentException
{
    public function __construct(string $invalidPgn, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf("This is not a valid PGN string:\n%s", $invalidPgn),
            $code,
            $previous
        );
    }
}
