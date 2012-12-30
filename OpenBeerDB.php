<?php
/**
 * OpenBeerDB Factory
 */

require_once 'OpenBeerDB/Configuration.php';

abstract class OpenBeerDB {

  /**
   * The factory method to load the right classes.
   */
  public function factory($endPoint) {
    $basepath = realpath(dirname(__FILE__));
    $file = 'OpenBeerDB/' . $endPoint . '.php';

    if (!include_once($basepath . '/' . $file)) {
      throw new Exception('Endpoint file not found: ' . $file);
    }

    $class = 'OpenBeerDB\\' . $endPoint;
    if (!class_exists($class)) {
     throw new Exception('Endpoint class not found: ' . $class);
    }

    $instance = new $class();

    return $instance;
  }
}
