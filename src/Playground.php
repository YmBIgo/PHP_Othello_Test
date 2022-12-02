<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Coffeecup\Othello\OthelloLogic;
use Coffeecup\Othello\Viewer;

$othello_board = new OthelloLogic();
$othello_board->initBoard();
$othello_board->move(2, 3);
$othello_board->move(2, 4);
$othello_board->move(1, 5);
$othello_board->move(1, 2);
$othello_board->move(1, 3);
$othello_board->move(1, 4);
$othello_board->move(0, 3);

/*
$enemy_player = $othello_board->getPlayer() == 2 ? 1 : 2;
[$enemy_player_array, $ally_player_array] = $othello_board->getEnemyAndAllyPlayerArray($enemy_player);
$surroundCandidates =  $othello_board->getSurroundCandidates($enemy_player_array);
echo var_dump($surroundCandidates);
*/

[$display_board, $candidate_count] = $othello_board->getCandidateBoard();

echo Viewer::view_board($display_board);
