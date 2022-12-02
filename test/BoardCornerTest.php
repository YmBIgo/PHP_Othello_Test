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

	/* TestCase 34 ~ 37 */
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
		$result = $this->othello_board->move(2, 7);
		$this->assertSame($result, false);
	}
	/* TestCase 38 ~  */
}
