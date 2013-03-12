<?php

	require_once(dirname(__FILE__) . '/../../includes.php');

	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class PriceRangeTest extends PHPUnit_Framework_TestCase
	{
		protected function setUp()
		{
        	$this->log = new Logger('PriceRangeTest');
			$this->log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
		}

		public function testConstructorInstantiatesObject() 
		{
			$result = new PriceRange(100, 250);
			$this->assertTrue($result != null);
		}

		public function testConstructorThrowsExceptionOnNegativeMinPrice()
		{
			$this->setExpectedException('InvalidArgumentException');
			new PriceRange(-50, 100);
		}

		public function testConstructorThrowsExceptionOnNegativeMaxPrice()
		{
			$this->setExpectedException('InvalidArgumentException');
			new PriceRange(100, -50);
		}

		public function testConstructorThrowsExceptionOnInversedValues() 
		{
			$this->setExpectedException('InvalidArgumentException');
			new PriceRange(300, 250);
		}
	}
?>