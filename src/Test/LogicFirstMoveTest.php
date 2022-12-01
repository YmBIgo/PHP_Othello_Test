<?php

namespace Coffeecup\Othello\Test;

require 'vendor/autoload.php';

use Coffeecup\Othello\TestLib\MyAssertion;
use Coffeecup\Othello\TestLib\MyPhpUnit;
use Coffeecup\Othello\OthelloLogic;

class LogicFirstMoveTest extends MyPhpUnit {


	private $othello;

	public function beforeTest() {
		$this->othello = new OthelloLogic();
		$this->othello->initBoard();
	}

	public function testFirstMoveAbove() {
		$moveAbove = $this->othello->checkAbove(5, 4, 1);
		MyAssertion::assertSame(true, $moveAbove, "First Move @54 should return @44");
	}
	public function testFirstMoveBelow() {
		$moveBelow = $this->othello->checkBelow(2, 3, 1);
		MyAssertion::assertSame(true, $moveBelow, "First Move @23 should return @33");
	}
	public function testFirstMoveLeft() {
		$moveLeft = $this->othello->checkLeft(4, 5, 1);
		MyAssertion::assertSame(true, $moveLeft, "First Move @45 should return @44");
	}
	public function testFirstMoveRight() {
		$moveRight = $this->othello->checkRight(3, 2, 1);
		MyAssertion::assertSame(true, $moveRight, "FirstMove @32 should return @33");
	}
}

$logicTest = new LogicFirstMoveTest();
$logicTest->runAll();
$logicResult = $logicTest->getResult();
echo "Passed : ".$logicResult['passed']."\n";
echo "Failed : ".$logicResult['failed']."\n";
echo "Error  : ".$logicResult['error']."\n";