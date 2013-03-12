<?php

	class Query
	{
		private $priceRange;
		private $bedrooms;
		public $type;
        private $ordering;
        private $postcode;

		function __construct($priceRange, $bedrooms, $type, $postcode, $ordering)
		{
			$this->priceRange = $priceRange;
			$this->bedrooms = $bedrooms;
			$this->type = $type;
            $this->postcode = $postcode;
            $this->ordering = $ordering;
		}

		function toQueryString() 
		{
            $output = "rentalPeriod={$this->type}&bedrooms={$this->bedrooms}&minPrice={$this->priceRange->min}&maxPrice={$this->priceRange->max}";

            if ($this->postcode != "" && $this->postcode != "any") {
                $output .= "&searchPostCode={$this->postcode}";
            }

            if ($this->ordering) {
                if ($this->ordering == "true") $output .= "&sortDescending=true";
                else  $output .= "&sortDescending=false";
            }

            //throw new Exception($output);

			return $output;
		}
	}

?>