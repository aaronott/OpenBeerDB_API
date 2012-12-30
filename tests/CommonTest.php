<?php
/**
 * This tests the more common functions across the classes
 *
 */
require_once 'OpenBeerDB.php';

class CommonTest extends PHPUnit_Framework_TestCase {

  protected $Beer;

  public function setUp() {
    OpenBeerDb\Configuration::$public_token = "3ce36e22a8ad337f068c966653148e7b8bfe98c757ac613fa4b1ce904d477d2f";
    $this->Beer = OpenBeerDB::factory('Beer');
  }

  /**
   * @covers Common::set_Page
   * @covers Common::get_Page
   * @covers Common::set_perPage
   * @covers Common::get_perPage
   * @covers Common::set_sortKey
   * @covers Common::get_sortKey
   * @covers Common::set_sortDirection
   * @covers Common::get_sortDirection
   * @covers Common::set_query
   * @covers Common::get_query
   * @covers Common::__set
   * @covers Common::__get
   */
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

  /**
   * @covers Common::set_Page
   * @expectedException Exception
   */
  public function testSettingNegativePageVariableException() {
    $this->Beer->page = -1;
  }

  /**
   * @covers Common::set_Page
   * @expectedException Exception
   */
  public function testSettingStringPageVariableException() {
    $this->Beer->page = 'string';
  }

  /**
   * @covers Common::set_perPage
   * @expectedException Exception
   */
  public function testSettingNegativePerPageVariableException() {
    $this->Beer->perPage = -1;
  }

  /**
   * @covers Common::set_perPage
   * @expectedException Exception
   */
  public function testSettingStringPerPageVariableException() {
    $this->Beer->perPage = 'string';
  }

  /**
   * @covers Common::set_sortKey
   * @expectedException Exception
   */
  public function testSettingInvalidSortKeyVariableException() {
    $this->Beer->sortKey = 'notValid';
  }

  /**
   * @covers Common::set_sortDirection
   * @expectedException Exception
   */
  public function testSettingInvalidSortDirectionVariableException() {
    $this->Beer->sortDirection = 'notValid';
  }

  /**
   * @covers Common::set_query
   * @expectedException Exception
   */
  public function testSettingQueryLengthVariableException() {
    $this->Beer->query = 'b';
  }

  /**
   * @covers Common::set_query
   */
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

}
