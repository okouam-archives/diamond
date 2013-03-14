<?php

	class Letting
	{
		public $id;
		public $longitude;
		public $latitude;
		public $isFeatured;
		public $price;
		public $bedrooms;
		public $bathrooms;
		public $images;
		public $displayAddress;
		public $hasImages;
		public $description;
        public $summary;
		public $propertyType;
		public $receptions;
		public $garages;
		public $gardens;
		public $parkingSpaces;
		public $otherRooms;
        public $floorplans;
        public $epc_chart;
        public $features = array();

		function __construct($el, $propertyType) {
			$this->id = (int) $el["id"];
			$this->longitude = (string) $el["longitude"];
			$this->latitude = (string) $el["latitude"];
			$this->isFeatured = (bool) $el["featured"];
            $rentalperiod = $el['rentalperiod'];
            if ($rentalperiod == 0 or $rentalperiod == 1) {
                $this->price = (string) $el["price"];
            } else if ($rentalperiod == 2)  {
                $this->price = "£" . (number_format(round((((double) $el["priceVal"]) * 7 * 52)))) . " pw";
            } else if ($rentalperiod == 3)  {
                $this->price = "£" . (number_format((double) $el["priceVal"])) . " pw";
            } else if ($rentalperiod == 4)  {
                $this->price = "£" . (number_format(round(((((double) $el["priceVal"]) * 12) / 52)))) . " pw";
            } else if ($rentalperiod == 5)  {
                $this->price = "£" . (number_format(round(((((double) $el["priceVal"]) * 4) / 52)))) . " pw";
            } else if ($rentalperiod == 6)  {
                $this->price = "£" . (number_format(round((((double) $el["priceVal"]) / 52)))) . " pw";
            }
			$this->bedrooms = (int) $el["bedrooms"];
			$this->bathrooms = (int) $el["bathrooms"];
			$this->receptions = (string) $el['receptions'];
			$this->propertyType = $this->asCategory((int) $el['propertyType']);
			$this->garages = (string) $el['garages'];
			$this->gardens = (string) $el['gardens'];
			$this->otherRooms = (string) $el['otherrooms'];
			$this->parkingSpaces = (string) $el['parkingSpaces'];
			$this->images = array();

            foreach($el->media->picture as $image) {
                if ($image['category'] == 'primary' || $image['category'] == 'secondary') {
                    array_push($this->images, (string) $image);
                } else if ($image['category'] == 'floorplan') {
                    $this->floorplans = (string) $image;
                }
            }
            if ($el->homeinformationpack) {
                if ($el->homeinformationpack->info) {
                    if ($el->homeinformationpack->info->hip) {
                        $this->epc_chart = (string) $el->homeinformationpack->info->hip;
                    }
                }
            }
            $this->displayAddress = (string) $el->address->useAddress;
            $this->description = "";

            foreach($el->text->description as $text) {
                if ($text->attributes->summary) {
                    $this->summary = (string) $text;
                } else {
                    $this->description = $this->description . (string) $text;
                }
            }

            $area = $el->text->areas->area;

            foreach($area->feature as $feature) {
                array_push($this->features, (string) $feature->heading);
            }
		}

		function asCategory($propertyType) {
			switch($propertyType)
			{
				case 1:
					return "Terraced (House)";
				case 2:
					return "End Terrace (House)";
				case 3:
					return "Mid Terrace (House)";
				case 4:
					return "Semi-Detached (House)";
				case 5:
					return "Detached (House)";
				case 6:
					return "Remote Detached (House)";
				case 7:
					return "End Link (House)";
				case 8:
					return "Mid Link (House)";
				case 9:
					return "Flat";
				case 10:
					return "Apartment";
				case 11:
					return "Terraced (Bungalow)";
				case 12:
					return "End Terrace (Bungalow)";
				case 13:
					return "Mid Terrace (Bungalow)";
				case 14:
					return "Semi-Detached (Bungalow)";
				case 15:
					return "Detached (Bungalow)";
				case 16:
					return "Remote Detached (Bungalow)";
				case 17:
					return "End Link (Bungalow)";
				case 18:
					return "Mid Link (Bungalow)";
				case 19:
					return "Terraced (Cottage)";
				case 20:
					return "End Terrace (Cottage)";
				case 21:
					return "Mid Terrace (Cottage)";
				case 22:
					return "Semi-Detached(Cottage)";
				case 23:
					return "Detached (Cottage)";
				case 24:
					return "Remote Detached(Cottage)";
				case 25:
					return "Terraced (Town House)";
				case 26:
					return "End Terrace (Town House)";
				case 27:
					return "Mid Terrace (Town House)";
				case 28:
					return "Semi-Detached (Town House)";
				case 29:
					return "Detached (Town House)";
				case 30:
					return "Detached (Country House)";
				case 31:
					return "North Wing (Country House)";
				case 32:
					return "South Wing (Country House)";
				case 33:
					return "East Wing (Country House)";
				case 34:
					return "West Wing (Country House)";
				case 35:
					return "Terraced (Chalet)";
				case 36:
					return "End Terrace (Chalet)";
				case 37:
					return "Mid Terrace (Chalet)";
				case 38:
					return "Semi-Detached(Chalet)";
				case 39:
					return "Detached (Chalet)";
				case 40:
					return "Detached (Barn Conversion)";
				case 41:
					return "Remote Detached (Barn Conversion)";
				case 42:
					return "Mews Style (Barn Conversion)";
				case 43:
					return "";
				case 44:
					return "";
				case 45:
					return "";
				case 46:
					return "";
				case 47:
					return "";
				case 48:
					return "";
				case 49:
					return "";
				case 50:
					return "";
				case 51:
					return "";
				case 52:
					return "";
				case 53:
					return "";
				case 54:
					return "";
				case 55:
					return "";
				case 56:
					return "";
				case 57:
					return "";
				case 58:
					return "";
				case 59:
					return "";
				case 60: 
					return "Business"; 
				case 61:
					return "Corner Townhouse"; 
				case 62: 
					return "Villa (Detached)";
				case 63: 
					return "Villa (Link-Detached)";
				case 64:
					return "Villa (Semi-Detached)"; 
				case 65:
					return "Village House"; 
				case 66:
					return "Link Detached";
				case 67: 
					return "Studio"; 
				case 68:
					return "Maisonette"; 
				case 69: 
					return "Shell";
				case 70: 
					return "Commercial";
				case 71: 
					return "Retirement Flat";
				case 72: 
					return "Bedsit";
				case 73: 
					return "Park Home/Mobile Home";
			}
		}
	}

?>