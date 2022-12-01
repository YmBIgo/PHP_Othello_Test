<?php

namespace Coffeecup\Othello\TestLib;

use Exception;

class MyAssertion {
	public static function assertSame($expected, $actual, $message = '') {
		if ($expected == $actual) {
			return true;
		}
		$exceptionMessage = $message." expected = ".$expected." | actual = ".$actual." got.";
		throw new Exception($exceptionMessage);
	}
}