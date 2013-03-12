<?php

	require_once(dirname(__FILE__) . '/../../includes.php');

	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class SearchTest extends PHPUnit_Framework_TestCase
	{
		protected $log;
		protected $context;

		protected function setUp()
		{
        	$this->log = new Logger('SearchTest');
			$this->log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
			$this->context = new Context($this->log, "E1D57034-6C07-44C4-A458-425CAE9D9247", 1322, uniqid(), -1, 2104);
		}

		public function testExecutingRetrievesProperties() 
		{
			$range = new PriceRange(10, 5000);
			$query = new Query($range, 2, "Street", SearchType::Lettings);
			$search = new Search($this->context);
			$result = $search->execute($query, 1, 2);
			$this->assertCount(2, $result->properties);
			$this->assertEquals(6, $result->propertyCount);
		}

		public function testFetchRetrievesProperty() 
		{
			$search = new Search($this->context);
			$result = $search->fetch(2727932);
		}
	}
?>