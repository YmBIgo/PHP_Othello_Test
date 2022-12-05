<?php

use \Coffeecup\Othello\OthelloLogic;
use \Coffeecup\Othello\Viewer;
use PHPUnit\Framework\TestCase;

class BoardCornerTest extends TestCase {

	private $othello_board;

	protected function setUp(): void {
		$this->othello_board = new OthelloLogic();
		$this->othello_board->initBoard();
	}
	/* Test Case 54 ~ 57 */
	public function testBoardCase54() {
		$this->othello_board->initBoard();
		$this->othello_board->move(4, 5);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(5, 6);
		$this->othello_board->move(4, 6);
		$this->othello_board->move(3, 6);
		$this->othello_board->move(6, 7);
		$this->othello_board->move(6, 6);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(5, 5);
		$this->othello_board->move(2, 5);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 12);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□×□××\n".
			"□□□××●●□\n".
			"□□□◯●●◯□\n".
			"□□×●◯●◯□\n".
			"□□□××●◯□\n".
			"□□□□×●●●\n".
			"□□□□×□××\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$this->othello_board->move(7, 7);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 9);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□×□●●×\n".
			"□□×◯●●◯×\n".
			"□□□●◯●◯×\n".
			"□□□××◯◯×\n".
			"□□□□□●◯●\n".
			"□□□□□□×◯\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase55() {
		$this->othello_board->initBoard();
		$this->othello_board->move(4, 5);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(5, 6);
		$this->othello_board->move(4, 6);
		$this->othello_board->move(3, 6);
		$this->othello_board->move(6, 7);
		$this->othello_board->move(6, 6);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(5, 5);
		$result = $this->othello_board->move(7, 7)[0];
		$this->assertSame($result, false);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 5);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□××□×●□\n".
			"□□□◯◯◯◯□\n".
			"□□□●◯◯◯×\n".
			"□□□×□◯◯□\n".
			"□□□□□●●●\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase56() {
		$this->othello_board->initBoard();
		$this->othello_board->move(4, 5);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(5, 6);
		$this->othello_board->move(4, 6);
		$this->othello_board->move(3, 6);
		$this->othello_board->move(6, 7);
		$this->othello_board->move(6, 6);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(5, 5);
		$this->othello_board->move(4, 7);
		$this->othello_board->move(5, 7);
		$this->othello_board->move(2, 7);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 11);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□××\n".
			"□□□□□□●●\n".
			"□□□◯◯◯●×\n".
			"□□×●●●◯●\n".
			"□□×××◯◯◯\n".
			"□□□□□●●●\n".
			"□□□□××××\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$this->othello_board->move(7, 7);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 6);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□××××●●\n".
			"□□×◯◯◯●□\n".
			"□□□●●●◯●\n".
			"□□□□□◯◯◯\n".
			"□□□□□●◯◯\n".
			"□□□□□□×◯\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase57() {
		$this->othello_board->initBoard();
		$this->othello_board->move(4, 5);
		$this->othello_board->move(3, 5);
		$this->othello_board->move(2, 6);
		$this->othello_board->move(5, 6);
		$this->othello_board->move(4, 6);
		$this->othello_board->move(3, 6);
		$this->othello_board->move(6, 7);
		$this->othello_board->move(6, 6);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(5, 5);
		$this->othello_board->move(4, 7);
		$this->othello_board->move(7, 5);
		$this->othello_board->move(7, 4);
		$this->othello_board->move(7, 6);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 6);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□××××●×\n".
			"□□□◯◯◯◯□\n".
			"□□□●●●◯●\n".
			"□□□□□◯◯□\n".
			"□□□□□●◯●\n".
			"□□□□●◯◯×\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$this->othello_board->move(7, 7);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□××\n".
			"□□□□□□●□\n".
			"□□□◯◯◯◯□\n".
			"□□×●●●◯●\n".
			"□□×××●◯□\n".
			"□□□□×●●●\n".
			"□□□□●●●●\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	/* Test Case 58 ~ 61 */
	public function testBoardCase58() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		$this->othello_board->move(1, 2);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
		$this->othello_board->move(0, 1);
		$this->othello_board->move(1, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(2, 2);
		$this->othello_board->move(4, 5);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 11);
		$expected_board_info =
			"×●×□□□×□\n".
			"×●●◯◯●×□\n".
			"×●◯●◯□□□\n".
			"□□×◯●×□□\n".
			"□□□●●●□□\n".
			"□□□×××□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$result = $this->othello_board->move(0, 0)[0];
		$this->assertSame($result, true);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info =
			"◯●□×××□□\n".
			"×◯●◯◯●□□\n".
			"□●◯●◯×□□\n".
			"□□×◯●□□□\n".
			"□□×●●●□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase59() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		$this->othello_board->move(1, 2);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
		$this->othello_board->move(0, 1);
		$this->othello_board->move(1, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(2, 2);
		$result = $this->othello_board->move(0, 0)[0];
		$this->assertSame($result, false);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 5);
		$expected_board_info =
			"□●□×□□□□\n".
			"□●◯◯◯●□□\n".
			"□●◯◯◯×□□\n".
			"□□□◯◯□□□\n".
			"□□×●◯×□□\n".
			"□□□□□×□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase60() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		$this->othello_board->move(1, 2);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
		$this->othello_board->move(0, 1);
		$this->othello_board->move(2, 2);
		$this->othello_board->move(0, 3);
		$this->othello_board->move(0, 2);
		$this->othello_board->move(0, 5);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info =
			"×●◯●×●×□\n".
			"□□◯◯●●×□\n".
			"□□◯●◯□□□\n".
			"□□×●◯□□□\n".
			"□□×●◯□□□\n".
			"□□××□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$result = $this->othello_board->move(0, 0)[0];
		$this->assertSame($result, true);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info =
			"◯◯◯●□●□□\n".
			"□×◯◯●●□□\n".
			"□×◯●◯×□□\n".
			"□□□●◯×□□\n".
			"□□□●◯×□□\n".
			"□□□□××□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase61() {
		$this->othello_board->initBoard();
		$this->othello_board->move(2, 3);
		$this->othello_board->move(2, 4);
		$this->othello_board->move(1, 5);
		$this->othello_board->move(1, 2);
		$this->othello_board->move(1, 3);
		$this->othello_board->move(1, 4);
		$this->othello_board->move(1, 1);
		$this->othello_board->move(2, 2);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 0);
		$this->othello_board->move(2, 0);
		$this->othello_board->move(1, 0);
		$this->othello_board->move(4, 0);
		$this->othello_board->move(3, 2);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 9);
		$expected_board_info =
			"×××××□×□\n".
			"●●●●●●□□\n".
			"●●●●◯□□□\n".
			"●●●◯◯□□□\n".
			"◯□×●◯□□□\n".
			"□□××□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$result = $this->othello_board->move(0, 0)[0];
		$this->assertSame($result, true);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 6);
		$expected_board_info =
			"◯×□□□□□□\n".
			"◯◯●●●●□□\n".
			"◯●◯●◯×□□\n".
			"◯●●◯◯×□□\n".
			"◯□×●◯×□□\n".
			"□□□□×□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	/* Test Case 62 ~ 65 */
	public function testBoardCase62() {
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		$this->othello_board->move(5, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(4, 1);
		$this->othello_board->move(5, 0);
		$this->othello_board->move(6, 0);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 10);
		$expected_board_info =
			"□□□□□□□□\n".
			"××□□□□□□\n".
			"□◯□□□□□□\n".
			"×◯●●●□□□\n".
			"□●◯◯◯×□□\n".
			"●◯××××□□\n".
			"◯×□□□□□□\n".
			"×□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$result = $this->othello_board->move(7, 0)[0];
		$this->assertSame($result, true);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 6);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□◯××××□□\n".
			"□◯●●●×□□\n".
			"×●◯◯◯□□□\n".
			"●◯□□□□□□\n".
			"●□□□□□□□\n".
			"●□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase63() {
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		$this->othello_board->move(5, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(4, 1);
		$this->othello_board->move(5, 0);
		$result = $this->othello_board->move(7, 0)[0];
		$this->assertSame($result, false);
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
	public function testBoardCase64() {
		$this->othello_board->initBoard();
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		$this->othello_board->move(5, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(4, 1);
		$this->othello_board->move(5, 2);
		$this->othello_board->move(6, 1);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 10);
		$expected_board_info =
			"□□□□□□□□\n".
			"×□□□□□□□\n".
			"×◯□□□□□□\n".
			"×◯●●●□□□\n".
			"×◯●●◯×□□\n".
			"×◯●□××□□\n".
			"×◯□□□□□□\n".
			"×□□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$result = $this->othello_board->move(7, 0)[0];
		$this->assertSame($result, true);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 8);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□◯×××□□□\n".
			"□◯●●●×□□\n".
			"□◯●●◯□□□\n".
			"□◯●××□□□\n".
			"□●□×□□□□\n".
			"●×□□□□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase65() {
		$this->othello_board->initBoard();
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		$this->othello_board->move(5, 1);
		$this->othello_board->move(2, 1);
		$this->othello_board->move(3, 1);
		$this->othello_board->move(4, 1);
		$this->othello_board->move(5, 2);
		$this->othello_board->move(6, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(7, 3);
		$this->othello_board->move(7, 2);
		$this->othello_board->move(7, 1);
		$this->othello_board->move(7, 4);
		$this->othello_board->move(5, 4);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 13);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□◯××××□□\n".
			"□◯●●●×□□\n".
			"□◯◯●●×□□\n".
			"×●◯●●×□□\n".
			"××●●××□□\n".
			"×●●●◯□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$result = $this->othello_board->move(7, 0)[0];
		$this->assertSame($result, true);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info =
			"□□□□□□□□\n".
			"××□□□□□□\n".
			"×◯□□□□□□\n".
			"×◯●●●□□□\n".
			"×◯◯●●□□□\n".
			"×●◯●●□□□\n".
			"□×●●□□□□\n".
			"◯◯◯◯◯□□□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	/* Test Case 66 ~ */
	public function testBoardCase66() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(6, 4);
		$this->othello_board->move(6, 3);
		$this->othello_board->move(7, 6);
		$this->othello_board->move(5, 5);
		$this->othello_board->move(7, 4);
		$this->othello_board->move(7, 5);
		$this->othello_board->move(5, 6);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 11);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□××□□\n".
			"□□□◯●×□□\n".
			"□□□◯●××□\n".
			"□□□◯●●●×\n".
			"□×●◯◯●×□\n".
			"□×□×●◯●×\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$result = $this->othello_board->move(7, 7)[0];
		$this->assertSame($result, true);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 6);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□×□□□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●●●□\n".
			"□□●◯◯●□□\n".
			"□□××●◯◯◯\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase67() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(6, 4);
		$this->othello_board->move(6, 3);
		$this->othello_board->move(7, 6);
		$this->othello_board->move(5, 5);
		$this->othello_board->move(7, 4);
		$this->othello_board->move(7, 5);
		$result = $this->othello_board->move(7, 7)[0];
		$this->assertSame($result, false);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□×□□□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●□□□\n".
			"□□×◯●◯×□\n".
			"□□●◯◯◯×□\n".
			"□□×□●◯●□\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase68() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(6, 4);
		$this->othello_board->move(6, 3);
		$this->othello_board->move(7, 6);
		$this->othello_board->move(6, 6);
		$this->othello_board->move(7, 4);
		$this->othello_board->move(5, 5);
		$this->othello_board->move(3, 2);
		$this->othello_board->move(4, 2);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 11);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□×●●●×□□\n".
			"□□◯◯◯××□\n".
			"□××◯●◯×□\n".
			"□□●◯●●◯×\n".
			"□□××●□●×\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$result = $this->othello_board->move(7, 7)[0];
		$this->assertSame($result, true);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 12);
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□×××××□□\n".
			"□□●●●×□□\n".
			"□□◯◯●×□□\n".
			"□□□◯●●×□\n".
			"□×●◯●●●×\n".
			"□×□□●×●●\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
	public function testBoardCase69() {
		$this->othello_board->initBoard();
		$this->othello_board->move(5, 4);
		$this->othello_board->move(5, 3);
		$this->othello_board->move(6, 2);
		$this->othello_board->move(6, 5);
		$this->othello_board->move(6, 4);
		$this->othello_board->move(6, 3);
		$this->othello_board->move(7, 6);
		$this->othello_board->move(5, 5);
		$this->othello_board->move(4, 5);
		$this->othello_board->move(5, 6);
		$this->othello_board->move(6, 7);
		$this->othello_board->move(5, 7);
		$this->othello_board->move(3, 2);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 13);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□×××□□□\n".
			"□□●●●××□\n".
			"□□×●◯●×□\n".
			"□□□◯●◯◯◯\n".
			"□×●◯◯●×●\n".
			"□×□□××●×\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
		$result = $this->othello_board->move(7, 7)[0];
		$this->assertSame($result, true);
		[$display_board, $candidate_count] = $this->othello_board->getCandidateBoard();
		$this->assertSame($candidate_count, 7);
		$expected_board_info = 
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□●●●×□□\n".
			"□□□●◯●□×\n".
			"□□×◯●◯◯◯\n".
			"□□●◯◯●×◯\n".
			"□□×××□●◯\n";
		$this->assertSame(Viewer::view_board($display_board), $expected_board_info);
	}
}