<?php
/**
 * i_geo_data_provider.php
 */


 /**
  * i_geo_data_provider
  *
  * this interface provides the necessary methods that need to be implmented by any data_provider for 
  * the gro_app class and this app. This eases creation of new data_sources instead of only relying on the geonames.com 
  * datasource. Example in the future there can be a class which get the geolocations / descriptions from a local database. 
  * In that case the the class retrieving data for the database would only need to implement this interface to be able to
  * work this this app.
  * 
  * * geolocate
  * * describe
  *
  *
  * @author  Imran Bukhsh <imranomar@gmail.com>
  *
  * @since 1.0

  */
interface i_geo_data_provider
{
                /**
        * geolocate()
        *
        * should return the geonameid based on the latitude and longitude values passes of a location
        *
        *
        * @author  Imran Omar Bukhsh <imranomar@gmail.com>
        *
        * @since 1.0
        *
        * @param double $lat The latitude value of the location being queries about
        * @param double $lng The longitude value of the location being queries about
        *
        * @return long $geonameid The geonameid of the location 
        */
	public function  geolocate( $lat,  $lng);
        
        /**
        * describe()
        *
        * should return an array of the description of a location based on the geonameid passed
        *
        *
        * @author  Imran Omar Bukhsh <imranomar@gmail.com>
        *
        * @since 1.0
        *
        * @param long $geonameId the geonameid of the location whos description is needed
         * 
        * @return array an array consisting of the toponym,lat,lng of the location
        */
	public function describe($geonameId);
}
?>