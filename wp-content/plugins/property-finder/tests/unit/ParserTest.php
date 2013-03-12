<?php

	require_once(dirname(__FILE__) . '/../../includes.php');

	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class ParserTest extends PHPUnit_Framework_TestCase
	{
		private $apiKey = "E1D57034-6C07-44C4-A458-425CAE9D9247";
		private $eaid = 1322;
		private $xslt = -1;
		private $bid = 2104;
		private $sessionGuid;
		protected $log;

		protected function setUp()
		{
        	$this->log = new Logger('ParserTest');
			$this->log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
			$this->sessionGuid = uniqid();
		}

		function testProcessingCreatesLettings() 
		{
			$cwd = dirname(__FILE__);			
			$xml = simplexml_load_file("$cwd/../fixtures/search_results.xml");
			$context = new Context($this->log, $this->apiKey, $this->eaid, $this->sessionGuid, $this->xslt, $this->bid);
			$parser = new Parser($context, SearchType::Lettings);
			$lettings = $parser->process($xml->propertySearchLettings);
			$this->assertEquals(2753649, $lettings[0]->id);	
		}
	}
?>