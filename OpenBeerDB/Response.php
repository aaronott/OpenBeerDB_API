<?php
/**
 * Implements Response
 */
namespace OpenBeerDB;

class Response {

  private $response;

  public function __construct($response) {
    $this->response = $response;
  }

  public function parse() {
    return json_decode($this->response);
  }
}
