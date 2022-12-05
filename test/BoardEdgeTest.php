<?php

use \Coffeecup\Othello\OthelloLogic;
use \Coffeecup\Othello\Viewer;
use PHPUnit\Framework\TestCase;

class BoardEdgeTest extends TestCase {

	private $othello_board;

	protected function setUp(): void {
		$this->othello_board = new OthelloLogic();
		$this->othello_board->initBoard();
	}

	/* TestCase 34 ~ 38 */
	public function testBoardCase34() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(3, 6);
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
		$this->othello_board->move(1, 7);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 6);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□×◯\n".
			"□□××××◯□\n".
			"□□×◯◯◯●□\n".
			"□□□●●□●□\n".
			"□□□□●□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase35() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(3, 6);
		$this->othello_board->move(4, 6);
		//
		$this->othello_board->move(3, 7);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 4);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□××××●□\n".
			"□□□◯◯◯◯◯\n".
			"□□□●●□●□\n".
			"□□□□●□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase36() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(3, 6);
		$this->othello_board->move(4, 6);
		//
		$this->othello_board->move(5, 7);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 6);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□××××●□\n".
			"□□×◯◯◯●□\n".
			"□□□●●□◯□\n".
			"□□□□●□×◯\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase37() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(3, 6);
		$this->othello_board->move(4, 6);
		//
		$result = $this->othello_board->move(2, 7)[0];
		$this->assertSame($result, false);
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
	public function testBoardCase38() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(3, 6);
		$this->othello_board->move(4, 6);
		//
		$result = $this->othello_board->move(0, 7)[0];
		$this->assertSame($result, false);
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
	/* TestCase 39 ~ 43 */
	public function testBoardCase39() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		$this->othello_board->move(1, 2);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
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
		$this->othello_board->move(0, 1);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		// can perform corner
		$expected_board_info =
			"□●□□□□×□\n".
			"□×●◯◯●×□\n".
			"□□×●◯□□□\n".
			"□□×●◯□□□\n".
			"□□×●◯□□□\n".
			"□□××□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase40() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		$this->othello_board->move(1, 2);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
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
	public function testBoardCase41() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		$this->othello_board->move(1, 2);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
		$this->othello_board->move(0, 5);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info =
			"□□□□×●×□\n".
			"□□◯◯●●×□\n".
			"□□×●◯□□□\n".
			"□□×●◯□□□\n".
			"□□×●◯□□□\n".
			"□□××□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase42() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		$this->othello_board->move(1, 2);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
		$result = $this->othello_board->move(0, 2)[0];
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
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
	}
	public function testBoardCase43() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		$this->othello_board->move(1, 2);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
		$result = $this->othello_board->move(0, 0)[0];
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
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
	}
	/* Test Case 44 ~ 48 */
	public function testBoardCase44() {
		$this->othello_board->initBoard();
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		$this->othello_board->move(5, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(4, 1);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"××□□□□□□\n".
			"□◯□□□□□□\n".
			"×◯●●●□□□\n".
			"□◯◯◯◯□□□\n".
			"×●××××□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$this->othello_board->move(1, 0);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"●×□□□□□□\n".
			"□●××××□□\n".
			"□◯●●●×□□\n".
			"□◯◯◯◯□□□\n".
			"□●□□□□□□\n".
			"××□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase45() {
		$this->othello_board->initBoard();
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		$this->othello_board->move(5, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(4, 1);
		$this->othello_board->move(3, 0);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"×◯××××□□\n".
			"●●●●●□□□\n".
			"□◯◯◯◯□□□\n".
			"□●□□□□□□\n".
			"××□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase46() {
		$this->othello_board->initBoard();
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		$this->othello_board->move(5, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(4, 1);
		$this->othello_board->move(5, 0);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□◯××××□□\n".
			"□◯●●●×□□\n".
			"×●◯◯◯□□□\n".
			"●●□□□□□□\n".
			"××□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase47() {
		$this->othello_board->initBoard();
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		$this->othello_board->move(5, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(4, 1);
		$result = $this->othello_board->move(4, 0)[0];
		$this->assertSame($result, false);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"××□□□□□□\n".
			"□◯□□□□□□\n".
			"×◯●●●□□□\n".
			"□◯◯◯◯□□□\n".
			"×●××××□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase48() {
		$this->othello_board->initBoard();
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		$this->othello_board->move(5, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(4, 1);
		$result = $this->othello_board->move(0, 0)[0];
		$this->assertSame($result, false);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"××□□□□□□\n".
			"□◯□□□□□□\n".
			"×◯●●●□□□\n".
			"□◯◯◯◯□□□\n".
			"×●××××□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	/* TestCase 49 ~ 53 */
	public function testBoardCase49() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(6, 4);
		$this->othello_board->move(6, 3);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□×□□□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●□□□\n".
			"□□●◯◯◯×□\n".
			"□□×□×□×□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$this->othello_board->move(7, 2);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□××□□\n".
			"□□□◯●×□□\n".
			"□□□◯●×□□\n".
			"□□□◯●×□□\n".
			"□×●●◯◯□□\n".
			"□×●×□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase50() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(6, 4);
		$this->othello_board->move(6, 3);
		$this->othello_board->move(7, 4);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□□×□□\n".
			"□□□◯●×□□\n".
			"□□□◯●×□□\n".
			"□□□◯●×□□\n".
			"□×●◯●◯□□\n".
			"□×□□●×□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase51() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(6, 4);
		$this->othello_board->move(6, 3);
		$this->othello_board->move(7, 6);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□××□□\n".
			"□□□◯●×□□\n".
			"□□□◯●×□□\n".
			"□□□◯●×□□\n".
			"□×●◯◯●×□\n".
			"□×□□□□●□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase52() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(6, 4);
		$this->othello_board->move(6, 3);
		$result = $this->othello_board->move(7, 3)[0];
		$this->assertSame($result, false);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□×□□□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●□□□\n".
			"□□●◯◯◯×□\n".
			"□□×□×□×□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase53() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(6, 4);
		$this->othello_board->move(6, 3);
		$result = $this->othello_board->move(7, 7)[0];
		$this->assertSame($result, false);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□×□□□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●□□□\n".
			"□□●◯◯◯×□\n".
			"□□×□×□×□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
}
