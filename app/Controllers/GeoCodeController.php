<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;


class GeoCodeController extends BaseController
{

    function __construct(){

        parent::__construct();

    }


	public function getGoogleLatLng()
    {
        $apiKey = 'AIzaSyAAgheCe-_QSYUdCa3q1b8VkxEVM9TfK6Q';
        $httpClient = new \GuzzleHttp\Client();
        $provider = new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient, null, $apiKey);
        $geocoder = new \Geocoder\StatefulGeocoder($provider, 'en');
        
        $result = $geocoder->geocodeQuery(GeocodeQuery::create('Buckingham Palace, London'));

        return $result;

    }





}


