<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Coffeecup\Othello\OthelloLogic;
use Coffeecup\Othello\Viewer;

class OthelloRepl {

	private $othello;
	private $passCount = 0;
	private $isGameFinished = false;

	public function __construct(){
		$this->othello = new OthelloLogic();
		$this->othello->initBoard();
	}

	public function main() {
		while($isGameFinished == false) {
			[$display_board, $candidate_moves] = $this->othello->getCandidateBoard();
			echo Viewer::view_board($display_board)."\n";
			if ( $candidate_moves == 0 ) {
				$past_player = $this->othello->getPlayer() == 1 ? 2 : 1; 
				echo "Player".$past_player." has no way to move.\nnext turn\n\n";
				$passCount += 1;
				if ($passCount == 2 ) {
					$isGameFinished = true;
				}
				continue;
			}
			$passCount = 0;
			$isGameFinished = $this->othello->isGameFinished();
			if ($isGameFinished == true) {
				break;
			}
			echo "It's your turn ".$this->othello->getPlayer()." \n";
			echo "Please Input vertical position;\n";
			$stdin_vertical = (int)trim(fgets(STDIN));
			echo "Please Input horizontal position;\n";
			$stdin_horizontal = (int)trim(fgets(STDIN));
			$is_success = $this->othello->move($stdin_vertical - 1, $stdin_horizontal - 1);
			if ($is_success == true) {
				echo "\n";
			} else {
				echo "Your move is incorrect...\nmove again\n\n";
			}
		}
	}
}

$repl = new OthelloRepl();
$repl->main();