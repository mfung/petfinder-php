<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include_once('pet.class.php');
include_once('config.ini.php');

class PetFinder
{
  // config api
  var $api_url	 			= 'http://api.petfinder.com/';
  var $api_key 				= FALSE;
  var $api_secret 		= FALSE;
  var $api_sig				= FALSE;
  var $api_token			= FALSE;
	var $api_format			= 'json';
	var $api_output			= FALSE; // How much of the pet record to return: id, basic, full
	var $api_offset			= FALSE; // set this to the value of lastOffset returned by a previous call to pet.find, 
															 // and it will retrieve the next result set
	var $api_count			= FALSE; // how many records to return for this particular API call (default is 25)
	var $search_pet			= FALSE;

  // return array of pet objects $pets[] = $pet
  var $pets = Array();

	function __construct() {
		// search pet info
		
		$this->api_key = $GLOBALS['api_key'];
		$this->api_secret = $GLOBALS['api_secret'];

		$this->search_pet = new Pet;
		if ($_COOKIE['pf_token'])
		{
			$this->api_token = $_COOKIE['pf_token'];
		}
		else
		{
			$this->getToken();
		}
	}

  public function setZip($new_zip) {
    $this->zip = $new_zip;
  }

	private function getToken() {
		$jsonRx = $this->curl('auth.getToken?&format=json&key=' . $this->api_key . '&sig='. md5($this->api_secret.'&format=json&key='.$this->api_key));
		$obj = json_decode($jsonRx);

		if ($obj->{'petfinder'}->{'header'}->{'status'}->{'code'}->{'$t'} = '100')
		{
			$this->api_token = (string) $obj->{'petfinder'}->{'auth'}->{'token'}->{'$t'};
			setcookie('pf_token', $this->api_token, strtotime($obj->{'petfinder'}->{'auth'}->{'expiresString'}->{'$t'}));
		}
	}

  private function getSig($data) {
    $this->ap_sig = md5($this->api_secret . $data);
  }

  private function getQueryString() {
    $q_str = 'key=' . $this->api_key;

    if ($this->api_format)
			$q_str .= '&format=' . $this->api_format;

    if ($this->search_pet->id)
      $q_str .= '&id=' . $this->search_pet->id;

		if ($this->search_pet->animal)
			$q_str .= '&animal=' . $this->search_pet->animal;

		if ($this->search_pet->breeds)
			$q_str .= '&breeds=' . $this->search_pet->breeds;
			
		if ($this->search_pet->mix)
			$q_str .= '&mix=' . $this->search_pet->mix;

		if ($this->search_pet->age)
			$q_str .= '&age=' . $this->search_pet->age;

		if ($this->search_pet->name)
			$q_str .= '&name=' . $this->search_pet->name;

		if ($this->search_pet->shelter_id)
			$q_str .= '&shelterid=' . $this->search_pet->shelter_id;

		if ($this->search_pet->size)
			$q_str .= '&size=' . $this->search_pet->size;

		if ($this->search_pet->sex)
			$q_str .= '&sex=' . $this->search_pet->sex;

		if ($this->search_pet->status)
			$q_str .= '&status=' . $this->search_pet->status;

		if ($this->api_offset)
			$q_str .= '&offset=' . $this->api_offset;

		if ($this->api_count)
			$q_str .= '&count=' . $this->api_count;

		if ($this->api_output)
			$q_str .= '&output=' . $this->api_output;

		if ($this->api_token)
			$q_str .= '&token=' . $this->api_token;

		$this->getSig($q_str);

		$q_str .= '&sig=' . $this->api_sig;

		return $q_str;
	}

	function curl($url) {
		$json = '';

		$cr = curl_init();

		curl_setopt($cr, CURLOPT_URL, $this->api_url . $url);
		curl_setopt($cr, CURLOPT_HEADER, 0);

		ob_start();

		curl_exec($cr);

		$json = ob_get_contents();

		ob_clean();

		curl_close($cr);

		return $json;
	}

}
?>

