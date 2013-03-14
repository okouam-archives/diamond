<?php

	class SearchResult
	{
		public $page;
		public $perPage;
		public $propertyCount;
		public $pageCount;
		public $properties;
	
		public function __construct($page, $perPage, $propertyCount, $pageCount, $properties)
		{
			$this->properties = $properties;
			$this->page = (int) $page;
			$this->perPage = (int) $perPage;
			$this->propertyCount = (int) $propertyCount;
			$this->pageCount = (int) $pageCount;
		}
	}
?>