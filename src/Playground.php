<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Coffeecup\Othello\OthelloLogic;
use Coffeecup\Othello\Viewer;

$othello_board = new OthelloLogic();
$othello_board->initBoard();
$othello_board->move(5, 4);
// $othello_board->move(5, 5);
$display_board = $othello_board->getCandidateBoard();

echo Viewer::view_board($display_board);
