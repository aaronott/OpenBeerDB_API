<?php
/**
 * Brewery class.
 */

namespace OpenBeerDB;

require_once 'OpenBeerDB/Common.php';

class Brewery extends Common {

  public function get() {
    return $this->request('breweries');
  }

  public function id($id) {
    if (!is_numeric($id) || $id <= 0) {
      throw new \Exception("Brewery ID must be a positive number.");
    }

    return $this->request('breweries/' . $id);
  }
}
