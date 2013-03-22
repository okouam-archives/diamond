<?php

    class PropertySummary {
        public $id;
        public $longitude;
        public $latitude;
        public $price;
        public $image;
        public $displayAddress;
        public $summary;
        public $bedrooms;

        function __construct($el, $propertyType) {
            $this->id = (int) $el["id"];
            $this->longitude = (string) $el["longitude"];
            $this->latitude = (string) $el["latitude"];
            if ($propertyType == SearchType::Lettings) {
                $this->price = $el["price"] . " pw";
            } else {
                $this->price = (string) $el["price"];
            }
            $this->bedrooms = (int) $el["bedrooms"];
            $this->images = array();
            $this->summary = (string) $el->summaryDescription;
            $this->displayAddress = (string) $el->useAddress;
        }
    }

?>