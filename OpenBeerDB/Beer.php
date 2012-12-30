<?php
/**
 * Beer class.
 */

namespace OpenBeerDB;

require_once 'OpenBeerDB/Common.php';

class Beer extends Common {

  public function get() {
    return $this->request('beers');
  }

  public function id($id) {
    if (!is_numeric($id) || $id <= 0) {
      throw new \Exception("Beer ID must be a positive number.");
    }

    return $this->request('beers/' . $id);
  }
}
