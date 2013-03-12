<?php

	class Parser 
	{
		private $context;

		function __construct($context)
		{
			$this->context = $context;
		}	

		function process($xml, $propertyType)
		{
			$lettings = array();
			$imageManager = new ImageManager($this->context);
            			foreach ($xml->properties->property as $attributes) {
				$letting = new Letting($attributes, false, $propertyType);
				array_push($letting->images, $imageManager->getDefaultImageUrl($letting->id, 300));
				array_push($lettings, $letting);	
			}	
			$numLettings = count($lettings);
			$this->context->info("Parsed $numLettings properties.");
			return $lettings;
		}
	}
	
?>