<?php

use \Coffeecup\Othello\OthelloInputGame;
use \Coffeecup\Othello\Viewer;
use PHPUnit\Framework\TestCase;

class ComputerPlayer2Test extends TestCase{
	private $othello_game;

	protected function setUp(): void {
		$this->othello_game = new OthelloInputGame();
	}

	public function testCornerCase70() {
		$othello_command = "C4E3F5C6C5G6G5E6C7C3C2B4A3A4D3E2D2D6D7G4F4E1C1F6F2F1F7E8B3G3F3D8E7C8H3H4H5B5A5A6A7B6H6F8H2D1G1G2B7";
		$this->othello_game->inputGame($othello_command);
		$this->othello_game->startGame();
		[$display_board, $candidate_count] = $this->othello_game->othello->getCandidateBoard();
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
		[$is_success, $is_game_continue] = $this->othello_game->othello->random_move2();
		$this->assertSame($this->othello_game->othello->getPlayer(), 1);
		[$display_board, $candidate_count] = $this->othello_game->othello->getCandidateBoard();
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
}