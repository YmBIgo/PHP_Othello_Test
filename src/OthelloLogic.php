<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Exception;

class OthelloLogic {

	private $board;
	private $blank = 0;
	private $black = 1;
	private $white = 2;
	private $player_now = 1;

	public function __construct() {
	}

	public function initBoard() {
		$this->board = [
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 2, 1, 0, 0, 0],
			[0, 0, 0, 1, 2, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
		];
	}

	public function getBoard() {
		return $this->board;
	}

	/*
	 * < Put >
	 *	Vertical 	-> 縦
	 *	Horizontal 	-> 横
	 */
	public function move($vertical_pos, $horizontal_pos) {
		if ($this->player != 1 && $this->player != 2) {
			throw new Exception("Unknown player;");
		}
		return true;
	}

	public function checkBelow($vertical_pos, $horizontal_pos, $player) {
		//
		if ($vertical_pos >= 6) { return false; }
		$check_vertical_pos = $vertical_pos;
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_vertical_pos == 0 || $check_vertical_pos == 7) { break; }
			if ( $this->board[$check_vertical_pos + 1][$horizontal_pos] == $enemy_player ) {
				$check_vertical_pos = $check_vertical_pos + 1;
				continue;
			}
			break;
		}
		if ($check_vertical_pos == $vertical_pos) { ; return false; }
		if ($check_vertical_pos == 7) { return false; }
		if ($this->board[$check_vertical_pos + 1][$horizontal_pos] != $player) {
			return false;
		}
		return true;
	}
	public function checkAbove($vertical_pos, $horizontal_pos, $player) {
		//
		if ($vertical_pos <= 1) { return false; }
		$check_vertical_pos = $vertical_pos;
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_vertical_pos == 0 || $check_vertical_pos == 0) { break; }
			if ( $this->board[$check_vertical_pos - 1][$horizontal_pos] == $enemy_player ) {
				$check_vertical_pos = $check_vertical_pos - 1;
				continue;
			}
			break;
		}
		if ($check_vertical_pos == $vertical_pos) { return false; }
		if ($check_vertical_pos == 0) { return false; }
		if ($this->board[$check_vertical_pos - 1][$horizontal_pos] != $player) { return false; }
		return true;
	}
	public function checkLeft($vertical_pos, $horizontal_pos, $player) {
		//
		if ($horizontal_pos <= 1) { return false; }
		$check_horizontal_pos = $horizontal_pos;
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_horizontal_pos == 7) { break; }
			if ($this->board[$vertical_pos][$check_horizontal_pos - 1] == $enemy_player) {
				$check_horizontal_pos = $check_horizontal_pos - 1;
				continue;
			}
			break;
		}
		if ($check_horizontal_pos == $horizontal_pos) {return false; }
		if ($check_horizontal_pos == 0) { return false; }
		if ($this->board[$vertical_pos][$check_horizontal_pos - 1] != $player) { return false; }
		return true;
	}
	public function checkRight($vertical_pos, $horizontal_pos, $player) {
		//
		if ($horizontal_pos >= 6) { return false; }
		$check_horizontal_pos = $horizontal_pos;
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_horizontal_pos == 7) { break; }
			if ($this->board[$vertical_pos][$check_horizontal_pos + 1] == $enemy_player) {
				$check_horizontal_pos = $check_horizontal_pos + 1;
				continue;
			}
			break;
		}
		if ($check_horizontal_pos == $horizontal_pos) { return false; }
		if ($check_horizontal_pos == 7) { return false; }
		if ($this->board[$vertical_pos][$check_horizontal_pos + 1] != $player) { return false; }
		return true;
	}
	public function checkBelowLeft($vertical_pos, $horizontal_pos, $player) {
		//
		if ($vertical_pos >= 6 || $horizontal_pos <= 1) { return false; }
		return true;
	}
	public function checkBelowRight($vertical_pos, $horizontal_pos, $player) {
		//
		if ($vertical_pos >= 6 || $horizontal_pos >= 6) { return false; }
		return true;
	}
	public function checkAboveLeft($vertical_pos, $horizontal_pos, $player) {
		//
		if ($vertical_pos <= 1 || $horizontal_pos <= 1) { return false; }
		return true;
	}
	public function checkAboveRight($vertical_pos, $horizontal_pos, $player) {
		//
		if ($vertical_pos <= 1 || $horizontal_pos >= 6) { return false; }
		return true;
	}
}
