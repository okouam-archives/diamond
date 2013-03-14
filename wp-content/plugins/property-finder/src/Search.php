<?php
	
	class Search
	{
		private $context;
		private $type;

		function __construct($context)
		{
			$this->context = $context;
		}

		function fetch($id) 
		{
			if ($id == null)
				throw new Exception("A property ID must be provided");

			$uri = "http://www.dezrez.com/DRApp/DotNetSites/WebEngine/property/Property.aspx";
 			$url = "$uri?{$this->context->toQueryString()}&pid=$id";

 			$this->context->info("Fetching a property from DezRez using the uri $url.");

			$response = \Httpful\Request::get($url)  
			    			->expectsXml()           
			    			->send();      

 			return $this->parseSingle($response->body); 
		}

		function parseSingle($content) 
		{
			$root = $content->propertyFullDetails->property;
            $rentalperiod = $root['rentalperiod'] == SearchType::Sales ? SearchType::Sales : SearchType::Lettings;
			$letting = new Letting($root, true, $rentalperiod);
			return $letting;
		}

		function execute($query, $page, $perPage) 
		{			
			if ($query == null)
				throw new Exception("A query must be provided");

			if ($page == null)
				throw new Exception("A page number must be provided");

			if ($perPage == null)
				throw new Exception("A page size must be provided");
			
			$uri = "http://www.dezrez.com/DRApp/DotNetSites/WebEngine/property/Default.aspx";
 			$url = "$uri?{$this->context->toQueryString()}&page=$page&perpage=$perPage&{$query->toQueryString()}";

 			$this->context->info("Making a search request to DezRez using the uri $url.");

 			$this->type = $query->buyOrRent;

			$response = \Httpful\Request::get($url)
			    			->expectsXml()
			    			->send();

			return $this->parseMultiple($response->body); 
		}

		function parseMultiple($content) 
		{
			$root = null;
			if ($this->type == SearchType::Lettings) {
				$root = $content->propertySearchLettings;
			} else {
                $root = $content->propertySearchSales;
            }
			$parser = new Parser($this->context);
			$properties = $parser->process($root, $this->type);
			$page = $root->properties->pages['page'];
			$perPage = $root->properties->pages['perPage'];
			$propertyCount = $root->properties->pages['count'];
			$pageCount = $root->properties->pages['pageCount'];
			return new SearchResult($page, $perPage, $propertyCount, $pageCount, $properties);
		}
	}

?>