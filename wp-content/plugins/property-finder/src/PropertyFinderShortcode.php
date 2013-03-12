<?php

	class PropertyFinderShortcode
	{
		static function register() 
		{			
			wp_register_script('property_finder_jquery', "http://code.jquery.com/jquery-1.8.3.min.js");
			wp_enqueue_script('property_finder_jquery');

			wp_register_script('property_finder_google_maps', "http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false");
			wp_enqueue_script('property_finder_google_maps');

			wp_register_script('property_finder_bbq', "http://github.com/cowboy/jquery-bbq/raw/v1.2.1/jquery.ba-bbq.min.js");
			wp_enqueue_script('property_finder_bbq');

			wp_register_script('property_finder_simple_pagination', plugins_url('/assets/js/jquery.simplePagination.js', dirname(__FILE__)));
			wp_enqueue_script('property_finder_simple_pagination');

			$name = 'property_finder_pagination';
			$url = plugins_url('/assets/css/simplePagination.css', dirname(__FILE__));
			wp_register_style($name, $url, array(), '20120208', 'all');  
			wp_enqueue_style('property_finder_pagination');
		}

		static function render($atts)
		{
			$context = PropertyFinderShortcode::getContext($atts);

			$output = "";

			if (PropertyFinderShortcode::isPropertyDisplay($_GET)) 
			{
				$output = PropertyFinderShortcode::displayProperty($context, $_GET['pf_id']);	
			}				
			else
			{
				$page = PropertyFinderShortcode::getPageNumber($_GET);
				$perPage = PropertyFinderShortcode::getPageSize($_GET);
				$output = PropertyFinderShortcode::searchProperties($context, $page, $perPage);
			}

			return $output;
		}

		static function searchProperties($context, $page, $perPage) {
			$finder = new PropertyFinder();
			$query = $finder->getQuery($_GET);
			$result = $finder->search($context, $query, $page, $perPage);	
			return $finder->render($result, dirname(__FILE__) .'/../templates/results.php');
		}

		static function getPageNumber($params) {
			return isset($params['pf_page']) ? $params['pf_page'] : 1; 
		}

		static function getPageSize($params) {
			return isset($params['pf_perpage']) ? $params['pf_perpage'] : 5; 		
		}

		static function isPropertyDisplay($params) {
			return isset($params['pf_id']);
		}

		static function displayProperty($context, $id) {
			$finder = new PropertyFinder();
			$property = $finder->fetch($context, $id);
			return $finder->render($property, dirname(__FILE__) .'/../templates/property.php');
		}
			
		static function getContext($atts) {
			extract(shortcode_atts(array('eaid' => 1322, 'bid' => 2104, 'apikey' => "E1D57034-6C07-44C4-A458-425CAE9D9247"), $atts));
 			return new Context(null, $apikey, $eaid, uniqid(), -1, $bid);
		}
	}
?>