<?php

use \Coffeecup\Othello\OthelloLogic;
use \Coffeecup\Othello\Viewer;
use PHPUnit\Framework\TestCase;

class BoardCandidateTest extends TestCase {

	private $othello_board;

	protected function setUp(): void {
		$this->othello_board = new OthelloLogic();
		$this->othello_board->initBoard();
	}

	public function testBoardStone_EnemyAndAlly() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$enemy_player = $this->othello_board->getPlayer() == 2 ? 1 : 2;
		[$enemy_player_array, $ally_player_array] = $this->othello_board->getEnemyAndAllyPlayerArray($enemy_player);
		$this->assertSame(count($enemy_player_array), 4);
		$this->assertSame(count($ally_player_array), 1);
	}

	public function testSurroundMoves1 () {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$enemy_player = $this->othello_board->getPlayer() == 2 ? 1 : 2;
		[$enemy_player_array, $ally_player_array] = $this->othello_board->getEnemyAndAllyPlayerArray($enemy_player);
		$surroundCandidateEnemy = $this->othello_board->getSurroundCandidates($enemy_player_array);
		$surroundCandidateAlly = $this->othello_board->getSurroundCandidates($ally_player_array);
		$this->assertSame(count($surroundCandidateEnemy), 13);
		$this->assertSame(count($surroundCandidateAlly), 5);
	}

	public function testSurroundMove2() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 5);
		$enemy_player = $this->othello_board->getPlayer() == 2 ? 1 : 2;
		[$enemy_player_array, $ally_player_array] = $this->othello_board->getEnemyAndAllyPlayerArray($enemy_player);
		$surroundCandidateEnemy = $this->othello_board->getSurroundCandidates($enemy_player_array);
		$surroundCandidateAlly = $this->othello_board->getSurroundCandidates($ally_player_array);
		$this->assertSame(count($surroundCandidateEnemy), 13);
		$this->assertSame(count($surroundCandidateAlly), 12);
	}

	public function testSurroundCandidate1() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 5);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 4);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□×□□□□\n".
			"□□×◯●□□□\n".
			"□□□●◯×□□\n".
			"□□□□●◯×□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}

	// This Test Fails
	public function testSurroundCandidate2() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(3, 6);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 5);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□××××●□\n".
			"□□□◯◯◯◯□\n".
			"□□□●●□×□\n".
			"□□□□●□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$this->othello_board->move(4, 6);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□×\n".
			"□□□□□□●□\n".
			"□□□◯◯◯●×\n".
			"□□□●●□●□\n".
			"□□××●×□×\n".
			"□□□□×□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}

	public function testSurroudnCandidate3() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 6);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□×□×●□□\n".
			"□□×●●□□□\n".
			"□□×●◯□□□\n".
			"□□×●◯□□□\n".
			"□□×□□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$this->othello_board->move(1, 2);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□◯×□●□□\n".
			"□□×◯●×□□\n".
			"□□□●◯×□□\n".
			"□□□●◯×□□\n".
			"□□□□××□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		// ×
		$expected_board_info =
			"□×□×□×□□\n".
			"□×◯◯◯●□□\n".
			"□□□●◯×□□\n".
			"□□□●◯×□□\n".
			"□□□●◯×□□\n".
			"□□□□□×□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$this->othello_board->move(0, 3);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info =
			"□□×●□□×□\n".
			"□□◯●◯●×□\n".
			"□□×●◯□□□\n".
			"□□×●◯□□□\n".
			"□□×●◯□□□\n".
			"□□×□□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}

}