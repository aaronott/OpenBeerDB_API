<?php
/**
 * This is a really simple example allowing you to fetch a beer and get its 
 * details. Currently there is a bug in OpenBeerDB that does not allow you to 
 * get a beer or brewery by it's ID so we keep this simple and query on the 
 * name of the beer.
 */
require_once 'OpenBeerDB.php';

$OBBeer = OpenBeerDB::factory('Beer');
$OBBrewery = OpenBeerDB::factory('Brewery');

$OBBeer->query = 'in';
$result = $OBBeer->get();

echo "Results: (" . $result->total . ")\n";

foreach ($result->beers as $beer) {
  echo "\nName: " . $beer->name . " (" . $beer->abv . "abv)\n";
  echo "\n\t" . $beer->description . "\n";

  $brewery = $OBBrewery->id($beer->brewery->id);
  echo "\nBrought to you by the fine folks at '" . $brewery->name . "'\n";
  echo "Visit them and say thank you at " . $brewery->url . "\n";
}
