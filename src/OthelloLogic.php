<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Exception;

enum Player: int {
	case BLACK = 1;
	case WHITE = 2;
}

enum Stone: int {
	case BLANK = 0;
	case BLACK = 1;
	case WHITE = 2;
	case CANDIDATE = 3;
}

class OthelloLogic {

	private $board;
	private $display_board;
	private $blank = 0;
	private $player = 1;
	private $moves_histories;
	private $game_history;
	private const OTHELLO_HORIZONTAL_ALPHABET_ARRAY = array("A", "B", "C", "D", "E", "F", "G", "H");
	private const BOARD_WIDTH = 8;
	private const BOARD_WITH_INDEX = 7;
	private const BOARD_MAX_CORNER = 7;
	private const BOARD_MIN_CORNER = 0;

	private $virtual_board;
	private $virtual_player;
	private $virtual_current_player;
	private $virtual_original_board1;
	private $virtual_original_board2;
	private $virtual_original_board3;
	private $virtual_original_board4;
	private $virtual_original_board5;
	private $virtual_original_display_board;
	private $virtual_history1;
	private $virtual_history2;
	private $virtual_hirtosy3;
	private $virtual_history4;
	private $virtual_history5;
	private $evaluation_board = [
		[30, -12, 0, -1, -1, 0, -12, 30],
		[-12, -15, -3, -3, -3, -3, -15, -12],
		[0, -3, 0, -1, -1, 0, -3, 0],
		[-1, -3, -1, -1, -1, -1, -3, -1],
		[-1, -3, -1, -1, -1, -1, -3, -1],
		[0, -3, 0, -1, -1, 0, -3, 0],
		[-12, -15, -3, -3, -3, -3, -15, -12],
		[30, -12, 0, -1, -1, 0, -12, 30],
	];

	public function __construct() {
		$this->player = Player::BLACK->value;
		$this->virtual_player = Player::BLACK->value;
	}

	public function initBoard() {
		$this->board = [
			[Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value],
			[Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value],
			[Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value],
			[Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::WHITE->value, Stone::BLACK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value],
			[Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLACK->value, Stone::WHITE->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value],
			[Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value],
			[Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value],
			[Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value, Stone::BLANK->value],
		];
		$this->player = Player::BLACK->value;
		$this->virtual_player = Player::BLACK->value;
		$this->moves_histories = [[3, 3], [3, 4], [4, 3], [4, 4]];
		$this->virtual_history1 = [[3, 3], [3, 4], [4, 3], [4, 4]];
		$this->game_history = [];
	}

	public function getBoard() {
		return $this->board;
	}

	public function EchoGameResult() {
		$black_count = 0;
		$white_count = 0;
		foreach ($this->board as $board_row) {
			foreach ($board_row as $move) {
				if ($move == Stone::BLACK->value) {
					$black_count += 1;
				} else if ($move == Stone::WHITE->value) {
					$white_count += 1;
				}
			}
		}
		
		echo "\n\n Black = ".$black_count;
		echo "\n White = ".$white_count;
		echo "\n\n";

		$othello_history = "";
		foreach ($this->game_history as $history) {
			$horizontal_pos = $history[1];
			$horizontal_string = self::OTHELLO_HORIZONTAL_ALPHABET_ARRAY[$horizontal_pos];
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
				if ($move == Stone::BLACK->value) {
					$black_count += 1;
				} else if ($move == Stone::WHITE->value) {
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
			$game_result = Player::BLACK->value;;
			$game_diff = $black_count - $white_count;
		} else if ($white_count > $black_count) {
			$game_result = Player::WHITE->value;;
			$game_diff = $white_count - $black_count;
		}
		return [$black_count, $white_count, $game_result, $game_diff];
 	}

 	public function getCandidateBoard() {
 		$this->display_board = $this->board;
 		return $this->getCandidateBoardImpl($this->display_board, $this->moves_histories, $this->player);
 	}

 	public function getCandidateVirtualBoard($board, &$history, $player) {
 		$this->virtual_original_display_board = $board;
 		return $this->getCandidateBoardImpl($this->virtual_original_display_board, $history, $player);
 	}

	private function getCandidateBoardImpl(&$board, &$history, $player) {
		$enemy_player = $player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		[$enemy_player_array, $ally_player_array] = $this->getEnemyAndAllyPlayerArray($enemy_player, $board);
		$surroundCandidates =  $this->getSurroundCandidates($enemy_player_array, $history);
		[$surroundCandidates, $defeatedCandidates] = $this->traceSurroundCanMove($surroundCandidates, $board, $history, $player);
		foreach ($surroundCandidates as $candidate ) {
			$board[$candidate[0]][$candidate[1]] = Stone::CANDIDATE->value;
		}
		return [$board, count($surroundCandidates), $surroundCandidates, $defeatedCandidates];
	}

	public function getEnemyAndAllyPlayerArray ($enemy_player, $board) {
		$enemy_player_array = array();
		$ally_player_array = array();
		for ($i = 0; $i < self::BOARD_WIDTH; $i++) {
			for ($j = 0; $j < self::BOARD_WIDTH; $j++) {
				if ($board[$i][$j] == $enemy_player) {
					array_push($enemy_player_array, [$i, $j]);
				} else if ( $board[$i][$j] == $this->getPlayer() ) {
					array_push($ally_player_array, [$i, $j]);
				}
			}
		}
		return [$enemy_player_array, $ally_player_array];
	}

	public function traceSurroundCanMove($surroundCandidates, $board, $history, $player) {
		$candidate_array = array();
		$candidate_defeat_array = array();
		foreach ($surroundCandidates as $candidate) {
			$checkBelow = $this->checkBelowWithCount($candidate[0], $candidate[1], $player, false, $board, $history);
			$checkAbove = $this->checkAboveWithCount($candidate[0], $candidate[1], $player, false, $board, $history);
			$checkLeft  = $this->checkLeftWithCount($candidate[0], $candidate[1], $player, false, $board, $history);
			$checkRight = $this->checkRightWithCount($candidate[0], $candidate[1], $player, false, $board, $history);
			$checkAboveLeft = $this->checkAboveLeftWithCount($candidate[0], $candidate[1], $player, false, $board, $history);
			$checkAboveRight = $this->checkAboveRightWithCount($candidate[0], $candidate[1], $player, false, $board, $history);
			$checkBelowLeft = $this->checkBelowLeftWithCount($candidate[0], $candidate[1], $player, false, $board, $history);
			$checkBelowRight = $this->checkBelowRightWithCount($candidate[0], $candidate[1], $player, false, $board, $history);
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

	public function getSurroundCandidates ($enemy_player_array, &$history) {
		$surroundArray = array();
		foreach ($enemy_player_array as $enemy_move) {
			$surroundCandidate = $this->getSurroundMoves($enemy_move, $history);
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

	public function getSurroundMoves ($move, &$history) {
		return $this->getSurroundMovesImpl($move, $history);
	}

	public function getSurroundMovesImpl ($move, &$history) {
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
			if ($surroundMove[0] < 0 || $surroundMove[0] > self::BOARD_WITH_INDEX || $surroundMove[1] < 0 || $surroundMove[1] > self::BOARD_WITH_INDEX) {
				continue;
			}
			$hMoveCounter = 0;
			foreach ( $history as $hMove ) {
				// move has already appeared.
				if ( $hMove[0] == $surroundMove[0] && $hMove[1] == $surroundMove[1] ) {
					break;
				}
				$hMoveCounter += 1;
				if (count($history) == $hMoveCounter) {
					array_push($surroundMovesResult, $surroundMove);
				}
			}
		}
		return $surroundMovesResult;
	}

	public function getPlayer() {
		return $this->player;
	}

	public function getVirtualPlayer() {
		return $this->virtual_player;
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
		[$display_board_1, $candidate_count_1] = $this->getCandidateBoard();
		if ($candidate_count_1 == 0) {
			$this->player = $this->player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			$this->virtual_player = $this->virtual_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			[$display_board_2, $candidate_count_2] = $this->getCandidateBoard();
			if ($candidate_count_2 == 0) {
				return [false, false];
			}
			// $this->player = $this->player == Player::Black->value ? Player::White->value : Player::Black->value;
		}
		if (gettype($vertical_pos) != "integer" || gettype($vertical_pos) != "integer") {
			return [false, true];
		}
		if ((int)$vertical_pos < 0 || (int)$vertical_pos > self::BOARD_WIDTH || (int)$horizontal_pos < 0 || (int)$horizontal_pos > self::BOARD_WIDTH) {
			return [false, true];
		}
		if ($this->player != Player::BLACK->value && $this->player != Player::WHITE->value) {
			throw new Exception("Unknown player;");
		}
		$checkMoveHistories = $this->checkMoveHistories($vertical_pos, $horizontal_pos, $this->moves_histories);

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
		$this->commitDefeatedMove([$vertical_pos, $horizontal_pos], $this->player, $this->board);
		array_push($this->moves_histories, [$vertical_pos, $horizontal_pos]);
		array_push($this->game_history, [$vertical_pos, $horizontal_pos]);

		$this->player = $this->player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		$this->virtual_player = $this->virtual_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		[$display_board, $candidate_count] = $this->getCandidateBoard();
		if ($candidate_count != 0) {
			return [true, true];
		} else {
			$this->player = $this->player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			$this->virtual_player = $this->virtual_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			[$display_board2, $candidate_count2] = $this->getCandidateBoard();
			if ($candidate_count2 == 0) {
				return [true, false];
			} else {
				return [true, true];
			}
		}
	}
	public function moveInVirtualBoard($vertical_pos, $horizontal_pos, &$board, &$history) {
		[$display_board_1, $candidate_count_1] = $this->getCandidateVirtualBoard($board, $history, $this->virtual_player);
		if ($candidate_count_1 == 0) {
			$this->virtual_player = $this->virtual_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			[$display_board_2, $candidate_count_2] = $this->getCandidateVirtualBoard($board, $history, $this->virtual_player);
			if ($candidate_count_2 == 0) {
				return [false, false];
			}
			// $this->player = $this->player == Player::Black->value ? Player::White->value : Player::Black->value;
		}
		if (gettype($vertical_pos) != "integer" || gettype($vertical_pos) != "integer") {
			return [false, true];
		}
		if ((int)$vertical_pos < 0 || (int)$vertical_pos > self::BOARD_WIDTH || (int)$horizontal_pos < 0 || (int)$horizontal_pos > self::BOARD_WIDTH) {
			return [false, true];
		}
		if ($this->virtual_player != Player::BLACK->value && $this->virtual_player != Player::WHITE->value) {
			throw new Exception("Unknown player;");
		}
		$checkMoveHistories = $this->checkMoveHistories($vertical_pos, $horizontal_pos, $history);

		if ($checkMoveHistories == true) {
			return [false, true];
		}

		$checkBelow = $this->checkBelowWithCount($vertical_pos, $horizontal_pos, $this->virtual_player, true, $board, $history)[0];
		$checkAbove = $this->checkAboveWithCount($vertical_pos, $horizontal_pos, $this->virtual_player, true, $board, $history)[0];
		$checkLeft  = $this->checkLeftWithCount($vertical_pos, $horizontal_pos, $this->virtual_player, true, $board, $history)[0];
		$checkRight = $this->checkRightWithCount($vertical_pos, $horizontal_pos, $this->virtual_player, true, $board, $history)[0];
		$checkBelowLeft = $this->checkBelowLeftWithCount($vertical_pos, $horizontal_pos, $this->virtual_player, true, $board, $history)[0];
		$checkBelowRight = $this->checkBelowRightWithCount($vertical_pos, $horizontal_pos, $this->virtual_player, true, $board, $history)[0];
		$checkAboveLeft = $this->checkAboveLeftWithCount($vertical_pos, $horizontal_pos, $this->virtual_player, true, $board, $history)[0];
		$checkAboveRight = $this->checkAboveRightWithCount($vertical_pos, $horizontal_pos, $this->virtual_player, true, $board, $history)[0];
		if ($checkBelow == false && $checkAbove == false && $checkLeft == false && $checkRight == false && $checkBelowLeft == false &&  $checkBelowRight == false && $checkAboveLeft == false && $checkAboveRight == false ) {
			return [false, true];
		}
		$this->commitDefeatedMove([$vertical_pos, $horizontal_pos], $this->virtual_player, $board);
		array_push($history, [$vertical_pos, $horizontal_pos]);

		$this->virtual_player = $this->virtual_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		[$display_board1, $candidate_count1] = $this->getCandidateVirtualBoard($board, $history, $this->virtual_player);
		if ($candidate_count1 != 0) {
			return [true, true];
		} else {
			$this->virtual_player = $this->virtual_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			[$display_board2, $candidate_count2] = $this->getCandidateVirtualBoard($board, $history, $this->virtual_player);
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
		if (count($sanitize_near_corner_array) == 0) {
			$this->player = Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			$this->virtual_player = Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			return [true, false];
		}
		$game_history_len = count($this->game_history);
		$move_array = array();
		if ($game_history_len < 41) {
			$move_array = $this->checkSmallestOrBiggestDefeatMove($sanitize_near_corner_array, $candidate_defeat_count, true);
		} else {
			$move_array = $this->checkSmallestOrBiggestDefeatMove($sanitize_near_corner_array, $candidate_defeat_count, false);
		}
		$selected_candidate_id = rand(0, count($move_array) - 1);
		$selected_move = $move_array[$selected_candidate_id];
		$game_result = $this->move($selected_move[0], $selected_move[1]);
		return $game_result;
	}

	// 2手先読み。
	public function random_move3() {
		$this->virtual_original_board1 = $this->board;
		$this->virtual_original_display_board1 = $this->virtual_original_board1;
		$this->virtual_history1 = $this->moves_histories;
		$this->virtual_current_player = $this->getPlayer();
		$this->virtual_player = unserialize(serialize($this->getPlayer()));
		[$display_board1, $candidate_count1, $candidate_moves1, $candidate_defeat_count1] = $this->getCandidateVirtualBoard($this->virtual_original_board1, $this->virtual_history1, $this->virtual_player);
		$pick_corner_array = $this->checkHasCorner($candidate_moves1);
		if (count($pick_corner_array) == 1) {
			$game_result = $this->move($pick_corner_array[0][0], $pick_corner_array[0][1]);
			return $game_result;
		}
		$sanitize_near_corner_array = $this->checkHasNearCorner($pick_corner_array);
		if (count($sanitize_near_corner_array) == 0) {
			$this->player = Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			$this->virtual_player = Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			return [true, false];
		}
		$move_candidate_array = array();
		$move_candidate_enemy_array = array();
		$move_candidates_array = array();
		$total_search = 0;
		$first_move = "";
		$second_move = "";
		$third_move = "";
		$biggest_first_move = array();
		$biggest_first_move_count = 100;

		foreach ($sanitize_near_corner_array as $candidate_move1) {
			$this->virtual_player = $this->virtual_current_player;
			$this->virtual_original_board1 = unserialize(serialize($this->board));
			$this->virtual_original_display_board1 = $this->virtual_original_board1;
			$this->virtual_history1 = $this->moves_histories;
			$this->moveInVirtualBoard($candidate_move1[0], $candidate_move1[1], $this->virtual_original_board1, $this->virtual_history1);
			[$display_board2, $candidate_count2, $candidate_moves2, $candidate_defeat_count2] = $this->getCandidateVirtualBoard($this->virtual_original_board1, $this->virtual_history1, $this->virtual_player);
			$first_move = $candidate_move1[0].$candidate_move1[1];

			$smallest_second_move = array();
			$smallest_second_move_count = 0;
			foreach ($candidate_moves2 as $candidate_move2) {
				$this->virtual_player = $this->virtual_current_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
				$this->virtual_original_board2 = unserialize(serialize($this->virtual_original_board1));
				$this->virtual_original_display_board2 = $this->virtual_original_board2;
				$this->virtual_history2 = $this->virtual_history1;
				$this->moveInVirtualBoard($candidate_move2[0], $candidate_move2[1], $this->virtual_original_board2, $this->virtual_history2);
				[$display_board3, $candidate_count3, $candidate_moves3, $candidate_defeat_count3] = $this->getCandidateVirtualBoard($this->virtual_original_board2, $this->virtual_history2, $this->virtual_player);
				$second_move = $candidate_move2[0].$candidate_move2[1];
				$total_search += 1;
				//
				if ($smallest_second_move_count < $candidate_count3) {
					$smallest_second_move_count = $candidate_count3;
					array_push($smallest_second_move, $first_move.$second_move);
				} else if ($smallest_second_move_count == $candidate_count3) {
					array_push($smallest_second_move, $first_move.$second_move);
				}
			}
			// echo "first move candidate ".$smallest_second_move_count."\n";
			if ($biggest_first_move_count > $smallest_second_move_count) {
				$biggest_first_move_count = $smallest_second_move_count;
				$biggest_first_move = array();
				$biggest_first_move = $smallest_second_move;
				// echo "--- marked first move ".$biggest_first_move_count."\n";
			} else if ( $biggest_first_move_count == $smallest_second_move_count ) {
				$biggest_first_move = array_merge($biggest_first_move, $smallest_second_move);
				// echo "--- marked first move ".$biggest_first_move_count."\n";
			}
		}
		if (count($biggest_first_move) == 0) {
			$this->move($sanitize_near_corner_array[0][0], $sanitize_near_corner_array[0][1]);
			return [true, true];
		}
		echo $total_search."件 探索しました\n";
		$next_move_candidates = array();
		foreach ($biggest_first_move as $b_f_move) {
			array_push($next_move_candidates, [(int)substr($b_f_move, 0, 1), (int)substr($b_f_move, 1, 1)]);
		}
		//
		$next_move_id = rand(0, count($next_move_candidates) - 1);
		$next_move = $next_move_candidates[$next_move_id];
		$game_result = $this->move($next_move[0], $next_move[1]);
		return $game_result;
	}

	// 3手先読み
	public function random_move4() {
		$this->virtual_original_board1 = $this->board;
		$this->virtual_original_display_board1 = $this->virtual_original_board1;
		$this->virtual_history1 = $this->moves_histories;
		$this->virtual_current_player = $this->getPlayer();
		$this->virtual_player = unserialize(serialize($this->getPlayer()));
		[$display_board1, $candidate_count1, $candidate_moves1, $candidate_defeat_count1] = $this->getCandidateVirtualBoard($this->virtual_original_board1, $this->virtual_history1, $this->virtual_player);
		$pick_corner_array = $this->checkHasCorner($candidate_moves1);
		if (count($pick_corner_array) == 1) {
			$game_result = $this->move($pick_corner_array[0][0], $pick_corner_array[0][1]);
			return $game_result;
		}
		$sanitize_near_corner_array = $this->checkHasNearCorner($pick_corner_array);
		if (count($sanitize_near_corner_array) == 0) {
			$this->player = Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			$this->virtual_player = Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			return [true, false];
		}
		$move_candidate_array = array();
		$move_candidate_enemy_array = array();
		$move_candidates_array = array();
		$total_search = 0;
		$first_move = "";
		$second_move = "";
		$third_move = "";
		$biggest_first_move = array();
		$biggest_first_move_count = 100;

		foreach ($sanitize_near_corner_array as $candidate_move1) {
			$this->virtual_player = $this->virtual_current_player;
			$this->virtual_original_board1 = unserialize(serialize($this->board));
			$this->virtual_original_display_board1 = $this->virtual_original_board1;
			$this->virtual_history1 = $this->moves_histories;
			$this->moveInVirtualBoard($candidate_move1[0], $candidate_move1[1], $this->virtual_original_board1, $this->virtual_history1);
			[$display_board2, $candidate_count2, $candidate_moves2, $candidate_defeat_count2] = $this->getCandidateVirtualBoard($this->virtual_original_board1, $this->virtual_history1, $this->virtual_player);
			$first_move = $candidate_move1[0].$candidate_move1[1];


			$smallest_second_move = array();
			$smallest_second_move_count = 0;
			foreach ($candidate_moves2 as $candidate_move2) {
				$this->virtual_player = $this->virtual_current_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
				$this->virtual_original_board2 = unserialize(serialize($this->virtual_original_board1));
				$this->virtual_original_display_board2 = $this->virtual_original_board2;
				$this->virtual_history2 = $this->virtual_history1;
				$this->moveInVirtualBoard($candidate_move2[0], $candidate_move2[1], $this->virtual_original_board2, $this->virtual_history2);
				[$display_board3, $candidate_count3, $candidate_moves3, $candidate_defeat_count3] = $this->getCandidateVirtualBoard($this->virtual_original_board2, $this->virtual_history2, $this->virtual_player);
				$second_move = $candidate_move2[0].$candidate_move2[1];

				$biggest_third_move = array();
				$biggest_third_move_count = 100;
				foreach($candidate_moves3 as $candidate_move3) {
					$this->virtual_player = $this->virtual_current_player;
					$this->virtual_original_board3 = unserialize(serialize($this->virtual_original_board2));
					$this->virtual_original_display_board3 = $this->virtual_original_board3;
					$this->virtual_history3 = unserialize(serialize($this->virtual_history2));
					$this->moveInVirtualBoard($candidate_move3[0], $candidate_move3[1], $this->virtual_original_board3, $this->virtual_history3);
					[$display_board4, $candidate_count4, $candidate_moves4, $candidate_defeat_count4] = $this->getCandidateVirtualBoard($this->virtual_original_board3, $this->virtual_history3, $this->virtual_player);
					$third_move = $candidate_move3[0].$candidate_move3[1];
					$total_search += 1;
					// 
					if ($biggest_third_move_count > $candidate_count4) {
						$biggest_third_move_count = $candidate_count4;
						$biggest_third_move = array();
						array_push($biggest_third_move, $first_move.$second_move.$third_move);
					} else if ($biggest_third_move_count == $candidate_count4) {
						array_push($biggest_third_move, $first_move.$second_move.$third_move);
					}
				}
				// echo "biggest third ".$biggest_third_move_count."\n";
				if ($smallest_second_move_count < $biggest_third_move_count) {
					$smallest_second_move_count = $biggest_third_move_count;
					$smallest_second_move = array();
					$smallest_second_move = $biggest_third_move;
				} else if ($smallest_second_move_count == $biggest_third_move_count) {
					$smallest_second_move = array_merge($smallest_second_move, $biggest_third_move);
				}
			}


			// echo "smallest second ".$smallest_second_move_count."\n";
			if ($biggest_first_move_count > $smallest_second_move_count) {
				$biggest_first_move_count = $smallest_second_move_count;
				$biggest_first_move = array();
				$biggest_first_move = $smallest_second_move;
			} else if ( $biggest_first_move_count == $smallest_second_move_count ) {
				$biggest_first_move = array_merge($biggest_first_move, $smallest_second_move);
			}
		}
		// echo var_dump($biggest_first_move);
		// echo $biggest_first_move_count."\n";
		if (count($biggest_first_move) == 0) {
			$this->move($sanitize_near_corner_array[0][0], $sanitize_near_corner_array[0][1]);
			return [true, true];
		}
		echo $total_search."件 探索しました\n";
		$next_move_candidates = array();
		foreach ($biggest_first_move as $b_f_move) {
			array_push($next_move_candidates, [(int)substr($b_f_move, 0, 1), (int)substr($b_f_move, 1, 1)]);
		}
		//
		$next_move_id = rand(0, count($next_move_candidates) - 1);
		$next_move = $next_move_candidates[$next_move_id];
		$game_result = $this->move($next_move[0], $next_move[1]);
		return $game_result;
	}

	// 4手先読み。
	public function random_move5() {
		$this->virtual_original_board1 = $this->board;
		$this->virtual_original_display_board1 = $this->virtual_original_board1;
		$this->virtual_history1 = $this->moves_histories;
		$this->virtual_current_player = $this->getPlayer();
		$this->virtual_player = unserialize(serialize($this->getPlayer()));
		[$display_board1, $candidate_count1, $candidate_moves1, $candidate_defeat_count1] = $this->getCandidateVirtualBoard($this->virtual_original_board1, $this->virtual_history1, $this->virtual_player);
		$pick_corner_array = $this->checkHasCorner($candidate_moves1);
		if (count($pick_corner_array) == 1) {
			$game_result = $this->move($pick_corner_array[0][0], $pick_corner_array[0][1]);
			return $game_result;
		}
		$sanitize_near_corner_array = $this->checkHasNearCorner($pick_corner_array);
		if (count($sanitize_near_corner_array) == 0) {
			$this->player = Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			$this->virtual_player = Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
			return [true, false];
		}
		$move_candidate_array = array();
		$move_candidate_enemy_array = array();
		$move_candidates_array = array();
		$total_search = 0;
		$first_move = "";
		$second_move = "";
		$third_move = "";
		$biggest_first_move = array();
		$biggest_first_move_count = 500;

		foreach ($sanitize_near_corner_array as $candidate_move1) {
			$this->virtual_player = $this->virtual_current_player;
			$this->virtual_original_board1 = unserialize(serialize($this->board));
			$this->virtual_original_display_board1 = $this->virtual_original_board1;
			$this->virtual_history1 = $this->moves_histories;
			$this->moveInVirtualBoard($candidate_move1[0], $candidate_move1[1], $this->virtual_original_board1, $this->virtual_history1);
			[$display_board2, $candidate_count2, $candidate_moves2, $candidate_defeat_count2] = $this->getCandidateVirtualBoard($this->virtual_original_board1, $this->virtual_history1, $this->virtual_player);
			$first_move = $candidate_move1[0].$candidate_move1[1];

			$smallest_second_move = array();
			$smallest_second_move_count = -500;
			foreach ($candidate_moves2 as $candidate_move2) {
				$this->virtual_player = $this->virtual_current_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
				$this->virtual_original_board2 = unserialize(serialize($this->virtual_original_board1));
				$this->virtual_original_display_board2 = $this->virtual_original_board2;
				$this->virtual_history2 = $this->virtual_history1;
				$this->moveInVirtualBoard($candidate_move2[0], $candidate_move2[1], $this->virtual_original_board2, $this->virtual_history2);
				[$display_board3, $candidate_count3, $candidate_moves3, $candidate_defeat_count3] = $this->getCandidateVirtualBoard($this->virtual_original_board2, $this->virtual_history2, $this->virtual_player);
				$second_move = $candidate_move2[0].$candidate_move2[1];

				$biggest_third_move = array();
				$biggest_third_move_count = 500;
				foreach($candidate_moves3 as $candidate_move3) {
					$this->virtual_player = $this->virtual_current_player;
					$this->virtual_original_board3 = unserialize(serialize($this->virtual_original_board2));
					$this->virtual_original_display_board3 = $this->virtual_original_board3;
					$this->virtual_history3 = unserialize(serialize($this->virtual_history2));
					$this->moveInVirtualBoard($candidate_move3[0], $candidate_move3[1], $this->virtual_original_board3, $this->virtual_history3);
					[$display_board4, $candidate_count4, $candidate_moves4, $candidate_defeat_count4] = $this->getCandidateVirtualBoard($this->virtual_original_board3, $this->virtual_history3, $this->virtual_player);
					$third_move = $candidate_move3[0].$candidate_move3[1];
					if ($candidate_count4 == 0) {
						continue;
					}
					
					// forth ...
					$smallest_forth_move = array();
					$smallest_forth_move_count = -500;
					foreach ($candidate_moves4 as $candidate_move4) {
						$this->virtual_player = $this->virtual_current_player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
						$this->virtual_original_board4 = unserialize(serialize($this->virtual_original_board3));
						$this->virtual_history4 = unserialize(serialize($this->virtual_history3));
						$this->moveInVirtualBoard($candidate_move4[0], $candidate_move4[1], $this->virtual_original_board4, $this->virtual_history4);
						[$display_board5, $candidate_count5, $candidate_moves5, $candidate_defeat_count5] = $this->getCandidateVirtualBoard($this->virtual_original_board4, $this->virtual_history4, $this->virtual_player);
						$forth_move = $candidate_move4[0].$candidate_move4[1];
						$candidate_moves5 = $this->checkHasNearCorner($candidate_moves5);
						$total_search += 1;
						/*
						// fifth ...
						$biggest_fifth_move = array();
						$biggest_fifth_move_count = 0;
						foreach ($candidate_moves5 as $candidate_move5) {
							$this->virtual_original_board5 = $this->virtual_original_board4;
							$this->virtual_history5 = $this->virtual_history4;
							$this->virtual_player = $this->virtual_player == Player::Black->value ? Player::White->value : Player::Black->value;
							[$display_board6, $candidate_count6, $candidate_moves6, $candidate_defeat_count6] = $this->getCandidateVirtualBoard($this->virtual_original_board5, $this->virtual_history5);
							$fifth_move = $candidate_move5[0].$candidate_move5[1];
							$total_search += 1;
							if ($biggest_fifth_move_count < $candidate_count6) {
								$biggest_fifth_move_count = $candidate_count6;
								$biggest_fifth_move = array();
								array_push($biggest_fifth_move, $first_move.$second_move.$third_move.$forth_move.$fifth_move);
							} else if ($biggest_fifth_move_count == $candidate_count6) {
								array_push($biggest_fifth_move, $first_move.$second_move.$third_move.$forth_move.$fifth_move);
							}
						}
						*/
						/*
						first_move_point = $this->evaluation_board[$candidate_move1[0]][$candidate_move1[1]];
						$third_move_point = $this->evaluation_board[$candidate_move3[0]][$candidate_move3[1]];
						*/
						$candidate_count5 = count($candidate_moves5);
						// $evaluation_count = ($candidate_count5 - $candidate_count4 ** 2);
						$evaluation_count = $candidate_count4 ** 2;
						// echo "- fifth move candidate ".$evaluation_count." ".$first_move.$second_move.$third_move.$forth_move."\n";
						if ($smallest_forth_move_count < $evaluation_count) {
							$smallest_forth_move_count = $evaluation_count;
							$smallest_forth_move = array();
							$current_move = $first_move.$second_move.$third_move.$forth_move;
							array_push($smallest_forth_move, $current_move);
							// echo "--- marked fifth move candidate ".$evaluation_count." ".$first_move.$second_move.$third_move.$forth_move."\n";
						} else if ($smallest_forth_move_count == $evaluation_count) {
							$current_move = $first_move.$second_move.$third_move.$forth_move;
							array_push($smallest_forth_move, $current_move);
							// echo "--- marked fifth move candidate ".$evaluation_count." ".$first_move.$second_move.$third_move.$forth_move."\n";
						}
					}
					// if you want to down to 4th level, change smallest_forth_move_count to $candidate_count
					// echo "- forth move candidate".$smallest_forth_move_count." ".var_dump($smallest_forth_move)."\n";
					if ($biggest_third_move_count > $smallest_forth_move_count) {
						$biggest_third_move_count = $smallest_forth_move_count;
						$biggest_third_move = array();
						$biggest_third_move = $smallest_forth_move;
						// echo "--- marked forth move candidate".$smallest_forth_move_count." ".var_dump($smallest_forth_move)."\n";
					} else if ($biggest_third_move_count == $smallest_forth_move_count) {
						$biggest_third_move = array_merge($biggest_third_move, $smallest_forth_move);
						// echo "--- marked forth move candidate".$smallest_forth_move_count." ".var_dump($smallest_forth_move)."\n";
					}
				}
				if ($smallest_second_move_count < $biggest_third_move_count) {
					$smallest_second_move_count = $biggest_third_move_count;
					$smallest_second_move = array();
					$smallest_second_move = $biggest_third_move;
				} else if ($smallest_second_move_count == $biggest_third_move_count) {
					$smallest_second_move = array_merge($smallest_second_move, $biggest_third_move);
				}
			}
			// echo "first move candidate ".$smallest_second_move_count."\n";
			if ($biggest_first_move_count > $smallest_second_move_count) {
				$biggest_first_move_count = $smallest_second_move_count;
				$biggest_first_move = array();
				$biggest_first_move = $smallest_second_move;
				// echo "--- marked first move ".$biggest_first_move_count."\n";
			} else if ( $biggest_first_move_count == $smallest_second_move_count ) {
				$biggest_first_move = array_merge($biggest_first_move, $smallest_second_move);
				// echo "--- marked first move ".$biggest_first_move_count."\n";
			}
		}
		// echo var_dump($biggest_first_move);
		// echo $biggest_first_move_count."\n";
		if (count($biggest_first_move) == 0) {
			$this->move($sanitize_near_corner_array[0][0], $sanitize_near_corner_array[0][1]);
			return [true, true];
		}
		echo $total_search."件 探索しました\n";
		$next_move_candidates = array();
		foreach ($biggest_first_move as $b_f_move) {
			array_push($next_move_candidates, [(int)substr($b_f_move, 0, 1), (int)substr($b_f_move, 1, 1)]);
		}
		//
		$next_move_id = rand(0, count($next_move_candidates) - 1);
		$next_move = $next_move_candidates[$next_move_id];
		$game_result = $this->move($next_move[0], $next_move[1]);
		return $game_result;
	}

	public function checkHasCorner($candidate_moves) {
		foreach ($candidate_moves as $candidate_m) {
			if ($this->MoveIsEqual($candidate_m, [self::BOARD_MIN_CORNER, self::BOARD_MIN_CORNER]) || $this->MoveIsEqual($candidate_m, [self::BOARD_MIN_CORNER, self::BOARD_MAX_CORNER]) || $this->MoveIsEqual($candidate_m, [self::BOARD_MAX_CORNER, self::BOARD_MIN_CORNER]) || $this->MoveIsEqual($candidate_m, [self::BOARD_MAX_CORNER, self::BOARD_MAX_CORNER])) {
				return [$candidate_m];
			}
		}
		return $candidate_moves;
	}

	public function checkHasNearCorner($candidate_moves) {
		$notNearCornerArray = array();
		foreach ($candidate_moves as $candidate_m) {
			if ($this->MoveIsEqual($candidate_m, [1, self::BOARD_MIN_CORNER]) || $this->MoveIsEqual($candidate_m, [1, 1]) || $this->MoveIsEqual($candidate_m, [self::BOARD_MIN_CORNER, 1]) || $this->MoveIsEqual($candidate_m, [self::BOARD_MIN_CORNER, 6]) || $this->MoveIsEqual($candidate_m, [1, 6]) || $this->MoveIsEqual($candidate_m, [1, self::BOARD_MAX_CORNER]) || $this->MoveIsEqual($candidate_m, [6, self::BOARD_MIN_CORNER]) || $this->MoveIsEqual($candidate_m, [6, 1]) || $this->MoveIsEqual($candidate_m, [self::BOARD_MAX_CORNER, 1]) || $this->MoveIsEqual($candidate_m, [6, self::BOARD_MAX_CORNER]) || $this->MoveIsEqual($candidate_m, [6, 6]) || $this->MoveIsEqual($candidate_m, [self::BOARD_MAX_CORNER, 6])) {
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

	public function makeDefeatedStoneArrayFromCandidate($candidate_moves, $defeat_candidate) {
		$fixed_defeat_candidate = array();
		foreach ($candidate_moves as $candidate_m) {
			$defeat_candidate_key = (string)((string)$candidate_m[0].(string)$candidate_m[1]);
			if (array_key_exists($defeat_candidate_key, $defeat_candidate)) {
				$fixed_defeat_candidate = $fixed_defeat_candidate + array($defeat_candidate_key => $defeat_candidate[$defeat_candidate_key]);
			}
		}
		return $fixed_defeat_candidate;
	}

	public function checkSmallestOrBiggestDefeatMove($candidate_moves, $defeat_candidate, $smallest) {
		$fixed_defeat_candidate = $this->makeDefeatedStoneArrayFromCandidate($candidate_moves, $defeat_candidate);
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
		$result = $this->checkBelowImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $this->board, $this->moves_histories);
		return $result[0];
	}
	public function checkBelowWithCount($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		$result = $this->checkBelowImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $board, $history);
		return $result;
	}
	private function checkBelowImpl($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		if ($vertical_pos >= 6) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$defeated_enemy = array();
		$enemy_player = $player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		while (true) {
			if ($check_vertical_pos == self::BOARD_MAX_CORNER) { break; }
			if ( $board[$check_vertical_pos + 1][$horizontal_pos] == $enemy_player ) {
				$check_vertical_pos = $check_vertical_pos + 1;
				array_push($defeated_enemy, [$check_vertical_pos, $horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_vertical_pos == $vertical_pos) { ; return [false, 0]; }
		if ($check_vertical_pos == self::BOARD_MAX_CORNER) { return [false, 0]; }
		if ($board[$check_vertical_pos + 1][$horizontal_pos] != $player) {
			return [false, 0];
		}
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player, $board, $history);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkAbove($vertical_pos, $horizontal_pos, $player, $is_commit){
		$result = $this->checkAboveImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $this->board, $this->moves_histories);
		return $result[0];
	}
	public function checkAboveWithCount($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		$result = $this->checkAboveImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $board, $history);
		return $result;
	}
	private function checkAboveImpl($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		//
		if ($vertical_pos <= 1) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$defeated_enemy = array();
		$enemy_player = $player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		while (true) {
			if ($check_vertical_pos == self::BOARD_MIN_CORNER) { break; }
			if ( $board[$check_vertical_pos - 1][$horizontal_pos] == $enemy_player ) {
				$check_vertical_pos = $check_vertical_pos - 1;
				array_push($defeated_enemy, [$check_vertical_pos, $horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_vertical_pos == $vertical_pos) { return [false, 0]; }
		if ($check_vertical_pos == self::BOARD_MIN_CORNER) { return [false, 0]; }
		if ($board[$check_vertical_pos - 1][$horizontal_pos] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player, $board, $history);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkLeft($vertical_pos, $horizontal_pos, $player, $is_commit){
		$result = $this->checkLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $this->board, $this->moves_histories);
		return $result[0];
	}
	public function checkLeftWithCount($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		$result = $this->checkLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $board, $history);
		return $result;
	}
	private function checkLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		//
		if ($horizontal_pos <= 1) { return [false, 0]; }
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		while (true) {
			if ($check_horizontal_pos == self::BOARD_MIN_CORNER) { break; }
			if ($board[$vertical_pos][$check_horizontal_pos - 1] == $enemy_player) {
				$check_horizontal_pos = $check_horizontal_pos - 1;
				array_push($defeated_enemy, [$vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_horizontal_pos == $horizontal_pos) {return [false, 0]; }
		if ($check_horizontal_pos == self::BOARD_MIN_CORNER) { return [false, 0]; }
		if ($board[$vertical_pos][$check_horizontal_pos - 1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player, $board, $history);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkRight($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $this->board, $this->moves_histories);
		return $result[0];
	}
	public function checkRightWithCount($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		$result = $this->checkRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $board, $history);
		return $result;
	}
	private function checkRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		//
		if ($horizontal_pos >= 6) { return [false, 0]; }
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		while (true) {
			if ($check_horizontal_pos == self::BOARD_MAX_CORNER) { break; }
			if ($board[$vertical_pos][$check_horizontal_pos + 1] == $enemy_player) {
				$check_horizontal_pos = $check_horizontal_pos + 1;
				array_push($defeated_enemy, [$vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ($check_horizontal_pos == $horizontal_pos) { return [false, 0]; }
		if ($check_horizontal_pos == self::BOARD_MAX_CORNER) { return [false, 0]; }
		if ($board[$vertical_pos][$check_horizontal_pos + 1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player, $board, $history);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkBelowLeft($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkBelowLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $this->board, $this->moves_histories);
		return $result[0];
	}
	public function checkBelowLeftWithCount($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		$result = $this->checkBelowLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $board, $history);
		return $result;
	}
	private function checkBelowLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		//
		if ($vertical_pos >= 6 || $horizontal_pos <= 1) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		while (true) {
			if ($check_horizontal_pos == self::BOARD_MIN_CORNER || $check_vertical_pos == self::BOARD_MAX_CORNER) { break; }
			if ($board[$check_vertical_pos+1][$check_horizontal_pos-1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos + 1 ;
				$check_horizontal_pos = $check_horizontal_pos - 1 ;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return [false, 0]; }
		if ($check_vertical_pos == self::BOARD_MAX_CORNER || $check_horizontal_pos == self::BOARD_MIN_CORNER ) { return [false, 0]; }
		if ($board[$check_vertical_pos+1][$check_horizontal_pos-1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player, $board, $history);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkBelowRight($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkBelowRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $this->board, $this->moves_histories);
		return $result[0];
	}
	public function checkBelowRightWithCount($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		$result = $this->checkBelowRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $board, $history);
		return $result;
	}
	private function checkBelowRightImpl($vertical_pos, $horizontal_pos, $player, &$is_commit, &$board, &$history) {
		//
		if ($vertical_pos >= 6 || $horizontal_pos >= 6) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		while (true) {
			if ($check_horizontal_pos == self::BOARD_MAX_CORNER || $check_vertical_pos == self::BOARD_MAX_CORNER) { break; }
			if ($board[$check_vertical_pos+1][$check_horizontal_pos+1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos + 1;
				$check_horizontal_pos = $check_horizontal_pos + 1;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return [false, 0]; }
		if ($check_vertical_pos == self::BOARD_MAX_CORNER || $check_horizontal_pos == self::BOARD_MAX_CORNER ) { return [false, 0]; }
		if ($board[$check_vertical_pos+1][$check_horizontal_pos+1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player, $board, $history);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkAboveLeft($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkAboveLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $this->board, $this->moves_histories);
		return $result[0];
	}
	public function checkAboveLeftWithCount($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		$result = $this->checkAboveLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $board, $history);
		return $result;
	}
	private function checkAboveLeftImpl($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		//
		if ($vertical_pos <= 1 || $horizontal_pos <= 1) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		while (true) {
			if ($check_horizontal_pos == self::BOARD_MIN_CORNER || $check_vertical_pos == self::BOARD_MIN_CORNER) { break; }
			if ($board[$check_vertical_pos-1][$check_horizontal_pos-1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos - 1;
				$check_horizontal_pos = $check_horizontal_pos - 1;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return [false, 0]; }
		if ($check_vertical_pos == self::BOARD_MIN_CORNER || $check_horizontal_pos == self::BOARD_MIN_CORNER) { return [false, 0]; }
		if ($board[$check_vertical_pos-1][$check_horizontal_pos-1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player, $board, $history);
		}
		return [true, count($defeated_enemy)];
	}
	public function checkAboveRight($vertical_pos, $horizontal_pos, $player, $is_commit) {
		$result = $this->checkAboveRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $this->board, $this->moves_histories);
		return $result[0];
	}
	public function checkAboveRightWithCount($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		$result = $this->checkAboveRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit, $board, $history);
		return $result;
	}
	private function checkAboveRightImpl($vertical_pos, $horizontal_pos, $player, $is_commit, &$board, &$history) {
		//
		if ($vertical_pos <= 1 || $horizontal_pos >= 6) { return [false, 0]; }
		$check_vertical_pos = $vertical_pos;
		$check_horizontal_pos = $horizontal_pos;
		$defeated_enemy = array();
		$enemy_player = $player == Player::BLACK->value ? Player::WHITE->value : Player::BLACK->value;
		while (true) {
			if ($check_horizontal_pos == self::BOARD_MAX_CORNER || $check_vertical_pos == self::BOARD_MIN_CORNER) { break; }
			if ($board[$check_vertical_pos-1][$check_horizontal_pos+1] == $enemy_player) {
				$check_vertical_pos = $check_vertical_pos - 1;
				$check_horizontal_pos = $check_horizontal_pos + 1;
				array_push($defeated_enemy, [$check_vertical_pos, $check_horizontal_pos]);
				continue;
			}
			break;
		}
		if ( $check_vertical_pos == $vertical_pos ) { return [false, 0]; }
		if ($check_vertical_pos == self::BOARD_MIN_CORNER || $check_horizontal_pos == self::BOARD_MAX_CORNER) { return [false, 0]; }
		if ($board[$check_vertical_pos-1][$check_horizontal_pos+1] != $player) { return [false, 0]; }
		if ($is_commit == true) {
			$this->commitDefeatedMoves($defeated_enemy, $player, $board, $history);
		}
		return [true, count($defeated_enemy)];
	}
	public function commitDefeatedMoves($defeated_moves, $player, &$board, $history) {
		foreach ($defeated_moves as $d_move) {
			// only permit stones that has already appeared.
			foreach ($history as $h_move) {
				if ($h_move[0] == $d_move[0] && $h_move[1] == $d_move[1]) {
					$board[$d_move[0]][$d_move[1]] = $player;
				}
			}
		}
	}
	public function commitDefeatedMove($defeated_move, $player, &$board) {
		$board[$defeated_move[0]][$defeated_move[1]] = $player;
	}
	public function checkMoveHistories($vertical_pos, $horizontal_pos, $history) {
		foreach ($history as $move_h) {
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
				if ($move == Stone::BLACK->value) {
					return false;
				}
			}
		}
		return true;
	}
}
