<?php

use \Coffeecup\Othello\OthelloInputGame;
use \Coffeecup\Othello\Viewer;
use PHPUnit\Framework\TestCase;

class GameFinishTest extends TestCase {
	private $othello_game;

	protected function setUp(): void {
		$this->othello_game = new OthelloInputGame();
	}
	public function testFinishGameCase1() {
		$othello_command = "E6D6C4F6C7C6D7E3F5G6G4C5F4C3B7B6B4A8E7G5A5A7H6B8H5F3B5B3D3D8E2D2C8G3A4A6C2A3A2A1H3H4E8F8F7G8G7B2H8H7F2E1D1B1C1G1F1H2H1G2";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count] = $this->othello_game->othello->getCandidateBoard();
		$expected_board_info =
			"◯◯◯◯◯◯◯◯\n".
			"◯◯◯◯◯◯●◯\n".
			"◯◯◯●●●●◯\n".
			"◯◯●◯●●◯◯\n".
			"◯◯◯◯●●◯●\n".
			"◯◯●●◯◯●●\n".
			"◯◯●●●●●●\n".
			"◯◯◯◯◯◯◯◯\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$game_result = $this->othello_game->othello->getGameResult();
		$this->assertSame($game_result[0], 21);
		$this->assertSame($game_result[1], 43);
		$this->assertSame($game_result[2], 2);
		$this->assertSame($game_result[3], 22);
	}
	public function testFinishGameCase2() {
		$othello_command = "F5F6E6F4E3C5C4E7C6D2E2C3D3F3F2D1E1D6C1B3B4A4B5C2D7C8D8E8B6B2G4H4G3C7A6A5B1H2H3G1G5H5H1F1G2A7A2A1A3F8G8A8F7B8B7H8G7G6H6H7";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count] = $this->othello_game->othello->getCandidateBoard();
		$expected_board_info =
			"◯◯◯◯◯◯◯●\n".
			"●◯●●●●●●\n".
			"●●●●●●●●\n".
			"●●◯●◯●●●\n".
			"●◯●◯●◯●●\n".
			"●◯◯●●●◯●\n".
			"●●●●●●●◯\n".
			"●●●●●●●●\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$game_result = $this->othello_game->othello->getGameResult();
		$this->assertSame($game_result[0], 47);
		$this->assertSame($game_result[1], 17);
		$this->assertSame($game_result[2], 1);
		$this->assertSame($game_result[3], 30);
	}
	public function testFinishGameCase3() {
		$othello_command = "F5D6C3D3C4F4C5B3C2E6C6B4B5D2E3A6C1B6F3F6F7E1E2G5E7D7G6G4H4H5H6E8G3F2C8F1D8B8C7H2D1B1H3H7G2F8A4A3A2H1G1B7A8A7A5B2A1G7G8H8";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count] = $this->othello_game->othello->getCandidateBoard();
		$expected_board_info =
			"●●●●●●●◯\n".
			"●●◯●●●●◯\n".
			"●◯●◯◯●●◯\n".
			"●◯◯●●●●◯\n".
			"●◯◯◯●◯●◯\n".
			"●◯●◯◯●●◯\n".
			"●●●●●◯●◯\n".
			"●●●●●●●●\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$game_result = $this->othello_game->othello->getGameResult();
		$this->assertSame($game_result[0], 43);
		$this->assertSame($game_result[1], 21);
		$this->assertSame($game_result[2], 1);
		$this->assertSame($game_result[3], 22);
	}
	public function testFinishGameCase4() {
		$othello_command = "F5F6E6D6C5E3E7C4F7B5D7C7C6D8E8F8D3G8C8B8A6B6F2A4B7B3A5G6C3G4H6D2F4C2E2A8D1A7A2E1F1B4H4G5F3A3C1A1B1H3H2G3H5G1G2H1B2G7H7";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count] = $this->othello_game->othello->getCandidateBoard();
		$expected_board_info =
			"◯◯◯◯◯◯◯◯\n".
			"◯◯◯◯◯◯◯◯\n".
			"◯◯◯◯◯◯●◯\n".
			"◯◯◯◯◯◯●◯\n".
			"◯◯◯◯◯◯◯◯\n".
			"◯◯◯◯◯◯◯◯\n".
			"◯◯◯◯◯◯◯◯\n".
			"◯◯◯◯◯◯◯□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$game_result = $this->othello_game->othello->getGameResult();
		$this->assertSame($game_result[0], 2);
		$this->assertSame($game_result[1], 61);
		$this->assertSame($game_result[2], 2);
		$this->assertSame($game_result[3], 59);
	}
	public function testFinishGameCase5() {
		$othello_command = "C4C3D3C5D6E3B5E6F6E7F5C6C7D7B6F7B4C8D2B3F3E1F2A4A5G5G6F4D8E8B7G3G2H5F1G1H1H2C2A8B8C1E2D1G4H4H3A7A6H6G7H7B1B2A2A3G8F8H8A1";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count] = $this->othello_game->othello->getCandidateBoard();
		$expected_board_info =
			"◯●●●●●●●\n".
			"◯◯●●●●●●\n".
			"◯◯◯●●●◯●\n".
			"◯◯●◯◯●◯●\n".
			"●●◯●◯●◯●\n".
			"●●●●●◯●●\n".
			"◯◯◯◯◯◯◯●\n".
			"◯●◯◯◯◯◯◯\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$game_result = $this->othello_game->othello->getGameResult();
		$this->assertSame($game_result[0], 34);
		$this->assertSame($game_result[1], 30);
		$this->assertSame($game_result[2], 1);
		$this->assertSame($game_result[3], 4);
	}
}