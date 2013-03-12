<?php

	class PriceRange
	{

		public $min;
		public $max;

		function __construct($minPrice, $maxPrice)
		{
			if ($minPrice < 0)
				throw new InvalidArgumentException("The minium price must be greater than 0");

			if ($maxPrice < 0)
				throw new InvalidArgumentException("The maximum price must be greater than 0");

			if ($minPrice > $maxPrice)
				throw new InvalidArgumentException("The minimum price cannot be greater than the maximum price");

			$this->min = $minPrice;
			$this->max = $maxPrice;
		}
	}

?>