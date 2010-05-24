<?php
echo "<html>";
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include_once('petfinder.class.php');

$pf = new PetFinder;


//$aBreedList = $pf->getBreedList('dog');
//foreach ($aBreedList as &$breed) {
	//echo $breed."<br />";
//}	

//var_dump($pf->getPet(15968436));

echo '<br><br><br>Get Random <br><br>';

$pf ->setOutput('full')
		->setOffset(0)
		->setCount(25);

$searchPet = new Pet;

$searchPet	->setAnimal('dog');
echo "<pre>";
var_dump($pf->getRandomPet($searchPet));
echo "</pre>";
echo "</html>";
?>
