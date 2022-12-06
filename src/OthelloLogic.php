<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Exception;

class OthelloLogic {

	private $board;
	private $display_board;
	private $blank = 0;
	private $black = 1;
	private $white = 2;
	private $player = 1;
	private $moves_histories;
	private $game_history;

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
		$this->game_history = [];
	}

	public function getBoard() {
		return $this->board;
	}

	public function EchoGameResult() {
		$blank_count = 0;
		$white_count = 0;
		foreach ($this->board as $board_row) {
			foreach ($board_row as $move) {
				if ($move == 1) {
					$blank_count += 1;
				} else if ($move == 2) {
					$white_count += 1;
				}
			}
		}
		
		echo "\n\n Blank = ".$blank_count;
		echo "\n White = ".$white_count;
		echo "\n\n";

		$othello_history = "";
		$othello_horizontal_alphabet_array = array("A", "B", "C", "D", "E", "F", "G", "H");
		foreach ($this->game_history as $history) {
			$horizontal_pos = $history[1];
			$horizontal_string = $othello_horizontal_alphabet_array[$horizontal_pos];
			$vertical_string = $history[0] + 1;
			$othello_history = $othello_history.$horizontal_string.$vertical_string;
		}
		echo $othello_history;
	}

	public function getGameResult() {
		$black_count = 0;
		$white_count = 0;
		foreach ($this->board as $board_row) {
			foreach ($board_row as $move) {
				if ($move == 1) {
					$black_count += 1;
				} else if ($move == 2) {
					$white_count += 1;
				}
			}
		}
		$game_result = 0;
		$game_diff = 0;
		if ($black_count == $white_count) {
			$game_result = 0;
			$game_diff = 0;
		} else if ($black_count > $white_count) {
			$game_result = 1;
			$game_diff = $black_count - $white_count;
		} else if ($white_count > $black_count) {
			$game_result = 2;
			$game_diff = $white_count - $black_count;
		}
		return [$black_count, $white_count, $game_result, $game_diff];
 	}

	public function getCandidateBoard() {
		$enemy_player = $this->player == 2 ? 1 : 2;
		[$enemy_player_array, $ally_player_array] = $this->getEnemyAndAllyPlayerArray($enemy_player);
		$surroundCandidates =  $this->getSurroundCandidates($enemy_player_array);
		[$surroundCandidates, $defeatedCandidates] = $this->traceSurroundCanMove($surroundCandidates);
		$this->display_board = $this->board;
		foreach ($surroundCandidates as $candidate ) {
			$this->display_board[$candidate[0]][$candidate[1]] = 3;
		}
		return [$this->display_board, count($surroundCandidates), $surroundCandidates, $defeatedCandidates];
	}

	public function getEnemyAndAllyPlayerArray ($enemy_player) {
		$enemy_player_array = array();
		$ally_player_array = array();
		for ($i = 0; $i < 8; $i++) {
			for ($j = 0; $j < 8; $j++) {
				if ($this->board[$i][$j] == $enemy_player) {
					array_push($enemy_player_array, [$i, $j]);
				} else if ( $this->board[$i][$j] == $this->getPlayer() ) {
					array_push($ally_player_array, [$i, $j]);
				}
			}
		}
		return [$enemy_player_array, $ally_player_array];
	}

	public function traceSurroundCanMove($surroundCandidates) {
		$candidate_array = array();
		$candidate_defeat_array = array();
		foreach ($surroundCandidates as $candidate) {
			$checkBelow = $this->checkBelowWithCount($candidate[0], $candidate[1], $this->player, false);
			$checkAbove = $this->checkAboveWithCount($candidate[0], $candidate[1], $this->player, false);
			$checkLeft  = $this->checkLeftWithCount($candidate[0], $candidate[1], $this->player, false);
			$checkRight = $this->checkRightWithCount($candidate[0], $candidate[1], $this->player, false);
			$checkAboveLeft = $this->checkAboveLeftWithCount($candidate[0], $candidate[1], $this->player, false);
			$checkAboveRight = $this->checkAboveRightWithCount($candidate[0], $candidate[1], $this->player, false);
			$checkBelowLeft = $this->checkBelowLeftWithCount($candidate[0], $candidate[1], $this->player, false);
			$checkBelowRight = $this->checkBelowRightWithCount($candidate[0], $candidate[1], $this->player, false);
			if ( $checkBelow[0] == false && $checkAbove[0] == false && $checkLeft[0] == false && $checkRight[0] == false && $checkBelowLeft[0] == false &&  $checkBelowRight[0] == false && $checkAboveLeft[0] == false && $checkAboveRight[0] == false ) {
				continue;
			} else {
				$defeat_enemy = $checkBelow[1] + $checkAbove[1] + $checkLeft[1] + $checkRight[1] + $checkAboveLeft[1] + $checkAboveRight[1] + $checkBelowLeft[1] + $checkBelowRight[1];
				array_push($candidate_array, $candidate);
				$candidate_defeat_key = (string)((string)$candidate[0].(string)$candidate[1]);
				$candidate_defeat_array = $candidate_defeat_array + array($candidate_defeat_key => $defeat_enemy);
			}
		}
		return [$candidate_array, $candidate_defeat_array];
	}

	public function getSurroundCandidates ($enemy_player_array) {
		$surroundArray = array();
		foreach ($enemy_player_array as $enemy_move) {
			$surroundCandidate = $this->getSurroundMoves($enemy_move);
			$surroundArray = array_merge($surroundArray, $surroundCandidate);
		}
		$surroundResult = array();
		$surroundFlag = false;
		foreach ($surroundArray as $surroundCandidate) {
			$surroundFlag = false;
			foreach ($surroundResult as $surroundCompare) {
				if ( $surroundCompare[0] == $surroundCandidate[0] && $surroundCompare[1] == $surroundCandidate[1] ) {
					$surroundFlag = true;
					break;
				}
			}
			if ($surroundFlag == false) {
				array_push($surroundResult, $surroundCandidate);
			}
		}
		usort($surroundResult, function($a, $b) {
			return $a[0] > $b[0] ? 1 : -1;
		});
		return $surroundResult;
	}

	public function getSurroundMoves ($move) {
		$aboveMove = [$move[0] - 1, $move[1]];
		$belowMove = [$move[0] + 1, $move[1]];
		$rightMove = [$move[0], $move[1] + 1];
		$leftMove  = [$move[0], $move[1] - 1];
		$aboveleftMove  = [$move[0] - 1, $move[1] - 1];
		$aboverightMove = [$move[0] - 1, $move[1] + 1];
		$belowleftMove  = [$move[0] + 1, $move[1] - 1];
		$belowrightMove = [$move[0] + 1, $move[1] + 1];
		$surroundMovesArray = [$aboveMove, $belowMove, $rightMove, $leftMove, $aboveleftMove, $aboverightMove, $belowleftMove, $belowrightMove];
		$surroundMovesResult = array();
		foreach ($surroundMovesArray as $surroundMove) {
			if ($surroundMove[0] < 0 || $surroundMove[0] > 7 || $surroundMove[1] < 0 || $surroundMove[1] > 7) {
				continue;
			}
			$hMoveCounter = 0;
			foreach ( $this->moves_histories as $hMove ) {
				// move has already appeared.
				if ( $hMove[0] == $surroundMove[0] && $hMove[1] == $surroundMove[1] ) {
					break;
				}
				$hMoveCounter += 1;
				if (count($this->moves_histories) == $hMoveCounter) {
					array_push($surroundMovesResult, $surroundMove);
				}
			}
		}
		return $surroundMovesResult;
	}

	public function getPlayer() {
		return $this->player;
	}

	public function getGameHistory() {
		return $this->game_history;
	}

	/*
	 * < Put >
	 *	Vertical 	-> 縦
	 *	Horizontal 	-> 横
	 */
	public function move($vertical_pos, $horizontal_pos) {
		if (gettype($vertical_pos) != "integer" || gettype($vertical_pos) != "integer") {
			return [false, true];
		}
		if ((int)$vertical_pos < 0 || (int)$vertical_pos > 8 || (int)$horizontal_pos < 0 || (int)$horizontal_pos > 8) {
			return [false, true];
		}
		if ($this->player != 1 && $this->player != 2) {
			throw new Exception("Unknown player;");
		}
		$checkMoveHistories = $this->checkMoveHistories($vertical_pos, $horizontal_pos);

		if ($checkMoveHistories == true) {
			return [false, true];
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
			return [false, true];
		}
		$this->commitDefeatedMove([$vertical_pos, $horizontal_pos], $this->player);
		array_push($this->moves_histories, [$vertical_pos, $horizontal_pos]);
		array_push($this->game_history, [$vertical_pos, $horizontal_pos]);

		$this->player = $this->player == 1 ? 2 : 1;
		[$display_board, $candidate_count] = $this->getCandidateBoard();
		if ($candidate_count != 0) {
			return [true, true];
		} else {
			$this->player = $this->player == 1 ? 2 : 1;
			[$display_board2, $candidate_count2] = $this->getCandidateBoard();
			if ($candidate_count2 == 0) {
				return [true, false];
			} else {
				return [true, true];
			}
		}
	}

	public function random_move() {
		[$display_board, $candidate_count, $candidate_moves] = $this->getCandidateBoard();
		$selected_candidate_id = rand(0, count($candidate_moves) - 1);
		$selected_move = $candidate_moves[$selected_candidate_id];
		$game_result = $this->move($selected_move[0], $selected_move[1]);
		return $game_result;
	}

	public function random_move2() {
		[$display_board, $candidate_count, $candidate_moves, $candidate_defeat_count] = $this->getCandidateBoard();
		$pick_corner_array = $this->checkHasCorner($candidate_moves);
		$sanitize_near_corner_array = $this->checkHasNearCorner($pick_corner_array);
		$game_history_len = count($this->game_history);
		$move_array = array();
		if ($game_history_len < 31) {
			$move_array = $this->checkSmallestOrBiggestDefeatMove($sanitize_near_corner_array, $candidate_defeat_count, true);
		} else {
			$move_array = $this->checkSmallestOrBiggestDefeatMove($sanitize_near_corner_array, $candidate_defeat_count, false);
		}
		$selected_candidate_id = rand(0, count($move_array) - 1);
		$selected_move = $move_array[$selected_candidate_id];
		// echo var_dump($selected_move);
		$game_result = $this->move($selected_move[0], $selected_move[1]);
		return $game_result;
	}

	public function checkHasCorner($candidate_moves) {
		foreach ($candidate_moves as $candidate_m) {
			if ($this->MoveIsEqual($candidate_m, [0, 0]) || $this->MoveIsEqual($candidate_m, [0, 7]) || $this->MoveIsEqual($candidate_m, [7, 0]) || $this->MoveIsEqual($candidate_m, [7, 7])) {
				return [$candidate_m];
			}
		}
		return $candidate_moves;
	}

	public function checkHasNearCorner($candidate_moves) {
		$notNearCornerArray = array();
		foreach ($candidate_moves as $candidate_m) {
			if ($this->MoveIsEqual($candidate_m, [1, 0]) || $this->MoveIsEqual($candidate_m, [1, 1]) || $this->MoveIsEqual($candidate_m, [0, 1]) || $this->MoveIsEqual($candidate_m, [0, 6]) || $this->MoveIsEqual($candidate_m, [1, 6]) || $this->MoveIsEqual($candidate_m, [1, 7]) || $this->MoveIsEqual($candidate_m, [6, 0]) || $this->MoveIsEqual($candidate_m, [6, 1]) || $this->MoveIsEqual($candidate_m, [7, 1]) || $this->MoveIsEqual($candidate_m, [6, 7]) || $this->MoveIsEqual($candidate_m, [6, 6]) || $this->MoveIsEqual($candidate_m, [7, 6])) {
				// pass
			} else {
				array_push($notNearCornerArray, $candidate_m);
			}
		}
		if (count($notNearCornerArray) == 0) {
			return $candidate_moves;
		}
		return $notNearCornerArray;
	}

	public function checkSmallestOrBiggestDefeatMove($candidate_moves, $defeat_candidate, $smallest) {
		$fixed_defeat_candidate = array();
		foreach ($candidate_moves as $candidate_m) {
			$defeat_candidate_key = (string)((string)$candidate_m[0].(string)$candidate_m[1]);
			if (array_key_exists($defeat_candidate_key, $defeat_candidate)) {
				$fixed_defeat_candidate = $fixed_defeat_candidate + array($defeat_candidate_key => $defeat_candidate[$defeat_candidate_key]);
			}
		}
		$defeat_count = 1;
		if ($smallest == true) {
			$defeat_count = min($fixed_defeat_candidate);
		} else {
			$defeat_count = max($fixed_defeat_candidate);
		}
		$defeat_candidate_array = array();
		foreach ($fixed_defeat_candidate as $key => $value) {
			if ($value == $defeat_count) {
				array_push($defeat_candidate_array, [(int)substr($key, 0, 1), (int)substr($key, 1, 1)]);
			}
		}
		return $defeat_candidate_array;
	}

	public function MoveIsEqual($move1, $move2) {
		return $move1[0] == $move2[0] && $move1[1] == $move2[1];
	}

	public function checkBelow($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		$result = $this->checkBelowImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result[0];
	}
	public function checkBelowWithCount($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkBelowImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result;
	}
	public function checkBelowImpl($vertical_pos, $horizontal_pos, $player, $is_commit) {
		if ($vertical_pos >= 6) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_vertical_pos == 7) { break; }
			if ( $this->board[$check_vertical_pos + 1][$horizontal_pos] == $enemy_player ) {
				$check_vertical_pos = $check_vertical_pos + 1;
				array_push($defeated_enemy, [$check_vertical_pos, $horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_vertical_pos == $vertical_pos) { ; return [false, 0]; }
		if ($check_vertical_pos == 7) { return [false, 0]; }
		if ($this->board[$check_vertical_pos + 1][$horizontal_pos] != $player) {
			return [false, 0];
		}
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkAbove($vertical_pos, $horizontal_pos, $player, $is_commit){
		$result = $this->checkAboveImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result[0];
	}
	public function checkAboveWithCount($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkAboveImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result;
	}
	public function checkAboveImpl($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos <= 1) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_vertical_pos == 0) { break; }
			if ( $this->board[$check_vertical_pos - 1][$horizontal_pos] == $enemy_player ) {
				$check_vertical_pos = $check_vertical_pos - 1;
				array_push($defeated_enemy, [$check_vertical_pos, $horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_vertical_pos == $vertical_pos) { return [false, 0]; }
		if ($check_vertical_pos == 0) { return [false, 0]; }
		if ($this->board[$check_vertical_pos - 1][$horizontal_pos] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkLeft($vertical_pos, $horizontal_pos, $player, $is_commit){
		$result = $this->checkLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result[0];
	}
	public function checkLeftWithCount($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result;
	}
	public function checkLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($horizontal_pos <= 1) { return [false, 0]; }
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0) { break; }
			if ($this->board[$vertical_pos][$check_horizontal_pos - 1] == $enemy_player) {
				$check_horizontal_pos = $check_horizontal_pos - 1;
				array_push($defeated_enemy, [$vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_horizontal_pos == $horizontal_pos) {return [false, 0]; }
		if ($check_horizontal_pos == 0) { return [false, 0]; }
		if ($this->board[$vertical_pos][$check_horizontal_pos - 1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkRight($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result[0];
	}
	public function checkRightWithCount($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result;
	}
	public function checkRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($horizontal_pos >= 6) { return [false, 0]; }
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 7) { break; }
			if ($this->board[$vertical_pos][$check_horizontal_pos + 1] == $enemy_player) {
				$check_horizontal_pos = $check_horizontal_pos + 1;
				array_push($defeated_enemy, [$vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_horizontal_pos == $horizontal_pos) { return [false, 0]; }
		if ($check_horizontal_pos == 7) { return [false, 0]; }
		if ($this->board[$vertical_pos][$check_horizontal_pos + 1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkBelowLeft($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkBelowLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result[0];
	}
	public function checkBelowLeftWithCount($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkBelowLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result;
	}
	public function checkBelowLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos >= 6 || $horizontal_pos <= 1) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_vertical_pos == 7) { break; }
			if ($this->board[$check_vertical_pos+1][$check_horizontal_pos-1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos + 1 ;
				$check_horizontal_pos = $check_horizontal_pos - 1 ;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return [false, 0]; }
		if ($check_vertical_pos == 7 || $check_horizontal_pos == 0 ) { return [false, 0]; }
		if ($this->board[$check_vertical_pos+1][$check_horizontal_pos-1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkBelowRight($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkBelowRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result[0];
	}
	public function checkBelowRightWithCount($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkBelowRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result;
	}
	public function checkBelowRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos >= 6 || $horizontal_pos >= 6) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 7 || $check_vertical_pos == 7) { break; }
			if ($this->board[$check_vertical_pos+1][$check_horizontal_pos+1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos + 1;
				$check_horizontal_pos = $check_horizontal_pos + 1;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return [false, 0]; }
		if ($check_vertical_pos == 7 || $check_horizontal_pos == 7 ) { return [false, 0]; }
		if ($this->board[$check_vertical_pos+1][$check_horizontal_pos+1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkAboveLeft($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkAboveLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result[0];
	}
	public function checkAboveLeftWithCount($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkAboveLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result;
	}
	public function checkAboveLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos <= 1 || $horizontal_pos <= 1) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 0 || $check_vertical_pos == 0) { break; }
			if ($this->board[$check_vertical_pos-1][$check_horizontal_pos-1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos - 1;
				$check_horizontal_pos = $check_horizontal_pos - 1;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return [false, 0]; }
		if ($check_vertical_pos == 0 || $check_horizontal_pos == 0) { return [false, 0]; }
		if ($this->board[$check_vertical_pos-1][$check_horizontal_pos-1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkAboveRight($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkAboveRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result[0];
	}
	public function checkAboveRightWithCount($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkAboveRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit);
		return $result;
	}
	public function checkAboveRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit) {
		//
		if ($vertical_pos <= 1 || $horizontal_pos >= 6) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == 1 ? 2 : 1;
		while (true) {
			if ($check_horizontal_pos == 7 || $check_vertical_pos == 0) { break; }
			if ($this->board[$check_vertical_pos-1][$check_horizontal_pos+1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos - 1;
				$check_horizontal_pos = $check_horizontal_pos + 1;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return [false, 0]; }
		if ($check_vertical_pos == 0 || $check_horizontal_pos == 7) { return [false, 0]; }
		if ($this->board[$check_vertical_pos-1][$check_horizontal_pos+1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player);
		}
		return [true, count($defeated_enemy)];
	}
	public function commitDefeatedMoves($defeated_moves, $player) {
		foreach ($defeated_moves as $d_move) {
			// only permit stones that has already appeared.
			foreach ($this->moves_histories as $h_move) {
				if ($h_move[0] == $d_move[0] && $h_move[1] == $d_move[1]) {
					$this->board[$d_move[0]][$d_move[1]] = $player;
				}
			}
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
	public function isGameFinished() {
		$is_blank_exist_flag = false;
		foreach ($this->board as $move_row) {
			foreach ($move_row as $move) {
				if ($move == 0) {
					return false;
				}
			}
		}
		return true;
	}
}
