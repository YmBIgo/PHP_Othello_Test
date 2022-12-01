<?php

namespace Coffeecup\Othello\Test;

require 'vendor/autoload.php';

use Coffeecup\Othello\TestLib\MyAssertion;
use Coffeecup\Othello\TestLib\MyPhpUnit;
use Coffeecup\Othello\OthelloLogic;
use Coffeecup\Othello\Viewer;

class LogicFirstMoveTest extends MyPhpUnit {


	private $othello;

	public function beforeTest() {
		$this->othello = new OthelloLogic();
		$this->othello->initBoard();
	}

	/*
	 * test with each function [check__]
	 */
	public function ignore_testFirstMoveAbove() {
		$this->othello->initBoard();
		$moveAbove = $this->othello->checkAbove(5, 4, 1);
		MyAssertion::assertSame(true, $moveAbove, "First Move @54 should return @44");
		$firstMoveAboveResult = Viewer::view_board($this->othello->getBoard());
		// echo $firstMoveAboveResult."\n\n";
	}
	public function ignore_testFirstMoveBelow() {
		$this->othello->initBoard();
		$moveBelow = $this->othello->checkBelow(2, 3, 1);
		MyAssertion::assertSame(true, $moveBelow, "First Move @23 should return @33");
		$firstMoveBelowResult = Viewer::view_board($this->othello->getBoard());
		// echo $firstMoveBelowResult."\n\n";
	}
	public function ignore_testFirstMoveLeft() {
		$this->othello->initBoard();
		$moveLeft = $this->othello->checkLeft(4, 5, 1);
		MyAssertion::assertSame(true, $moveLeft, "First Move @45 should return @44");
		$firstMoveLeftResult = Viewer::view_board($this->othello->getBoard());
		// echo $firstMoveLeftResult."\n\n";
	}
	public function ignore_testFirstMoveRight() {
		$this->othello->initBoard();
		$moveRight = $this->othello->checkRight(3, 2, 1);
		MyAssertion::assertSame(true, $moveRight, "FirstMove @32 should return @33");
		$firstMoveRightResult = Viewer::view_board($this->othello->getBoard());
		// echo $firstMoveRightResult."\n\n";
	}

	/*
	 * test with function[move]
	 */
	public function testFirstMoveAbove_ByMove() {
		$this->othello->initBoard();
		$moveAbove = $this->othello->move(5, 4);
		MyAssertion::assertSame(true, $moveAbove, "First Move @54 should return @44");
		/*
		$firstMoveAboveResult = Viewer::view_board($this->othello->getBoard());
		echo $firstMoveAboveResult."\n\n";
		*/
	}
	public function testFireMoveBelow_ByMove() {
		$this->othello->initBoard();
		$moveBelow = $this->othello->move(2, 3);
		MyAssertion::assertSame(true, $moveBelow, "First Move @23 should return @33");
		/*
		$firstMoveBelowResult = Viewer::view_board($this->othello->getBoard());
		echo $firstMoveBelowResult."\n\n";
		*/
	}
	public function testFirstMoveLeft_ByMove() {
		$this->othello->initBoard();
		$moveLeft = $this->othello->move(4, 5);
		MyAssertion::assertSame(true, $moveLeft, "First Move @45 should return @44");
		/*
		$firstMoveLeftResult = Viewer::view_board($this->othello->getBoard());
		echo $firstMoveLeftResult."\n\n";
		*/
	}
	public function testFirstMoveRIght_ByMove() {
		$this->othello->initBoard();
		$moveRight = $this->othello->move(3, 2);
		MyAssertion::assertSame(true, $moveRight, "First Move @32 should return @33");
		/*
		$firstMoveRightResult = Viewer::view_board($this->othello->getBoard());
		echo $firstMoveRightResult;
		*/
	}
	public function testFirstMoveAtHistory_ByMove() {
		$this->othello->initBoard();
		$moveAtHistory = $this->othello->move(3, 3);
		MyAssertion::assertSame(false, $moveAtHistory, "First Move @33 should not success");
	}
	public function testFirstMoveUnknown_ByMove() {
		$this->othello->initBoard();
		$moveUnknown = $this->othello->move(100, "a");
		MyAssertion::assertSame(false, $moveUnknown, "First Move @100a should not success");
	}
}

$logicTest = new LogicFirstMoveTest();
$logicTest->runAll();
$logicResult = $logicTest->getResult();
echo "Passed : ".$logicResult['passed']."\n";
echo "Failed : ".$logicResult['failed']."\n";
echo "Error  : ".$logicResult['error']."\n";