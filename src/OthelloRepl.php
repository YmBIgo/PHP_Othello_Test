<?php

namespace Coffeecup\Othello;

require 'vendor/autoload.php';

use Coffeecup\Othello\OthelloLogic;
use Coffeecup\Othello\Viewer;

class OthelloRepl {

	private $othello;

	public function __construct(){
		$this->othello = new OthelloLogic();
		$this->othello->initBoard();
	}

	public function main() {
		while(true) {
			echo Viewer::view_board($this->othello->getBoard())."\n";
			echo "It's your turn ".$this->othello->getPlayer()." \n";
			echo "Please Input vertical count;\n";
			$stdin_vertical = (int)trim(fgets(STDIN));
			echo "Please Input horizontal count;\n";
			$stdin_horizontal = (int)trim(fgets(STDIN));
			$is_success = $this->othello->move($stdin_vertical - 1, $stdin_horizontal - 1);
			if ($is_success == true) {
				echo "\n";
			} else {
				echo "Your move is incorrect...\nmove again\n\n";
			}
		}
	}
}

$repl = new OthelloRepl();
$repl->main();