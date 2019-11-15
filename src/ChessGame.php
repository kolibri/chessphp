<?php

declare(strict_types=1);

namespace Kolibri;

use Kolibri\Exception\InvalidPgnException;
use Ryanhs\Chess\Chess;

class ChessGame
{
    /** @var Chess */
    private $ryanhsChess;

    public function __construct(string $pgn = null)
    {
        $this->ryanhsChess = new Chess();

        if (null !== $pgn) {
            if (!Chess::validatePgn($pgn)) {
                throw new InvalidPgnException($pgn);
            }
            $this->ryanhsChess->loadPgn($pgn);
        }
    }

    public function getPgn(): string
    {
        return $this->ryanhsChess->pgn(['max_width' => 70]);
    }

    public function getFen(): string
    {
        return $this->ryanhsChess->fen();
    }

    public function getAsciiBoard(): string
    {
        return $this->ryanhsChess->ascii();
    }

    public function getMoveHistory(): array
    {
        return $this->ryanhsChess->history();
    }

    public function getWhitePlayerName(): string
    {
        return $this->getHeader('White');
    }

    public function getBlackPlayerName(): string
    {
        return $this->getHeader('Black');
    }

    private function getHeader($name): string
    {
        return $this->ryanhsChess->header()[$name];
    }
}
