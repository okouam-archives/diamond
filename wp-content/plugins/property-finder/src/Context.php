<?php

	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class Context 
	{
		public $log;
		private $apiKey;
		private $eaid;
		private $sessionGUID;
		private $xslt;
		public $bid;

		function __construct($log, $apiKey, $eaid, $sessionGUID, $xslt, $bid)
		{
			$this->apiKey = $apiKey;
			$this->eaid = $eaid;
			$this->sessionGUID = $sessionGUID;
			$this->xslt = $xslt;
			$this->log = $log;
			$this->bid = $bid;
		}	

		function toQueryString($withSession = true) 
		{
			$queryString = "apiKey={$this->apiKey}&eaid={$this->eaid}&xslt={$this->xslt}";
			if ($withSession) $queryString = $queryString . "&sessionGUID={$this->sessionGUID}";
			return $queryString;
		}
	
		function info($msg) {
 			if ($this->log != null) $this->log->addInfo($msg);
		}
	}

?>