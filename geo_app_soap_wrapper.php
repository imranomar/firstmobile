<?php
/**
 * geo_app_soap_wrapper.php
 */

 /**
  * geo_app_soap_wrapper
  *
  * This class wraps the main geo_app class with a soap wrapper, enabling its functions to be available as a soap service
  * This class is not concerned about how the geo_app class get its information which it could be geting from geonames.com 
  * or a local database or another other data_provider. 
  * 
  * * set_geo_app
  * * geolocate
  * * describe
  * * initiate
  *
  * @author  Imran Bukhsh <imranomar@gmail.com>
  *
  * @since 1.0

  */

class geo_app_soap_wrapper
{
        /**
        * points to the geo_app class responsible of getting the information through on its data_provider
        * @access private
        * @var geo_app 
        */
	private $geo_app;
	
        
        /**
        * set_geo_app()
        *
        * this function set the geo_app objects this class is going to wrap
        *
        *
        * @author  Imran Omar Bukhsh <imranomar@gmail.com>
        *
        * @since 1.0
        *
        * @param geo_app $tmp_geo_app The geo_app object this class is going to wrap
        */
	public function set_geo_app($tmp_geo_app)
	{
		$this->geo_app = $tmp_geo_app;
	}

	        /**
        * geolocate()
        *
        * this function returns the geonameid based on the latitude and longitude values passes of a location. this function
        * is not concerned about logic behind how the information is retrieved by the geo_app object
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
		return $this->geo_app->geolocate($lat,$lng);
	}

        /**
        * describe()
        *
        * this function returns an array of the description of a location based on the geonameid passed.  this function
        * is not concerned about logic behind how the information is retrieved by the geo_app object
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
	public function describe( $geonameId)
	{
            return $this->geo_app->describe($geonameId);
	}

        /**
        * initate()
        *
        * start the soap server and passes this class to it. 
        * 
        * @author  Imran Omar Bukhsh <imranomar@gmail.com>
        *
        * @since 1.0
        *
        */
	public function initiate()
	{
		//start server
		$server = new SoapServer(null, array('uri' => "urn://localhost/firstmobile"));
		$server->setObject($this);
		$server->handle();

	}

}
?>
