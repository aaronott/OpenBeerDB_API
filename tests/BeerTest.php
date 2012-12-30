<?php
/**
 * Beer is always good to test. Mmm... Beer..
 *
 */
require_once 'OpenBeerDB.php';

class BeerTest extends PHPUnit_Framework_TestCase {

  protected $Beer;

  public function setUp() {
    OpenBeerDb\Configuration::$public_token = "3ce36e22a8ad337f068c966653148e7b8bfe98c757ac613fa4b1ce904d477d2f";
    $this->Beer = OpenBeerDB::factory('Beer');
  }

  public function testListBeers() {
   $beer = $this->Beer->get();

   $this->assertEquals('object', gettype($beer));
   $this->assertTrue(is_a($beer, 'stdClass'));
   $this->assertTrue(isset($beer->page));
   $this->assertTrue(isset($beer->pages));
   $this->assertTrue(isset($beer->total));
   $this->assertTrue(is_array($beer->beers));
   $this->assertEquals(50, sizeof($beer->beers));
  }

  public function testSettingVariables() {
    $this->assertEquals(1, $this->Beer->page);
    $this->Beer->page = 2;
    $this->assertEquals(2, $this->Beer->page);

    $this->assertEquals(50, $this->Beer->perPage);
    $this->Beer->perPage = 25;
    $this->assertEquals(25, $this->Beer->perPage);

    $this->assertEquals('id', $this->Beer->sortKey);
    $this->Beer->sortKey = 'name';
    $this->assertEquals('name', $this->Beer->sortKey);

    $this->assertEquals('ASC', $this->Beer->sortDirection);
    $this->Beer->sortDirection = 'DESC';
    $this->assertEquals('DESC', $this->Beer->sortDirection);

    $this->assertEquals('', $this->Beer->query);
    $this->Beer->query = 'query';
    $this->assertEquals('query', $this->Beer->query);
  }

  public function testQuery() {
    $this->Beer->query = 'Back in Black';
    $this->assertEquals('Back in Black', $this->Beer->query);

    $beer = $this->Beer->get();
    $this->assertEquals(1, sizeof($beer->beers));

    $this->assertEquals(1, $beer->total);
    $this->assertEquals(1, $beer->page);
    $this->assertEquals(1, $beer->pages);

    $this->assertEquals('Back in Black', $beer->beers[0]->name);
    $this->assertEquals(7, $beer->beers[0]->id);
    $this->assertTrue(isset($beer->beers[0]->brewery->id));
    $this->assertEquals(2, $beer->beers[0]->brewery->id);
    $this->assertTrue(isset($beer->beers[0]->brewery->name));
    $this->assertEquals('21st Amendment Brewing', $beer->beers[0]->brewery->name);

  }

  public function testGetByID() {

    OpenBeerDb\Configuration::$public_token = "49141739348b87d4d0939190d394f0fb4b8fbc352f161bc037aa28bc0732b6eb";

    $beer = $this->Beer->id(7);

    print_r($beer);
  }
}