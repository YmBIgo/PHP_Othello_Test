<?php

namespace Coffeecup\Othello;

class OthelloRepl {
	public function main() {
		while(true) {
			echo "Please Input vertical count;\n";
			$stdin_vertical = trim(fgets(STDIN));
			echo "Please Input horizontal count;\n"
			$stdin_horizontal = trim(fgets(STDIN));
		}
	}
}
