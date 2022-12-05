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
		while($this->isGameFinished == false) {
			[$display_board, $candidate_moves] = $this->othello->getCandidateBoard();
			echo Viewer::view_board($display_board)."\n";
			echo "It's your turn ".$this->othello->getPlayer()." \n";
			echo "Please Input vertical position;\n";
			$stdin_vertical = (int)trim(fgets(STDIN));
			echo "Please Input horizontal position;\n";
			$stdin_horizontal = (int)trim(fgets(STDIN));
			[$is_success, $is_game_continue] = $this->othello->move($stdin_vertical - 1, $stdin_horizontal - 1);
			if ($is_game_continue == false ) {
				$this->isGameFinished = false;
			}
			if ($is_success == true) {
				echo "\n";
			} else {
				echo "Your move is incorrect...\nmove again\n\n";
			}
		}
	}

	public function random_game() {
		while($this->isGameFinished == false) {
			[$is_success, $is_game_continue] = $this->othello->random_move();
			if ($is_game_continue == false ) {
				[$display_board, $candidate_moves] = $this->othello->getCandidateBoard();
				echo Viewer::view_board($display_board);
				$this->isGameFinished = true;
			}
		}
		$this->othello->getGameResult();
	}

	public function play_with_computer() {
		$choose_player_flag = true;
		$chosen_player = 1;
		while($choose_player_flag == true) {
			echo "Please Input Player(1 for black 2 for white);\n";
			$stdin_player = (int)trim(fgets(STDIN));
			if ($stdin_player == 1) {
				$choose_player_flag = false;
				$chosen_player = 1;
			} else if ($stdin_player == 2) {
				$chosen_player = false;
				$chosen_player = 2;
			} else {
				echo "Please Input correct input (1 or 2).\n";
			}
		}
		while ($this->isGameFinished == false) {
			[$display_board, $candidate_moves] = $this->othello->getCandidateBoard();
			echo Viewer::view_board($display_board)."\n";
			if ($this->othello->getPlayer() == $chosen_player) {
				echo "It's your turn ".$this->othello->getPlayer()." \n";
				echo "Please Input vertical position;\n";
				$stdin_vertical = (int)trim(fgets(STDIN));
				echo "Please Input horizontal position;\n";
				$stdin_horizontal = (int)trim(fgets(STDIN));
				[$is_success, $is_game_continue] = $this->othello->move($stdin_vertical - 1, $stdin_horizontal - 1);
				if ($is_game_continue == false ) {
					$this->isGameFinished = false;
				}
				if ($is_success == true) {
					echo "\n";
				} else {
					echo "Your move is incorrect...\nmove again\n\n";
				}
			} else {
				[$is_success, $is_game_continue] = $this->othello->random_move();
				echo "Computer played.\n\n";
				if ($is_game_continue == false ) {
					$this->isGameFinished = true;
				}
			}
		}
		$this->othello->getGameResult();
	}

}

$repl = new OthelloRepl();
// $repl->random_game();
$repl->play_with_computer();