<?php
 /**
 * geo_app.php
 */


 /**
  * geo_app
  *
  * This class is the main geo application. Is is a simple class used to seperate the data and other communication layers.
  * This class uses a geo_data_provider type to provide the functionality of finding the gelocation and descriptions of locations
  *
  * * geolocate
  * * describe
  *
  *
  * @author  Imran Bukhsh <imranomar@gmail.com>
  *
  * @since 1.0

  */

class geo_app
{
        /**
        * points to an object that implements the i_geo_data_provider interface. the object
        * is responsible for getting the data for this class 
        * @access private
        * @var string 
        */
	private $geo_data_provider;
        
        /**
        * set_data_provider()
        *
        * this function sets the data_provider for this class. A dataprovider can be any class that implements the  
        * i_geo_data_provider interface and is used to get geodata from any source e.g. geonames.com rest service
        *
        *
        * @author  Imran Omar Bukhsh <imranomar@gmail.com>
        *
        * @since 1.0
        *
        * @param object $data_provider Any object that implements the i_geo_data_provider interface
        */
	public function set_data_provider($data_provider)
	{
		$this->geo_data_provider = $data_provider;
	}

        /**
        * geolocate()
        *
        * this function returns the geonameid based on the latitude and longitude values passes of a location. the 
        * logic of how the information is retrieved lies in the data_provider attached to this class and is not a concern
        * of this class
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
	public function geolocate( $lat,  $lng)
	{
		return $this->geo_data_provider->geolocate($lat,$lng);
	}

        /**
        * describe()
        *
        * this function returns an array of the description of a location based on the geonameid passed. the 
        * logic of how the information is retrieved lies in the data_provider attached to this class and is not a concern
        * of this class
        *
        * @author  Imran Omar Bukhsh <imranomar@gmail.com>
        *
        * @since 1.0
        *
        * @param long $geonameId the geonameid of the location whos description is needed
        * 
        * @return array an array consisting of the toponym,lat,lng of the location
        */
	public function describe( $geonameId)
	{
		return $this->geo_data_provider->describe($geonameId);
	}
}

?>
