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

	public function testFirstMoveAbove() {
		$this->othello->initBoard();
		$moveAbove = $this->othello->checkAbove(5, 4, 1);
		MyAssertion::assertSame(true, $moveAbove, "First Move @54 should return @44");
		$firstMoveAboveResult = Viewer::view_board($this->othello->getBoard());
		// echo $firstMoveAboveResult."\n\n";
	}
	public function testFirstMoveBelow() {
		$this->othello->initBoard();
		$moveBelow = $this->othello->checkBelow(2, 3, 1);
		MyAssertion::assertSame(true, $moveBelow, "First Move @23 should return @33");
		$firstMoveBelowResult = Viewer::view_board($this->othello->getBoard());
		// echo $firstMoveBelowResult."\n\n";
	}
	public function testFirstMoveLeft() {
		$this->othello->initBoard();
		$moveLeft = $this->othello->checkLeft(4, 5, 1);
		MyAssertion::assertSame(true, $moveLeft, "First Move @45 should return @44");
		$firstMoveLeftResult = Viewer::view_board($this->othello->getBoard());
		// echo $firstMoveLeftResult."\n\n";
	}
	public function testFirstMoveRight() {
		$this->othello->initBoard();
		$moveRight = $this->othello->checkRight(3, 2, 1);
		MyAssertion::assertSame(true, $moveRight, "FirstMove @32 should return @33");
		$firstMoveRightResult = Viewer::view_board($this->othello->getBoard());
		// echo $firstMoveRightResult."\n\n";
	}
}

$logicTest = new LogicFirstMoveTest();
$logicTest->runAll();
$logicResult = $logicTest->getResult();
echo "Passed : ".$logicResult['passed']."\n";
echo "Failed : ".$logicResult['failed']."\n";
echo "Error  : ".$logicResult['error']."\n";