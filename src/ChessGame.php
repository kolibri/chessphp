<?php

declare(strict_types=1);

namespace Kolibri;

use Ryanhs\Chess\Chess;

class ChessGame
{
    /** @var Chess */
    private $ryanhsChess;

    public function __construct(Chess $chess)
    {
        $this->ryanhsChess = $chess;
    }

    public static function new(): self
    {
        return new self(new Chess());
    }

    public static function fromPgn(string $pgn): self
    {
        if (!Chess::validatePgn($pgn)) {
            throw new \InvalidArgumentException('Invalid PGN given.');
        }

        $chess = new Chess();
        $chess->loadPgn($pgn);

        return new self($chess);
    }

    public static function fromFen(string $fen): self
    {
        if (!self::validateFen($fen)) {
            throw new \InvalidArgumentException('Invalid FEN given.');
        }

        $chess = new Chess();
        $chess->load($fen);

        return new self($chess);
    }

    public static function validateFen(string $fen): bool
    {
        $result = Chess::validateFen($fen);

        return $result['valid'] === true;
    }

    public function getPgn(): string
    {
        return $this->ryanhsChess->pgn();
    }

    public function getFen(): string
    {
        return $this->ryanhsChess->fen();
    }

    public function getAsciiBoard(): string
    {
        return $this->ryanhsChess->ascii();
    }
}
