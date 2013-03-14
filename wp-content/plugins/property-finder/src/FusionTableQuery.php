<?php

class School {
    public $latitude;
    public $longitude;
    public $name;

    public function __construct($name, $latitude, $longitude) {
        $this->name = $name;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }
}

class FusionTableQuery {

    protected $query_url = 'https://www.googleapis.com/fusiontables/v1/query';
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->query_url .= "?key=$apiKey";
    }

    public function query($query)
    {
        if(strlen($query) < 1 )
            throw new Exception('Query must be a valid query string!');

        $curl = curl_init($this->query_url .'&sql='. urlencode($query));

        curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER  => true));

        $results = json_decode(curl_exec($curl));

        if( curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200 )
            throw new Exception($results);

        return $results;
    }
}