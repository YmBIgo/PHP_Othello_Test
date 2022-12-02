<?php

namespace Coffeecup\Othello;

use Exception;

/*
 * < board Content >
 *	 0 -> blank
 *	 1 -> black
 *	 2 -> white
 * 
 *   board should be 2nd dimention array() expressed by 0, 1, 2
 */

$expected_board_info =
	"□□□□□□□□\n".
	"□□□□□□□□\n".
	"□□□□□□□□\n".
	"□□□◯●□□□\n".
	"□□□●◯□□□\n".
	"□□□□□□□□\n".
	"□□□□□□□□\n".
	"□□□□□□□□\n";

class Viewer {
	public static function view_board($board_info) {
		$board_result = "";
		foreach ($board_info as $row_info) {
			foreach ($row_info as $info) {
				if ($info == 0) {
					$board_result = $board_result."□";
				} elseif ($info == 1) {
					$board_result = $board_result."●";
				} elseif ($info == 2) {
					$board_result = $board_result."◯";
				} else if ($info == 3) {
					$board_result = $board_result."×";
				} else {
					throw new Exception("Unknown info ".$info);
				}
			}
			$board_result = $board_result."\n";
		}
		return $board_result;
	}
}