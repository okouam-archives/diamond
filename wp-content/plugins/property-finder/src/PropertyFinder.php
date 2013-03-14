<?php

	class PropertyFinder 
	{
		function fetch($context, $id) {
			$search = new Search($context);
			return $search->fetch($id);
		}

		function search($context, $query, $page, $perpage) {
			$search = new Search($context);
			return $search->execute($query, $page, $perpage);	
		}

		function getQuery($params) {

            if (isset($params['min-price'])) $minPrice = stripslashes($params['min-price']);
            else $minPrice = 'any';

            if (isset($params['min-bed'])) $numBedrooms = stripslashes($params['min-bed']);
            else $numBedrooms = 'any';

            if (isset($params['max-price'])) $maxPrice = stripslashes($params['max-price']);
            else $maxPrice = 'any';

            if (isset($params['postcode'])) $postcode = stripslashes($params['postcode']);
            else $postcode = 'any';

            if (isset($params['prop-type'])) $type = stripslashes($params['prop-type']);
            else $type = 'any';

            if (isset($params['sort'])) $ordering = stripslashes($params['sort']);
            else $ordering = true;

            if (isset($params['buy-rent'])) {
                if ($params['buy-rent'] == "buy") $buyOrRent = SearchType::Sales;
                else {
                    $buyOrRent = SearchType::Lettings;
                    $minPrice = round(($minPrice * 52) / 12);
                    $maxPrice = round(($maxPrice * 52) / 12);
                }
            }
            else {
                $buyOrRent = SearchType::Lettings;
            }

			return new Query($minPrice, $maxPrice, $numBedrooms, $buyOrRent, $postcode, $ordering, $type);
		}

		function hasSearchParameters($params) {
			return isset($params['min_price'], $params['max_price'], $params['bedrooms']);
		}
	}

?>