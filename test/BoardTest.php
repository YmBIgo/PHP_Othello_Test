<?php

use \Coffeecup\Othello\OthelloLogic;
use PHPUnit\Framework\TestCase;

/*
 * < Test for Othello >
 *
 * TestCases are written in https://docs.google.com/spreadsheets/d/1Bj317HkeMOtcbIHCWW7UbxIrKFkX9ysfkBhlnf_K0b8/edit?usp=sharing
 */

class BoardTest extends TestCase {

	private $othello_board;

	protected function setUp(): void {
		$this->othello_board = new OthelloLogic();
		$this->othello_board->initBoard();
	}

	/* Test Case 1 ~ 6 */
	public function testBoardCase01() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(3, 3);
		$this->AssertSame($result, false);
	}
	public function testBoardCase02() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, true);
	}
	public function testBoardCase03() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
	}
	public function testBoardCase04() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(3, 2);
		$this->AssertSame($result, true);
	}
	public function testBoardCase05() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(4, 5);
		$this->AssertSame($result, true);
	}
	public function testBoardCase06() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(5, 5);
		$this->AssertSame($result, false);
	}

	/* TestCase 7 ~ 13 */

	public function testBoardCase07() {
		$this->othello_board->initBoard();
		$result1 = $this->othello_board->move(5, 4);
		$this->AssertSame($result1, true);
		$result2 = $this->othello_board->move(5, 5);
		$this->AssertSame($result2, true);
	}
	public function testBoardCase08() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 2);
		$this->AssertSame($result, true);
	}
	public function testBoardCase09() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(6, 2);
		$this->AssertSame($result, true);
	}
	public function testBoardCase10() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(1, 5);
		$this->AssertSame($result, true);
	}
	public function testBoardCase11() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, false);
	}
	public function testBoardCase12() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(0, 1);
		$this->AssertSame($result, false);
	}
	public function testBoardCase13() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 2);
		$this->AssertSame($result, true);
	}

	/* Test Case 14 ~ 23 */

	public function testBoardCase14() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 5);
		$this->AssertSame($result, true);
	}	
	public function testBoardCase15() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(1, 4);
		$this->AssertSame($result, true);
	}
	public function testBoardCase16() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(3, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(4, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 2);
		$this->AssertSame($result, true);
	}
	public function testBoardCase17() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(3, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(4, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(4, 1);
		$this->AssertSame($result, true);
	}
	public function testBoardCase18() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(4, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(3, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 5);
		$this->AssertSame($result, true);
	}
	public function testBoardCase19() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(4, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(3, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(3, 6);
		$this->AssertSame($result, true);
	}
	public function testBoardCase20() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(1, 3);
		$this->AssertSame($result, false);
	}
	public function testBoardCase21() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 2);
		$this->AssertSame($result, false);
	}
	public function testBoardCase22() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 2);
		$this->AssertSame($result, true);
	}
	public function testBoardCase23() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(3, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(4, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, false);
	}

	/* TestCase 24 ~ */

	public function testBoardCase24() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(6, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(6, 4);
		$this->AssertSame($result, false);
	}
	public function testBoardCase25() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(3, 5);
		$this->AssertSame($result, false);
	}
	public function testBoardCase26() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(4, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(4, 5);
		$this->AssertSame($result, false);
	}
	public function testBoardCase27() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(4, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(3, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, false);
	}
	public function testBoardCase28() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(10, 10);
		$this->AssertSame($result, false);
	}
	public function testBoardCase29() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move("a", "b");
		$this->AssertSame($result, false);
	}
	public function testBoardCase30() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(5, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(5, 6);
		$this->AssertSame($result, false);
	}
	public function testBoardCase31() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(2, 3);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 4);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(2, 1);
		$this->AssertSame($result, false);
	}
	public function testBoardCase32() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(3, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(4, 2);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(6, 4);
		$this->AssertSame($result, false);
	}
	public function testBoardCase33() {
		$this->othello_board->initBoard();
		$result = $this->othello_board->move(4, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(3, 5);
		$this->AssertSame($result, true);
		$result = $this->othello_board->move(1, 3);
		$this->AssertSame($result, false);
	}
}

