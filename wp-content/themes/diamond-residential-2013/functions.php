<?php

    load_theme_textdomain( 'html5reset', TEMPLATEPATH . '/languages' );
 
    $locale = get_locale();
    $locale_file = TEMPLATEPATH . "/languages/$locale.php";

    if (is_readable($locale_file))
        require_once($locale_file);

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }

    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => __('Sidebar Widgets','html5reset' ),
    		'id'   => 'sidebar-widgets',
    		'description'   => __( 'These are widgets for the sidebar.','html5reset' ),
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
    }
    
    add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'audio', 'chat', 'video')); // Add 3.1 post format theme support.

    function getLatestBuyProperties() {
        $context = new Context(null, "E1D57034-6C07-44C4-A458-425CAE9D9247", 1322, uniqid(), -1, 2104);
        $finder = new PropertyFinder();
        $query = new Query(new PriceRange(0, 1000000000), 0, SearchType::Sales, null, true);
        $results = $finder->search($context, $query, 1, 2);
        return $results->properties;
    }

    function getLatestRentProperties() {
        $context = new Context(null, "E1D57034-6C07-44C4-A458-425CAE9D9247", 1322, uniqid(), -1, 2104);
        $finder = new PropertyFinder();
        $query = new Query(new PriceRange(0, 1000000000), 0, SearchType::Lettings, null, true);
        $results = $finder->search($context, $query, 1, 2);
        return $results->properties;
    }

    function getPageNumber($params) {
        return isset($params['pos']) ? $params['pos'] : 1;
    }

    function search() {
        $context = new Context(null, "E1D57034-6C07-44C4-A458-425CAE9D9247", 1322, uniqid(), -1, 2104);
        $page = getPageNumber($_GET);
        $finder = new PropertyFinder();
        $query = $finder->getQuery($_GET);
        return $finder->search($context, $query, $page, 5);
    }

    function write_options($options, $name) {
        foreach($options as $key => $value) {
            write_option($name, $key, $value);
        }
    }

    function write_option($prop, $key, $value) {
        $selected = isset($_GET[$prop]) && $_GET[$prop] == $key ? "selected" : "";
        echo "<option {$selected} value='{$key}'>{$value}</option>";
    }

    function getProperty($id) {
        $context = new Context(null, "E1D57034-6C07-44C4-A458-425CAE9D9247", 1322, uniqid(), -1, 2104);
        $finder = new PropertyFinder();
        return $finder->fetch($context, $id);
    }

    function format_bedrooms($num_bedrooms) {
        if ($num_bedrooms == 0) return "Studio";
        else if ($num_bedrooms == 1) return "1 Bedroom";
        else return "$num_bedrooms Bedrooms";
    }

    function find_surrounding_schools($property, &$schools) {
        $fusionTablequery = new FusionTableQuery("AIzaSyBgYhtGiRjsDIb_jaQjM3ZQHHVWCK9uNDI");
        $stmt = "SELECT latitude, longitude, EstablishmentName ";
        $stmt .= "FROM 1nzc6Ismj8WlHLlgo5zNUgf4EV-4A5qzqu4kS2G4 ";
        $stmt .= "ORDER BY ST_DISTANCE(latitude,LATLNG({$property->latitude},{$property->longitude})) LIMIT 20";
        $data = $fusionTablequery->query($stmt);
        foreach($data->rows as $row) {
            array_push($schools, new School($row[2], $row[0], $row[1]));
        }
    }
?>