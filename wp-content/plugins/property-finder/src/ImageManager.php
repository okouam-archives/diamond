<?php

	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class ImageManager
	{
		private $context;

		function __construct($context)
		{
			$this->context = $context;
		}	

		function getDefaultImageUrl($id, $width)
		{
			$queryString = $this->context->toQueryString(false);
			$uri = "http://www.dezrez.com/DRApp/DotNetSites/WebEngine/property/pictureResizer.aspx";
			$bid = $this->context->bid;
 			return "$uri?$queryString&pid=$id&picture=1&width=$width&bid=$bid";
		}
	}

?>