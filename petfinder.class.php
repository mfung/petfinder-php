<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include_once('pet.class.php');
include_once('config.ini.php');

class PetFinder
{
  // config api
	var $api_url				= 'http://api.petfinder.com/';
	var $api_key				= FALSE;
	var $api_secret			= FALSE;
	var $api_sig				= FALSE;
	var $api_token			= FALSE;
	var $api_format			= 'json';
	var $api_output			= FALSE; // How much of the pet record to return: id, basic, full
	var $api_offset			= FALSE; // set this to the value of lastOffset returned by a previous call to pet.find, 
															 // and it will retrieve the next result set
	var $api_count			= FALSE; // how many records to return for this particular API call (default is 25)

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

	public function getBreedList($new_animal) {
		$mySearchPet = new Pet;
		$mySearchPet->setAnimal($new_animal);
		$jsonRx = $this->curl('breed.list?' . $this->getQueryString($mySearchPet));
		$obj = json_decode($jsonRx);
		$aBreedList = $obj->petfinder->breeds->breed;

		return $this->getArrBreedList($aBreedList);
	}

	public function getPet($new_pet_id) {
		$mySearchPet = new Pet;
		$mySearchPet->setId($new_pet_id);
		$myPet = new Pet;
		$myPet = $this->get('find_by_id', $mySearchPet);
		return $myPet;

	}

	public function getRandomPet($mySearchPet) {
		$myPet = new Pet;
		$myPet = $this->get('random', $mySearchPet);
		return $myPet;
	}

	public function findPet($mySearchPet) {
		$myPet = new Pet;
		$myPet = $this->get('find', $mySearchPet);
		return $myPet;
	}

	public function findShelter($myShelter) {
		
	}

	public function setOutput($new_output) {
		$this->api_output = $new_output;
		return $this;
	}
	public function getOutput() {
		return $this->api_output;
	}
	
	public function setOffset($new_offset) {
		$this->api_offset = $new_offset;
		return $this;
	}
	
	public function getOffset() {
		return $this->api_offset;
	}

	public function setCount($new_count) {
		$this->api_count = $new_count;
		return $this;
	}

	public function getCount() {
		return $this->api_count;
	}

	private function getArrBreedList($data) {
		$aNewBL = Array();
		foreach ($data as &$breed) {
				$aNewBL[] = $breed->{'$t'};			
		}
		return $aNewBL;
	}

	private function getArrMedia($data) {
		$arr = Array();

		foreach ($data as &$photo) {
			$myM = new Media;
			$myM->setSize($photo->{'@size'})
					->setLink($photo->{'$t'})
					->setId($photo->{'@id'});

			$arr[] = $myM;
		}

		return $arr;
	}
	private function get($method, $mySearchPet) {

		$myMeth = FALSE;
		$singlePet = TRUE;

		switch ($method) {
		case 'random':
			$myMeth = 'pet.getRandom?';
			break;
		case 'find_by_id':
			$myMeth = 'pet.Get?';
			break;
		case 'find':
			$singlePet = FALSE;
			$myMeth = 'pet.find?';
			break;
		default:
			$myMeth = 'pet.getRandom?';
			break;
		}

		$jsonRx = $this->curl($myMeth . $this->getQueryString($mySearchPet));
		$obj = json_decode($jsonRx);

		echo '<br><br>Query: ' . $this->getQueryString($mySearchPet) . '<br><br>';

		$myPets = Array();

		if (!$singlePet)
		{
			echo 'Hello World';
			var_dump($obj);
		}
		elseif ($singlePet)
		{	
			$myPet = new Pet;
			$myPet = $this->decodePet($obj);
			return $myPet;
		}
	}

	private function decodePet($obj) {
		$myPet = new Pet;
		$myPet->setId($obj->petfinder->pet->id->{'$t'})
					->setAnimal($obj->petfinder->pet->animal->{'$t'})
					->setBreeds($this->getArrBreedList($obj->petfinder->pet->breeds->breed))
					->setMix($obj->petfinder->pet->mix->{'$t'})
					->setAge($obj->petfinder->pet->age->{'$t'})
					->setName($obj->petfinder->pet->name->{'$t'})
					->setShelterId($obj->petfinder->pet->shelterId->{'$t'})
					->setSize($obj->petfinder->pet->size->{'$t'})
					->setSex($obj->petfinder->pet->sex->{'$t'})
					->setDescription($obj->petfinder->pet->description->{'$t'})
					->setLastUpdate($obj->petfinder->pet->lastUpdate->{'$t'})
					->setStatus($obj->petfinder->pet->status->{'$t'})
					->setMedia($this->getArrMedia($obj->petfinder->pet->media->photos->photo));
		return $myPet;
	}

	private function getToken() {
		$jsonRx = $this->curl('auth.getToken?&format=json&key=' . $this->api_key . '&sig='. md5($this->api_secret.'&format=json&key='.$this->api_key));
		$obj = json_decode($jsonRx);

		if ($obj->petfinder->header->status->code = '100')
		{
			$this->api_token = $obj->petfinder->auth->token->{'$t'};
			setcookie('pf_token', $this->api_token, strtotime($obj->petfinder->auth->expiresString->{'$t'}));
		}
	}

  private function getSig($data) {
    $this->api_sig = md5($this->api_secret . $data);
  }

  private function getQueryString($myPet = FALSE) {
    $q_str = 'key=' . $this->api_key;

    if ($this->api_format)
			$q_str .= '&format=' . $this->api_format;

    if ($myPet->id)
      $q_str .= '&id=' . $myPet->id;

		if ($myPet->animal)
			$q_str .= '&animal=' . $myPet->animal;

		if ($myPet->breeds)
			$q_str .= '&breed=' . $myPet->breeds;
			
		if ($myPet->mix)
			$q_str .= '&mix=' . $myPet->mix;

		if ($myPet->age)
			$q_str .= '&age=' . $myPet->age;

		if ($myPet->name)
			$q_str .= '&name=' . $myPet->name;

		if ($myPet->location)
			$q_str .= '&location=' . $myPet->location;

		if ($myPet->shelter_id)
			$q_str .= '&shelterid=' . $myPet->shelter_id;

		if ($myPet->size)
			$q_str .= '&size=' . $myPet->size;

		if ($myPet->sex)
			$q_str .= '&sex=' . $myPet->sex;

		if ($myPet->status)
			$q_str .= '&status=' . $myPet->status;

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

