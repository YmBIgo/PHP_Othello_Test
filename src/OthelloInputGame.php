<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Coffeecup\Othello\OthelloLogic;
use Coffeecup\Othello\Viewer;

class OthelloInputGame {
	private $input_game = array();
	private $othello_horizontal_alphabet_array = array("A", "B", "C", "D", "E", "F", "G", "H");
	public $othello;
	private $isGameFinished = false;

	public function __construct() {
		$this->othello = new OthelloLogic();
		$this->othello->initBoard();
	}

	public function inputGameByCommandLine() {
		$this->input_game = array();
		echo "Please Input othello history;\n\n";
		$stdin_history = trim(fgets(STDIN));
		if (strlen($stdin_history) % 2 != 0) {
			echo "Hisyory should be devivable by 2.\n";
			return;
		}
		for ($i = 0; $i < strlen($stdin_history); $i += 2) {
			$current_move = substr($stdin_history, $i, 2);
			$current_move_horizontal_original = $current_move[0];
			$current_move_horizontal = "";
			$current_move_vertical = (int)$current_move[1] - 1;
			if ( in_array($current_move_horizontal_original, $this->othello_horizontal_alphabet_array) ) {
				$current_move_horizontal = array_search($current_move_horizontal_original, $this->othello_horizontal_alphabet_array);
			} else {
				echo "different format.\n";
				return;
			}
			if ( $current_move_vertical < 0 || $current_move_vertical > 7 ) {
				echo "different format.\n";
				return;
			}
			array_push($this->input_game, [$current_move_vertical, $current_move_horizontal]);
		}
	}

	public function inputGame($game_moves) {
		$this->input_game = array();
		for ($i = 0; $i < strlen($game_moves); $i += 2) {
			$current_move = substr($game_moves, $i, 2);
			$current_move_horizontal_original = $current_move[0];
			$current_move_horizontal = "";
			$current_move_vertical = (int)$current_move[1] - 1;
			if ( in_array($current_move_horizontal_original, $this->othello_horizontal_alphabet_array) ) {
				$current_move_horizontal = array_search($current_move_horizontal_original, $this->othello_horizontal_alphabet_array);
			} else {
				echo "different format.\n";
				return;
			}
			if ( $current_move_vertical < 0 || $current_move_vertical > 7 ) {
				echo "different format.\n";
				return;
			}
			array_push($this->input_game, [$current_move_vertical, $current_move_horizontal]);
		}
	}

	public function startGame() {
		if (count($this->input_game) == 0) {
			echo "input should be bigger than 1.\n";
			return;
		}
		for ($i = 0; $i < count($this->input_game); $i++) {
			$current_move = $this->input_game[$i];
			$current_move_vertical = $current_move[0];
			$current_move_horizontal = $current_move[1];
			[$is_success, $is_game_continue] = $this->othello->move($current_move_vertical, $current_move_horizontal);
			if ($is_success == false) {
				echo "Something wrong happen (check especially your history data).";
			}
		}
		[$display_board, $candidate_moves] = $this->othello->getCandidateBoard();
		// echo Viewer::view_board($display_board);
	}
}

// Input Example 1 : E6D6C4F6C7C6D7E3F5G6G4C5F4C3B7B6B4A8E7G5A5A7H6B8H5F3B5B3D3D8E2D2C8G3A4A6C2A3A2A1H3H4E8F8F7G8G7B2H8H7F2E1D1B1C1G1F1H2H1G2
// Input Example 2 : F5F6E6F4C3D6F3C4C5B4A5A3C6B5A6B6G4E3G5A4A2D3B3C2E2D2A7F1F7G6H5F2E7C7D7H3C8E8H4G3H2D8F8G7D1H6H8H1E1C1B2G1G2B7G8H7A8B8A1B1
// http://hp.vector.co.jp/authors/VA015468/platina/kif/kif.html から棋譜は取ってきました。
// Input Exmaple 3 : F5D6C3D3C4F4F6G5E6D7E3C5F3E7H5E2C6D2C2G3D1H4H3F2G4E1H6B3A3C7B6B5G6G2H1H2F8A5E8B2B8B4A2C1A1B1F1G1A4F7G8G7H8H7A6C8D8B7A8A7
// https://www.hasera.net/othello/saizenham.html?f5d6c3d3c4f4f6g5e6d7e3c5f3e7h5e2c6d2c2g3d1h4h3f2g4e1h6b3a3c7b6b5g6g2h1h2f8a5e8b2b8b4a2c1a1b1f1g1a4f7g8g7h8h7a6c8d8b7a8a7&start_move=21 から 棋譜を取ってきました。

/*
$game = new OthelloInputGame();
// $game->inputGameByCommandLine();
$game->inputGame("F5F6E6F4C3D6F3C4C5B4A5A3C6B5A6B6G4E3G5A4A2D3B3C2E2D2A7F1F7G6H5F2E7C7D7H3C8E8H4G3H2D8F8G7D1H6H8H1E1C1B2G1G2B7G8H7A8B8A1B1");
$game->startGame();
*/