<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Coffeecup\Othello\OthelloLogic;
use Coffeecup\Othello\Viewer;

$othello_board = new OthelloLogic();
$othello_board->initBoard();
$othello_board->move(5, 4);
$othello_board->move(5, 3);
$othello_board->move(6, 2);
$othello_board->move(6, 5);
$othello_board->move(6, 4);
$othello_board->move(6, 3);
$othello_board->move(7, 6);
$othello_board->move(5, 5);
$othello_board->move(4, 5);
$othello_board->move(5, 6);
$othello_board->move(6, 7);
$othello_board->move(5, 7);
$othello_board->move(3, 2);
$othello_board->move(7, 7);
$othello_board->move();
$othello_board->move();
$othello_board->move();

/*
$othello_board->move();
$othello_board->move();
$othello_board->move();
$othello_board->move();
*/



/*
$enemy_player = $othello_board->getPlayer() == 2 ? 1 : 2;
[$enemy_player_array, $ally_player_array] = $othello_board->getEnemyAndAllyPlayerArray($enemy_player);
$surroundCandidates =  $othello_board->getSurroundCandidates($enemy_player_array);
echo var_dump($surroundCandidates);
*/

[$display_board, $candidate_count] = $othello_board->getCandidateBoard();

echo Viewer::view_board($display_board);
