<?php
 /**
 * geo_app_soap_wrapper.php
 */

include_once('i_geo_data_provider.php');

 /**
  * geonames_data_provider
  *
  * This class implements the i_geo_data_provider interface and provides
  * methods to call the rest based funcationality provided by geonames.com
  *
  * * geolocate
  * * describe
  *
  *
  * @author  Imran Bukhsh <imranomar@gmail.com>
  *
  * @since 1.0

  */

class geonames_data_provider implements i_geo_data_provider
{
        /**
        *used to store the username to the rest api at geonames.com
        * @access private
        * @var string 
        */
	private $user_name;
        
        /**
        * geonames_data_provider()
        *
        * the constructor accepts the username needed for the rest based geonames.com service
        *
        *
        * @author  Imran Omar Bukhsh <imranomar@gmail.com>
        *
        * @since 1.0
        *
        * @param string $tmp_user_name  the username used to access the rest based service at geonames.com
        */
	function geonames_data_provider($tmp_user_name)
	{
		$this->user_name = $tmp_user_name;
	}
        
        /**
        * geolocate()
        *
        * this function returns the geonameid based on the latitude and longitude values passes of a location
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
	public function geolocate( $lat,  $lng)
	{
            settype($lat,"float");
            settype($lng,"float");
            
            //other variable cleaning can be done here
            
            try
            {
                $get_url = 'http://api.geonames.org/findNearby?lat='.$lat.'&lng='.$lng.'&username='.$this->user_name;
                $str_xml =  file_get_contents($get_url);
		              
                if($this->isXML($str_xml)==1) //check if xml is valid
                {
                    $s_xml = new SimpleXMLElement($str_xml);
                    if(isset($s_xml->geoname[0]->geonameId) && $s_xml->geoname[0]->geonameId!='') // check for empty geonameid
                    {
                        return new SoapVar($s_xml->geoname[0]->geonameId,XSD_DECIMAL,null,null,'');
                    }
                    else
                    {
                        throw new Exception('Geonameid could not be found');
                    }
                }
                else
                {
                    throw new Exception($this->isXML($str_xml)); //throw with the msg returned from function
                }
		
            }
            catch(Exception $e)
            {
                //logging or email notification to admin can happen here
                //can be changed to show client friendly messages
                return "An error occured: ".$e->getMessage();
            }
		
	}
        
        

        /**
        * describe()
        *
        * this function returns an array of the description of a location based on the geonameid passed
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
	public function describe($geonameId)
	{
            settype($lat,"integer");
            
            try
            {
		$str_xml =  file_get_contents('http://ws.geonames.org/get?geonameId='.$geonameId.'&style=full');
		//return $str_xml;
		$s_xml = new SimpleXMLElement($str_xml);
	
                if($this->isXML($str_xml)==1) //check if xml is valid
                {
                    if(isset($s_xml->toponymName) && $s_xml->toponymName!='')
                    {
                        $geo_array=array();
                        $geo_array[]=new SoapVar($s_xml->toponymName,XSD_STRING,null,null,'geo_array');
                        $geo_array[]=new SoapVar($s_xml->lat,XSD_STRING,null,null,'geo_array');
                        $geo_array[]=new SoapVar($s_xml->lng,XSD_STRING,null,null,'geo_array');
                        return $geo_array;
                    }
                    else
                    {
                        throw new Exception("Toponym could not be found");
                    }
                }
                else
                {
                    throw new Exception($this->isXML($str_xml)); //throw with the msg returned from function
                }
            }
            catch(Exception $e)
            {
                //logging or email notification to admin can happen here
                //can be changed to show client friendly messages
                return "An error occured: ".$e->getMessage();     
            }
	}
        
        /**
        * isXML()
        *
        * this function accepts a string of xml and checks if its properly formated. Returns 1 if alright or an
        * error message string with line number if if its not 
        * Note: this function can be moved out into a helder class
        *
        * @author  Imran Omar Bukhsh <imranomar@gmail.com>
        *
        * @since 1.0
        *
        * @param string $xml the xml to be checked, passed as a string
        * 
        * @return boolean 1 if the xml is alright 
        * @return string a string error message if its not
        */
        function isXML($xml)
        {
            libxml_use_internal_errors(true);

            $doc = new DOMDocument('1.0', 'utf-8');
            $doc->loadXML($xml);

            $errors = libxml_get_errors();

            if(empty($errors)){
                return true;
            }

            $error = $errors[0];
            if($error->level < 3){
                return true;
            }

            $explodedxml = explode("r", $xml);
            $badxml = $explodedxml[($error->line)-1];

            $message = $error->message . ' at line ' . $error->line . '. Bad XML: ' . htmlentities($badxml);
            return $message;
        }

}


?>
