<?php

	class Query
	{
		private $bedrooms;
		private $type;
        private $ordering;
        private $postcode;
        public $buyOrRent;
        private $maxPrice;
        private $minPrice;

		function __construct($minPrice, $maxPrice, $bedrooms, $buyOrRent, $postcode, $ordering, $type)
		{
            $this->maxPrice = $maxPrice;
			$this->minPrice = $minPrice;
			$this->bedrooms = $bedrooms;
			$this->type = $type;
            $this->buyOrRent = $buyOrRent;
            $this->postcode = $postcode;
            $this->ordering = $ordering;
		}

		function toQueryString() 
		{
            $output = "rentalPeriod={$this->buyOrRent}";

            if ($this->minPrice != "" && $this->minPrice != "any" && $this->minPrice != 0) {
                $output .= "&minPrice={$this->minPrice}";
            }

            if ($this->maxPrice != "" && $this->maxPrice != "any" && $this->maxPrice != 0) {
                $output .= "&maxPrice={$this->maxPrice}";
            }

            if ($this->bedrooms != "" && $this->bedrooms != "any" && $this->bedrooms != 0) {
                $output .= "&bedrooms={$this->bedrooms}";
            }

            if ($this->postcode != "" && $this->postcode != "any") {
                $output .= "&searchPostCode={$this->postcode}";
            }

            if ($this->type != "" && $this->type != "any") {
                $output .= "&propertyType={$this->type}";
            }

            if ($this->ordering) {
                if ($this->ordering == "true") $output .= "&sortDescending=true";
                else  $output .= "&sortDescending=false";
            }

			return $output;
		}
	}

?>