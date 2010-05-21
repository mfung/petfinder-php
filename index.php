<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include_once('petfinder.class.php');

$pf = new PetFinder;

echo 'Hello World: ' . $pf->api_token;
?>
