<?php
class pet {
  var $id							= FALSE;
  var $animal					= FALSE;
  var $breeds					= FALSE;
  var $mix						= FALSE;
  var $age						= FALSE;
  var $name						= FALSE;
	var $shelter_id			= FALSE;
	var $location 			= FALSE;
  var $size						= FALSE;
  var $sex						= FALSE;
  var $description		= FALSE;
  var $last_update		= FALSE;
  var $status					= FALSE;
  var $media					= FALSE;
	var $contact				= FALSE;

	public function setId($new_id = FALSE) {
		$this->id = $new_id;
		return $this;
	}

	public function getId() {
		return $this->id;
	}

	public function setAnimal($new_animal = FALSE) {
		$this->animal = $new_animal;
		return $this;
	}

	public function getAnimal() {
		return $this->animal;
	}

	public function setBreeds($new_breeds = FALSE) {
		$this->breeds = $new_breeds;
		return $this;
	}

	public function getBreeds() {
		return $this->breeds;
	}

	public function setMix($new_mix = FALSE) {
		$this->mix = $new_mix;
		return $this;
	}

	public function getMix() {
		return $this->mix;
	}

	public function setAge($new_age = FALSE) {
		$this->age = $new_age;
		return $this;
	}

	public function getAge() {
		return $this->age;
	}

	public function setName($new_name = FALSE) {
		$this->name = $new_name;
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function setShelterId($new_shelter_id = FALSE) {
		$this->shelter_id = $new_shelter_id;
		return $this;
	}

	public function getShelterId() {
		return $this->shelter_id;
	}

	public function setLocation($new_location = FALSE) {
		$this->location = $new_location;
		return $this;
	}

	public function getLocation() {
		return $this->location;
	}

	public function setSize($new_size = FALSE) {
		$this->size = $new_size;
		return $this;
	}

	public function getSize() {
		return $this->size;
	}

	public function setSex($new_sex = FALSE) {
		$this->sex = $new_sex;
		return $this;
	}

	public function getSex() {
		return $this->sex;
	}

	public function setDescription($new_desc = FALSE) {
		$this->description = $new_desc;
		return $this;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setLastUpdate($new_last_update = FALSE) {
		$this->last_update = $new_last_update;
		return $this;
	}

	public function getLastUpdate() {
		return $this->last_update;
	}

	public function setStatus($new_status = FALSE) {
		$this->status = $new_status;
		return $this;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setMedia($new_media = FALSE) {
		$this->media = $new_media;
		return $this;
	}

	public function getMedia() {
		return $this->media;
	}

	public function setContact($new_contact = FALSE) {
		$this->contact = $new_contact;
		return $this;
	}

	public function getContact() {
		return $this->contact;
	}
}

class Media {
	var $size		= FALSE;
	var $link		= FALSE;
	var $id			= FALSE;

	public function setSize($new_size = FALSE) {
		$this->size = $new_size;
		return $this;
	}
	
	public function getSize() {
		return $this->size;
	}

	public function setLink($new_link = FALSE) {
		$this->link = $new_link;
		return $this;
	}
	
	public function getLink() {
		return $this->link;
	}
	public function setId($new_id = FALSE) {
		$this->id = $new_id;
		return $this;
	}
	
	public function getId() {
		return $this->id;
	}
}

class Shelter {
	var $id 				= FALSE;
	var $name 			= FALSE;
	var $address1		= FALSE;
	var $address2		= FALSE;
	var $city				= FALSE;
	var $state			= FALSE;
	var $zip				= FALSE;
	var $country		= FALSE;
	var $latitude		= FALSE;
	var $longitude	= FALSE;
	var $phone			= FALSE;
	var $fax				= FALSE;
	var $email			= FALSE;

}

?>
