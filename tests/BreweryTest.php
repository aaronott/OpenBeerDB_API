<?php
/**
 *
 */
require_once 'OpenBeerDB.php';

class BreweryTest extends PHPUnit_Framework_TestCase {

  protected $Brewery;

  public function setUp() {
    OpenBeerDb\Configuration::$public_token = "3ce36e22a8ad337f068c966653148e7b8bfe98c757ac613fa4b1ce904d477d2f";
    $this->Brewery = OpenBeerDB::factory('Brewery');
  }

  /**
   * @covers Brewery::get
   */
  public function testListbreweries() {
   $brewery = $this->Brewery->get();

   $this->assertEquals('object', gettype($brewery));
   $this->assertTrue(is_a($brewery, 'stdClass'));
   $this->assertTrue(isset($brewery->page));
   $this->assertTrue(isset($brewery->pages));
   $this->assertTrue(isset($brewery->total));
   $this->assertTrue(is_array($brewery->breweries));
  }

  /**
   * @covers Common::set_query
   */
  public function testQuery() {
    $this->Brewery->query = '21st Amendment Brewing';
    $this->assertEquals('21st Amendment Brewing', $this->Brewery->query);

    $brewery = $this->Brewery->get();
    $this->assertEquals(1, sizeof($brewery->breweries));

    $this->assertEquals(1, $brewery->total);
    $this->assertEquals(1, $brewery->page);
    $this->assertEquals(1, $brewery->pages);

    $this->assertEquals('21st Amendment Brewing', $brewery->breweries[0]->name);
    $this->assertEquals(2, $brewery->breweries[0]->id);
  }

  /**
   * This is a bug in the API itself. You currently cannot get beer or brewery
   * by id.
   */
  public function testGetByID() {
    OpenBeerDB\Configuration::$public_token = "";
    $brewery = $this->Brewery->id(2);

    $this->assertEquals(2, $brewery->id);
    $this->assertEquals('21st Amendment Brewing', $brewery->name);
  }
}
