<?php
echo "<html>";
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include_once('petfinder.class.php');

$pf = new PetFinder;

// $aBreedList = $pf->getBreedList('dog');

//var_dump($aBreedList);
//foreach ($aBreedList as &$breed) {
	//echo $breed."<br />";
//}	

var_dump($pf->getPet(15968436));

$pf	->setAnimal('dog')
		->setBreeds()
		->setSize('L')
		->setSex('F')
		->setLocation('92376')
		->setShelterId()
		->setOutput(25);

var_dump($pf->getRandomPet());

echo "</html>";
?>
