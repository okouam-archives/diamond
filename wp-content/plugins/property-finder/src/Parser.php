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
            $properties = array();
			$imageManager = new ImageManager($this->context);
            foreach ($xml->properties->property as $attributes) {
                $property = new PropertySummary($attributes, $propertyType);
                $property->image = $imageManager->getDefaultImageUrl($property->id, 300);
				array_push($properties, $property);
			}	
			$numProperties = count($properties);
			$this->context->info("Parsed $numProperties properties.");
			return $properties;
		}
	}
	
?>