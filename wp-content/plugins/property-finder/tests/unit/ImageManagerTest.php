<?php

	require_once(dirname(__FILE__) . '/../../includes.php');

	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class ImageManagerTest extends PHPUnit_Framework_TestCase
	{
		protected function setUp()
		{
        	$this->log = new Logger('ImageManagerTest');
			$this->log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
		}

		function testPopulatingRetrievesImages() 
		{
			
		}
	}
?>