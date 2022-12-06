<?php

use \Coffeecup\Othello\OthelloInputGame;
use \Coffeecup\Othello\Viewer;
use PHPUnit\Framework\TestCase;

class ComputerPlayer2Test extends TestCase{
	private $othello_game;

	protected function setUp(): void {
		$this->othello_game = new OthelloInputGame();
	}

	// Test Data C4E3F5C6C5G6G5E6C7C3C2B4A3A4D3E2D2D6D7G4F4E1C1F6F2F1F7E8B3G3F3D8E7C8H3H4H5B5A5A6A7B6H6F8H2D1G1G2B7A8B8A2H1H7H8G7G8B2A1B1

	public function testCornerCase70() {
		$othello_command = "C4E3F5C6C5G6G5E6C7C3C2B4A3A4D3E2D2D6D7G4F4E1C1F6F2F1F7E8B3G3F3D8E7C8H3H4H5B5A5A6A7B6H6F8H2D1G1G2B7";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count, $candidate_moves, $candidate_defeat_count] = $this->othello_game->othello->getCandidateBoard();
		$expected_board_info = 
			"□×●●●●●□\n".
			"××●◯◯◯◯●\n".
			"●●●◯●◯●●\n".
			"●●◯◯◯●●●\n".
			"●●◯◯●●●●\n".
			"●●◯◯◯●●●\n".
			"●●◯◯◯◯××\n".
			"×□◯◯◯◯□□\n";
		$this->assertSame($candidate_count, 6);
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$pick_corner_array = $this->othello_game->othello->checkHasCorner($candidate_moves);
		$this->assertSame(count($pick_corner_array), 1);
		$this->assertSame($this->othello_game->othello->MoveIsEqual($pick_corner_array[0], [7, 0]), true);
		[$is_success, $is_game_continue] = $this->othello_game->othello->random_move2();
		$this->assertSame($this->othello_game->othello->getPlayer(), 1);
		[$display_board, $candidate_count, $candidate_moves, $candidate_defeat_count] = $this->othello_game->othello->getCandidateBoard();
		$pick_corner_array = $this->othello_game->othello->checkHasCorner($candidate_moves);
		$this->assertSame(count($pick_corner_array), 3);
		$sanitize_near_corner_array = $this->othello_game->othello->checkHasNearCorner($pick_corner_array);
		$this->assertSame(count($sanitize_near_corner_array), 3);
		$move_array = $this->othello_game->othello->checkSmallestOrBiggestDefeatMove($sanitize_near_corner_array, $candidate_defeat_count, false);
		$this->assertSame(count($move_array), 1);
		$this->assertSame($move_array[0], [6, 6]);
		$expected_board_info = 
			"□□●●●●●□\n".
			"□□●◯◯◯◯●\n".
			"●●●◯●◯●●\n".
			"●●◯◯◯●●●\n".
			"●●◯◯●●●●\n".
			"●●◯◯◯●●●\n".
			"●◯◯◯◯◯×□\n".
			"◯×◯◯◯◯×□\n";
		$this->assertSame($candidate_count, 3);
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testEdgeCase71() {
		// confirm computer to play D1
		$othello_command = "C4E3F5C6C5G6G5E6C7C3C2B4A3A4D3E2D2D6D7G4F4E1C1F6F2F1F7E8B3G3F3D8E7C8H3H4H5B5A5A6A7B6H6F8H2D1";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count, $candidate_moves, $candidate_defeat_count] = $this->othello_game->othello->getCandidateBoard();
		$pick_corner_array = $this->othello_game->othello->checkHasCorner($candidate_moves);
		$this->assertSame(count($pick_corner_array), 5);
		$sanitize_near_corner_array = $this->othello_game->othello->checkHasNearCorner($pick_corner_array);
		$this->assertSame(count($sanitize_near_corner_array), 5);
		$move_array = $this->othello_game->othello->checkSmallestOrBiggestDefeatMove($sanitize_near_corner_array, $candidate_defeat_count, false);
		$this->assertSame(count($move_array), 1);
		$this->assertSame($move_array[0], [0, 6]);
		$expected_board_info = 
			"□□●◯◯◯×□\n".
			"□□●◯◯◯×●\n".
			"●●●◯●●●●\n".
			"●●◯◯●●●●\n".
			"●◯◯●●●●●\n".
			"●◯◯◯◯●●●\n".
			"●×◯◯◯◯□□\n".
			"□×◯◯◯◯×□\n";
		$this->assertSame($candidate_count, 5);
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		//
		[$is_success, $is_game_continue] = $this->othello_game->othello->random_move2();
		$this->assertSame($this->othello_game->othello->getPlayer(), 2);
		[$display_board, $candidate_count, $candidate_moves, $candidate_defeat_count] = $this->othello_game->othello->getCandidateBoard();
		$pick_corner_array = $this->othello_game->othello->checkHasCorner($candidate_moves);
		$this->assertSame(count($pick_corner_array), 6);
		$sanitize_near_corner_array = $this->othello_game->othello->checkHasNearCorner($pick_corner_array);
		$this->assertSame(count($sanitize_near_corner_array), 6);
		$move_array = $this->othello_game->othello->checkSmallestOrBiggestDefeatMove($sanitize_near_corner_array, $candidate_defeat_count, false);
		$this->assertSame(count($move_array), 2);
		$expected_board_info = 
			"□×●●●●●□\n".
			"××●◯◯●×●\n".
			"●●●◯●●●●\n".
			"●●◯◯●●●●\n".
			"●◯◯●●●●●\n".
			"●◯◯◯◯●●●\n".
			"●□◯◯◯◯××\n".
			"□□◯◯◯◯□□\n";
		$this->assertSame($candidate_count, 6);
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}

	public function testEdgeCase72() {
		$othello_command = "C4E3F5C6C5G6G5E6C7C3C2B4A3A4D3E2D2D6D7G4F4E1C1F6F2F1F7E8B3G3F3D8E7C8H3H4H5B5A5A6A7B6";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count, $candidate_moves, $candidate_defeat_count] = $this->othello_game->othello->getCandidateBoard();
		$pick_corner_array = $this->othello_game->othello->checkHasCorner($candidate_moves);
		$this->assertSame(count($pick_corner_array), 11);
		$sanitize_near_corner_array = $this->othello_game->othello->checkHasNearCorner($pick_corner_array);
		$this->assertSame(count($sanitize_near_corner_array), 3);
		$move_array = $this->othello_game->othello->checkSmallestOrBiggestDefeatMove($sanitize_near_corner_array, $candidate_defeat_count, false);
		$this->assertSame(count($move_array), 3);
		$this->assertSame($candidate_count, 11);
		$expected_board_info = 
			"□□●×◯◯×□\n".
			"□□●●◯◯××\n".
			"●●●◯●●◯●\n".
			"●●◯◯●●●●\n".
			"●◯◯●●●●●\n".
			"●◯◯●◯●◯×\n".
			"●×◯◯●◯××\n".
			"□×◯◯◯××□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}

	public function testEdgeCase73() {
		$othello_command = "C4E3F5C6C5G6G5E6C7C3C2B4A3A4D3E2D2D6D7G4F4E1C1F6F2F1F7E8B3G3F3D8E7C8H3H4H5B5";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count, $candidate_moves, $candidate_defeat_count] = $this->othello_game->othello->getCandidateBoard();
		$pick_corner_array = $this->othello_game->othello->checkHasCorner($candidate_moves);
		$this->assertSame(count($pick_corner_array), 12);
		$sanitize_near_corner_array = $this->othello_game->othello->checkHasNearCorner($pick_corner_array);
		$this->assertSame(count($sanitize_near_corner_array), 5);
		$move_array = $this->othello_game->othello->checkSmallestOrBiggestDefeatMove($sanitize_near_corner_array, $candidate_defeat_count, false);
		$this->assertSame(count($move_array), 2);
		$this->assertSame($candidate_count, 12);
		$expected_board_info =
			"□□●×◯◯×□\n".
			"□□●●◯◯××\n".
			"●●●◯●●◯●\n".
			"◯●◯◯●●●●\n".
			"×◯●●●●●●\n".
			"□×◯●◯●◯×\n".
			"□×●◯●◯××\n".
			"□□◯◯◯××□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}

	public function testCornderCase74() {
		$othello_command = "C4E3F5C6C5G6G5E6C7C3C2B4A3A4D3E2D2D6D7G4F4E1C1F6F2F1F7E8B3G3F3D8E7C8H3H4H5B5A5A6A7B6H6F8H2D1G1G2B7A8B8A2";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count, $candidate_moves, $candidate_defeat_count] = $this->othello_game->othello->getCandidateBoard();
		$pick_corner_array = $this->othello_game->othello->checkHasCorner($candidate_moves);
		$this->assertSame(count($pick_corner_array), 1);
		$this->assertSame($candidate_count, 4);
		$expected_board_info =
			"□□●●●●●×\n".
			"◯×●◯◯◯◯●\n".
			"◯◯●◯●◯●●\n".
			"◯●◯◯◯●●●\n".
			"◯●◯◯●●●●\n".
			"◯●◯●◯●●●\n".
			"◯●●◯◯◯×□\n".
			"◯●◯◯◯◯×□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		[$is_success, $is_game_continue] = $this->othello_game->othello->random_move2();
		$this->assertSame($this->othello_game->othello->getPlayer(), 2);
		$this->assertSame($is_success, true);
		[$display_board, $candidate_count, $candidate_moves, $candidate_defeat_count] = $this->othello_game->othello->getCandidateBoard();
		$this->assertSame($candidate_count, 4);
		$expected_board_info = 
			"□×●●●●●●\n".
			"◯×●◯◯◯●●\n".
			"◯◯●◯●●●●\n".
			"◯●◯◯●●●●\n".
			"◯●◯●●●●●\n".
			"◯●●●◯●●●\n".
			"◯●●◯◯◯××\n".
			"◯●◯◯◯◯□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}

}