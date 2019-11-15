<?php

declare(strict_types=1);

namespace Kolibr\Tests;

use Kolibri\ChessGame;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ryanhs\Chess\Chess;

class ChessGameTest extends TestCase
{
    public function testCanCreateNewGame(): void
    {
        static::assertSame(
            'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1',
            ChessGame::new()->getFen()
        );
    }

    public function testCanCreateFromPgn(): void
    {
        $pgn = <<<EOF
[Event "Simultaneous"]
[Site "Budapest HUN"]
[Date "1934.??.??"]
[EventDate "?"]
[Round "?"]
[Result "1-0"]
[White "Esteban Canal"]
[Black "NN"]
[ECO "B01"]
[WhiteElo "?"]
[BlackElo "?"]
[PlyCount "27"]

1.e4 d5 2.exd5 Qxd5 3.Nc3 Qa5 4.d4 c6 5.Nf3 Bg4 6.Bf4 e6 7.h3
Bxf3 8.Qxf3 Bb4 9.Be2 Nd7 10.a3 O-O-O 11.axb4 Qxa1+ 12.Kd2
Qxh1 13.Qxc6+ bxc6 14.Ba6# 1-0
EOF;

        static::assertSame(
            '2kr2nr/p2n1ppp/B1p1p3/8/1P1P1B2/2N4P/1PPK1PP1/7q b - - 1 14',
            ChessGame::fromPgn($pgn)->getFen()
        );
    }

    public function testCanCreateFromFen()
    {
        // just test, if the inserted FEN ist the output FEN...
        $fen = 'rn2k1r1/ppp1pp1p/3p2p1/5bn1/P7/2N2B2/1PPPPP2/2BNK1RR w kq - 4 11';

        static::assertSame($fen, ChessGame::fromFen($fen)->getFen());
    }

    /** @dataProvider fenValidationProvider */
    public function testValidateFenOnlyReturnsBool(string $givenFen, bool $expectedValidationResult): void
    {
        static::assertSame(
            $expectedValidationResult,
            ChessGame::validateFen($givenFen)
        );
    }

    public function fenValidationProvider(): \Generator
    {
        yield ['rn2k1r1/ppp1pp1p/3p2p1/5bn1/P7/2N2B2/1PPPPP2/2BNK1RR w kq - 4 11', true];
        yield ['rn2k1r1/ppp1pp1p/3p2p1/5bn1/P7/2N2B2/1PPPPP2/2BNK1RR w Gkq - 4 11', false];
        yield ['notfen', false];
    }

    public function testFormattingToPgnJustRedirectsToRyanhs(): void
    {
        /** @var Chess|MockObject $ryanhs */
        $ryanhs = $this->createMock(Chess::class);

        $ryanhs
            ->expects(static::once())
            ->method('pgn')
            ->willReturn('pgn string');

        $game = new ChessGame($ryanhs);

        static::assertSame('pgn string', $game->getPgn());
    }

    public function testFormattingToFenJustRedirectsToRyanhs(): void
    {
        /** @var Chess|MockObject $ryanhs */
        $ryanhs = $this->createMock(Chess::class);

        $ryanhs
            ->expects(static::once())
            ->method('fen')
            ->willReturn('fen string');

        $game = new ChessGame($ryanhs);

        static::assertSame('fen string', $game->getFen());
    }

    public function testFormattingToAsciiJustRedirectsToRyanhs(): void
    {
        /** @var Chess|MockObject $ryanhs */
        $ryanhs = $this->createMock(Chess::class);

        $ryanhs
            ->expects(static::once())
            ->method('ascii')
            ->willReturn('ascii string');

        $game = new ChessGame($ryanhs);

        static::assertSame('ascii string', $game->getAsciiBoard());
    }
}
