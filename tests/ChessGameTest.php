<?php

declare(strict_types=1);

namespace Kolibri\Tests;

use Kolibri\ChessGame;
use Kolibri\Exception\InvalidPgnException;
use PHPUnit\Framework\TestCase;

class ChessGameTest extends TestCase
{
    private const VALID_PGN = <<<EOF
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

1. e4 d5 2. exd5 Qxd5 3. Nc3 Qa5 4. d4 c6 5. Nf3 Bg4 6. Bf4 e6 7. h3 
Bxf3 8. Qxf3 Bb4 9. Be2 Nd7 10. a3 O-O-O 11. axb4 Qxa1+ 12. Kd2 Qxh1 
13. Qxc6+ bxc6 14. Ba6#
EOF;

    /** @var ChessGame */
    private $peruvianImmortal;

    protected function setUp()
    {
        $this->peruvianImmortal = new ChessGame(self::VALID_PGN);
    }

    public function testCanCreateNewGame(): void
    {
        static::assertSame(
            'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1',
            (new ChessGame())->getFen()
        );
    }

    public function testCanCreateFromPgn(): void
    {
        static::assertSame(
            '2kr2nr/p2n1ppp/B1p1p3/8/1P1P1B2/2N4P/1PPK1PP1/7q b - - 1 14',
            $this->peruvianImmortal->getFen()
        );
    }

    public function testCreatingGameWithInvalidPgnThrowsInvalidPgnException(): void
    {
        $this->expectException(InvalidPgnException::class);

        $game = new ChessGame('THIS IS NOT VALID');
    }

    public function testFormattingToPgnWorks(): void
    {
        static::assertSame(self::VALID_PGN, $this->peruvianImmortal->getPgn());
    }

    public function testFormattingToFenWorks(): void
    {
        static::assertSame(
            '2kr2nr/p2n1ppp/B1p1p3/8/1P1P1B2/2N4P/1PPK1PP1/7q b - - 1 14',
            $this->peruvianImmortal->getFen()
        );
    }

    public function testGetPlayerNames(): void
    {
        static::assertSame('Esteban Canal', $this->peruvianImmortal->getWhitePlayerName());
        static::assertSame('NN', $this->peruvianImmortal->getBlackPlayerName());
    }

    public function testGetMovesReturnMoves(): void
    {
        static::assertSame(
            [
                'e4',
                'd5',
                'exd5',
                'Qxd5',
                'Nc3',
                'Qa5',
                'd4',
                'c6',
                'Nf3',
                'Bg4',
                'Bf4',
                'e6',
                'h3',
                'Bxf3',
                'Qxf3',
                'Bb4',
                'Be2',
                'Nd7',
                'a3',
                'O-O-O',
                'axb4',
                'Qxa1+',
                'Kd2',
                'Qxh1',
                'Qxc6+',
                'bxc6',
                'Ba6#',
            ],
            $this->peruvianImmortal->getMoveHistory()
        );
    }

    public function testCanGenerateAsciiBoard(): void
    {
        static::assertSame(
            <<<EOF
   +------------------------+
 8 | .  .  k  r  .  .  n  r |
 7 | p  .  .  n  .  p  p  p |
 6 | B  .  p  .  p  .  .  . |
 5 | .  .  .  .  .  .  .  . |
 4 | .  P  .  P  .  B  .  . |
 3 | .  .  N  .  .  .  .  P |
 2 | .  P  P  K  .  P  P  . |
 1 | .  .  .  .  .  .  .  q |
   +------------------------+
     a  b  c  d  e  f  g  h

EOF
            ,
            $this->peruvianImmortal->getAsciiBoard()
        );
    }
}
