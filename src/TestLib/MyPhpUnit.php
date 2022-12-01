<?php

namespace Coffeecup\Othello\TestLib;

require 'vendor/autoload.php';

use Coffeecup\Othello\TestLib\MyAssertion;
use Exception;
use Throwable;
use ReflectionClass;

class MyPhpUnit {

	private string $name;
	private string $status;
	private array $counter;

	public function __construct() {
		$this->setName("");
		$this->status = "unknown";
		$this->counter['passed'] = 0;
		$this->counter['error'] = 0;
		$this->counter['failed'] = 0;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getResult() {
		return $this->counter;
	}

	public function run() { // https://github.com/sebastianbergmann/phpunit/blob/35136a4fb2045460949428bd138c9c091441e5be/src/Framework/TestCase.php#L440
		try {
			$this->{$this->name}(); // https://github.com/sebastianbergmann/phpunit/blob/35136a4fb2045460949428bd138c9c091441e5be/src/Framework/TestCase.php#L1015
			$this->status = "success"; // https://github.com/sebastianbergmann/phpunit/blob/35136a4fb2045460949428bd138c9c091441e5be/src/Framework/TestCase.php#L623
		} catch(Exception $e) {
			echo "test failed with ".$e->getMessage()." \n";
			$this->counter['failed'] += 1;
			$this->status = "failed";
		} catch(Throwable $e) {
			echo "test error ".$e->getMessage()." \n";
			$this->counter['error'] += 1;
			$this->status = "error";
		}
		if ($this->status == "success") {
			$this->counter['passed'] += 1;
		}
	}

	public function runAll() {
		$current_class = new ReflectionClass($this); // (new ReflectionClass($this))->getName();
		$class_methods = $current_class->getMethods();
		$before_methods = array();
		$after_methods  = array();
		$test_methods   = array();
		foreach ($class_methods as $class_method) {
			$class_method_name = $class_method->name;
			if (str_starts_with($class_method_name, "test")) {
				array_push($test_methods, $class_method_name);
			} elseif (str_starts_with($class_method_name, "before")) {
				array_push($before_methods, $class_method_name);
			} elseif (str_starts_with($class_method_name, "after")) {
				array_push($after_methods, $class_method_name);
			}
		}
		foreach ($before_methods as $before_method) {
			$this->{$before_method}();
		}
		foreach ($test_methods as $test_method) {
			$this->setName($test_method);
			$this->run();
		}
		foreach ($after_methods as $after_method) {
			$this->{$after_method}();
		}
	}
}