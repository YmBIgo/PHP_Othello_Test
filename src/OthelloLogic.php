<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Exception;

class OthelloLogic {

	private $board;
	private $blank = 0;
	private $black = 1;
	private $white = 2;
	private $player = 1;
	private $moves_histories;

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
		$this->player = 1;
		$this->moves_histories = [[3, 3], [3, 4], [4, 3], [4, 4]];
	}

	public function getBoard() {
		return $this->board;
	}

	public function getPlayer() {
		return $this->player;
	}

	/*
	 * < Put >
	 *	Vertical 	-> 縦
	 *	Horizontal 	-> 横
	 */
	public function move($vertical_pos, $horizontal_pos) {
		if ((int)$vertical_pos < 1 || (int)$vertical_pos > 8 || (int)$horizontal_pos < 1 || (int)$horizontal_pos > 8) {
			return false;
		}
		if ($this->player != 1 && $this->player != 2) {
			throw new Exception("Unknown player;");
		}
		$checkMoveHistories = $this->checkMoveHistories($vertical_pos, $horizontal_pos);

		if ($checkMoveHistories == true) {
			return false;
		}

		$checkBelow = $this->checkBelow($vertical_pos, $horizontal_pos, $this->player, true);
		$checkAbove = $this->checkAbove($vertical_pos, $horizontal_pos, $this->player, true);
		$checkLeft  = $this->checkLeft($vertical_pos, $horizontal_pos, $this->player, true);
		$checkRight = $this->checkRight($vertical_pos, $horizontal_pos, $this->player, true);
		$checkBelowLeft = $this->checkBelowLeft($vertical_pos, $horizontal_pos, $this->player, true);
		$checkBelowRight = $this->checkBelowRight($vertical_pos, $horizontal_pos, $this->player, true);
		$checkAboveLeft = $this->checkAboveLeft($vertical_pos, $horizontal_pos, $this->player, true);
		$checkAboveRight = $this->checkAboveRight($vertical_pos, $horizontal_pos, $this->player, true);
		if ($checkBelow == false && $checkAbove == false && $checkLeft == false && $checkRight == false && $checkBelowLeft == false &&  $checkBelowRight == false && $checkAboveLeft == false && $checkAboveRight == false ) {
			return false;
		}
		$this->commitDefeatedMove([$vertical_pos, $horizontal_pos], $this->player);
		array_push($this->moves_histories, [$vertical_pos, $horizontal_pos]);
		$this->player = $this->player == 1 ? 2 : 1;
		return true;
	}

	public function checkBelow($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos >= 6) { return false; }
		$check_vertical_pos = $vertical_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_vertical_pos == 0 || $check_vertical_pos == 7) { break; }
			if ( $this->board[$check_vertical_pos + 1][$horizontal_pos] == $enemy_player ) {
				$check_vertical_pos = $check_vertical_pos + 1;
				array_push($defeated_enemy, [$check_vertical_pos, $horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_vertical_pos == $vertical_pos) { ; return false; }
		if ($check_vertical_pos == 7) { return false; }
		if ($this->board[$check_vertical_pos + 1][$horizontal_pos] != $player) {
			return false;
		}
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return true;
	}
	public function checkAbove($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos <= 1) { return false; }
		$check_vertical_pos = $vertical_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_vertical_pos == 0 || $check_vertical_pos == 0) { break; }
			if ( $this->board[$check_vertical_pos - 1][$horizontal_pos] == $enemy_player ) {
				$check_vertical_pos = $check_vertical_pos - 1;
				array_push($defeated_enemy, [$check_vertical_pos, $horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_vertical_pos == $vertical_pos) { return false; }
		if ($check_vertical_pos == 0) { return false; }
		if ($this->board[$check_vertical_pos - 1][$horizontal_pos] != $player) { return false; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return true;
	}
	public function checkLeft($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($horizontal_pos <= 1) { return false; }
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_horizontal_pos == 7) { break; }
			if ($this->board[$vertical_pos][$check_horizontal_pos - 1] == $enemy_player) {
				$check_horizontal_pos = $check_horizontal_pos - 1;
				array_push($defeated_enemy, [$vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_horizontal_pos == $horizontal_pos) {return false; }
		if ($check_horizontal_pos == 0) { return false; }
		if ($this->board[$vertical_pos][$check_horizontal_pos - 1] != $player) { return false; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return true;
	}
	public function checkRight($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($horizontal_pos >= 6) { return false; }
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_horizontal_pos == 7) { break; }
			if ($this->board[$vertical_pos][$check_horizontal_pos + 1] == $enemy_player) {
				$check_horizontal_pos = $check_horizontal_pos + 1;
				array_push($defeated_enemy, [$vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_horizontal_pos == $horizontal_pos) { return false; }
		if ($check_horizontal_pos == 7) { return false; }
		if ($this->board[$vertical_pos][$check_horizontal_pos + 1] != $player) { return false; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return true;
	}
	public function checkBelowLeft($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos >= 6 || $horizontal_pos <= 1) { return false; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_horizontal_pos == 7 || $check_vertical_pos == 0 || $check_vertical_pos == 7) { break; }
			if ($this->board[$check_vertical_pos+1][$check_horizontal_pos-1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos + 1 ;
				$check_horizontal_pos = $check_horizontal_pos - 1 ;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return false; }
		if ($check_vertical_pos == 7 || $check_horizontal_pos == 0 ) { return false; }
		if ($this->board[$check_vertical_pos+1][$check_horizontal_pos-1] != $player) { return false; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return true;
	}
	public function checkBelowRight($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos >= 6 || $horizontal_pos >= 6) { return false; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_horizontal_pos == 7 || $check_vertical_pos == 0 || $check_vertical_pos == 7) { break; }
			if ($this->board[$check_vertical_pos+1][$check_horizontal_pos+1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos + 1;
				$check_horizontal_pos = $check_horizontal_pos + 1;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return false; }
		if ($check_vertical_pos == 7 || $check_horizontal_pos == 7 ) { return false; }
		if ($this->board[$check_vertical_pos+1][$check_horizontal_pos+1] != $player) { return false; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return true;
	}
	public function checkAboveLeft($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos <= 1 || $horizontal_pos <= 1) { return false; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_horizontal_pos == 7 || $check_vertical_pos == 0 || $check_vertical_pos == 7) { break; }
			if ($this->board[$check_vertical_pos-1][$check_horizontal_pos-1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos - 1;
				$check_horizontal_pos = $check_horizontal_pos - 1;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return false; }
		if ($check_vertical_pos == 0 || $check_horizontal_pos == 0) { return false; }
		if ($this->board[$check_vertical_pos-1][$check_horizontal_pos-1] != $player) { return false; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return true;
	}
	public function checkAboveRight($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos <= 1 || $horizontal_pos >= 6) { return false; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_horizontal_pos == 7 || $check_vertical_pos == 0 || $check_vertical_pos == 7) { break; }
			if ($this->board[$check_vertical_pos-1][$check_horizontal_pos+1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos - 1;
				$check_horizontal_pos = $check_horizontal_pos + 1;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return false; }
		if ($check_vertical_pos == 0 || $check_horizontal_pos == 7) { return false; }
		if ($this->board[$check_vertical_pos-1][$check_horizontal_pos+1] != $player) { return false; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return true;
	}
	public function commitDefeatedMoves($defeated_moves, $player) {
		foreach ($defeated_moves as $d_move) {
			$this->board[$d_move[0]][$d_move[1]] = $player;
		}
	}
	public function commitDefeatedMove($defeated_move, $player) {
		$this->board[$defeated_move[0]][$defeated_move[1]] = $player;
	}
	public function checkMoveHistories($vertical_pos, $horizontal_pos) {
		foreach ($this->moves_histories as $move_h) {
			if ($move_h[0] == $vertical_pos && $move_h[1] == $horizontal_pos) {
				return true;
			}
		}
		return false;
	}
}
