<?php

namespace Coffeecup\Othello\Test;

require 'vendor/autoload.php';

use Coffeecup\Othello\TestLib\MyPhpUnit;
use Coffeecup\Othello\TestLib\MyAssertion;
use Coffeecup\Othello\Viewer;

class ViewerTest extends MyPhpUnit {
	public function testViewerCase1() {
		$board_info_case1 = [
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 1, 0, 0, 0, 0],
			[0, 0, 0, 1, 1, 2, 0, 0],
			[0, 0, 1, 1, 1, 1, 0, 0],
			[0, 0, 0, 2, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
		];
		$expected_board_info_case1 =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□●□□□□\n".
			"□□□●●◯□□\n".
			"□□●●●●□□\n".
			"□□□◯□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$actual_board_info_case1 = Viewer::view_board($board_info_case1);
		MyAssertion::assertSame($expected_board_info_case1, $actual_board_info_case1, "board case1 should be equal.");
	}
	public function testViewerCase2() {
		$board_info_case2 = [
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 1, 1, 0, 0, 0],
			[0, 0, 2, 1, 1, 2, 0, 0],
			[0, 0, 2, 1, 1, 1, 0, 0],
			[0, 0, 2, 2, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
		];
		$expected_board_info_case2 =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□●●□□□\n".
			"□□◯●●◯□□\n".
			"□□◯●●●□□\n".
			"□□◯◯□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$actual_board_info_case2 = Viewer::view_board($board_info_case2);
		MyAssertion::assertSame($expected_board_info_case2, $actual_board_info_case2, "board case2 should be equal.");
	}
	public function testViewerFirstMove() {
		$init_board_info = [
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 2, 1, 0, 0, 0],
			[0, 0, 0, 1, 2, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
		];
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□●□□□□\n".
			"□□□◯●□□□\n".
			"□□□●◯□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$init_board_info[2][3] = 1;
		$actual_board_info = Viewer::view_board($init_board_info);
		MyAssertion::assertSame($expected_board_info, $actual_board_info, "First Move board should be equal.");
	}
	public function testViewerInit() {
		$init_board_info = [
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 2, 1, 0, 0, 0],
			[0, 0, 0, 1, 2, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
			[0, 0, 0, 0, 0, 0, 0, 0],
		];
		$expected_board_info =
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□◯●□□□\n".
			"□□□●◯□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n".
			"□□□□□□□□\n";
		$actual_board_info = Viewer::view_board($init_board_info);
		MyAssertion::assertSame($expected_board_info, $actual_board_info, "Init board should be equal.");
	}
}

$viewer_test = new ViewerTest();
$viewer_test->runAll();
$viewer_result = $viewer_test->getResult();
echo "Passed : ".$viewer_result['passed']."\n";
echo "Failed : ".$viewer_result['failed']."\n";
echo "Error  : ".$viewer_result['error']."\n";
