<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Coffeecup\Othello\OthelloLogic;
use Coffeecup\Othello\Viewer;

$othello_board = new OthelloLogic();
$othello_board->initBoard();
$othello_board->move(3, 2);
$othello_board->move(4, 2);
$othello_board->move(5, 1);
$othello_board->move(2, 1);
$othello_board->move(3, 1);
$othello_board->move(4, 1);
$othello_board->move();

/*
$enemy_player = $othello_board->getPlayer() == 2 ? 1 : 2;
[$enemy_player_array, $ally_player_array] = $othello_board->getEnemyAndAllyPlayerArray($enemy_player);
$surroundCandidates =  $othello_board->getSurroundCandidates($enemy_player_array);
echo var_dump($surroundCandidates);
*/

[$display_board, $candidate_count] = $othello_board->getCandidateBoard();

echo Viewer::view_board($display_board);
