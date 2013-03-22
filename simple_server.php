<?php
/**
 * simple_erver.php
 */
error_reporting(E_ALL);

include_once "config.php";
include_once "geo_app.php";
include_once "geo_app_soap_wrapper.php";
include_once "geonames_data_provider.php";


//create instance of my_geo app
$geo_app = new geo_app();

//assign a data provider to my_geo app: in this case it will be geonames's rest based data provider
$geonames_dp = new geonames_data_provider($config['geonames_username']);
$geo_app->set_data_provider($geonames_dp);

//create the soap wrapper for my_geo app
$soap_wrapper = new geo_app_soap_wrapper();

//wrap my_geo with the 'soap-wrapper'
$soap_wrapper->set_geo_app($geo_app);
$soap_wrapper->initiate();



?>
