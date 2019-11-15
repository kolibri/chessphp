# kolibri/chessphp

(This repo is still in development)

This is a wrapper around [ryanhs/chess.php](https://github.com/ryanhs/chess.php) to provide a more easy interface to 
get information of a chess game, that was imported via a PGN string.

## Installation

```bash
composer require kolibri/chessphp
```

## Usage

```php
<?php

use Kolibri\ChessGame;

$emptyGame = new ChessGame(); // Create an empty game (not so useful right now)

$pgnString = <<<EOF
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

// Load Game from PGN string
$gameFromPgn = new ChessGame($pgnString); 

echo $gameFromPgn->getPgn(); // get the pgn string
echo $gameFromPgn->getFen(); // get the FEN of the board at the last move
echo $gameFromPgn->getAsciiBoard(); // get an ascii version of the board
echo $gameFromPgn->getWhitePlayerName(); // get the name of the white player
echo $gameFromPgn->getBlackPlayerName(); // get the name of the black player

```
