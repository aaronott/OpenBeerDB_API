<?php
/**
 * Common class for OpenBeerDB API Implementation.
 *
 * This class handles the requests to the server.
 */
namespace OpenBeerDB;

require_once 'OpenBeerDB/Response.php';

abstract class Common {

  public $lastCall = '';
  public $lastResponse = '';
  public $callInfo = '';

  private $parameters = array(
    'sortKey' => 'id',
    'sortDirection' => 'ASC',
    'page' => 1,
    'per_page' => 50,
    'query' => '',
  );

  public function __get($param) {
    $method = 'get_' . $param;
    if (!method_exists($this, $method)) {
      throw new \Exception($param . ' is not a valid parameter.');
    }

    return $this->$method();
  }

  public function __set($param, $value) {
    $method = 'set_' . $param;
    if (!method_exists($this, $method)) {
      throw new \Exception($param . ' is not a valid parameter.');
    }

    $this->$method($value);
  }

  private function get_sortKey() {
    return $this->parameters['sortKey'];
  }

  private function set_sortKey($value) {
    $allowed_values = array('id', 'name', 'created_at', 'updated_at');

    if (!in_array($value, $allowed_values)) {
      throw new \Exception($value . ': is not a valid sortKey. Value should be one of: ' . join(', ', $allowed_values));
    }
    $this->parameters['sortKey'] = $value;
  }

  private function get_sortDirection() {
    return $this->parameters['sortDirection'];
  }

  private function set_sortDirection($value) {
    $allowed_values = array('ASC', 'DESC');

    if (!in_array($value, $allowed_values)) {
      throw new \Exception($value . ': is not a valid sortDirection. Value should be one of: ' . join(', ', $allowed_values));
    }
    $this->parameters['sortDirection'] = $value;
  }

  private function get_page() {
    return $this->parameters['page'];
  }

  private function set_page($value) {
    if (!is_numeric($value) || $value < 1) {
      throw new \Exception('page should be a positive number.');
    }
    $this->parameters['page'] = $value;
  }

  private function get_perPage() {
    return $this->parameters['per_page'];
  }

  private function set_perPage($value) {
    if (!is_numeric($value) || $value < 1) {
      throw new \Exception('perPage should be a positive number.');
    }
    $this->parameters['per_page'] = $value;
  }

  private function get_query() {
    return $this->parameters['query'];
  }

  private function set_query($value) {
    if (strlen($value) < 2) {
      throw new \Exception('query must be at least 2 characters long.');
    }
    $this->parameters['query'] = $value;
  }

  protected function request($endPoint, $method = 'GET') {
    $uri = Configuration::$OpenBeerURI . '/' . $endPoint . '.json';
    $this->parameters['token'] = (strtoupper($method) == 'GET') ? 
      Configuration::$public_token : Configuration::$private_token;

    // because the sort stuff is actually called order, we need to rebuild 
    // that.
    $this->parameters['order'] = $this->parameters['sortKey'] . ' ' . $this->parameters['sortDirection'];

    unset($this->parameters['sortKey']);
    unset($this->parameters['sortDirection']);

    $uri .= '?' . http_build_query($this->parameters);

    $this->lastCall = $uri;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

    if (strtoupper($method) == 'POST') {
      curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    }

    $this->lastResponse = curl_exec($ch);
    $this->callInfo = curl_getinfo($ch);

    //print_r($this->callInfo);
    if ($this->lastResponse === FALSE) {
      throw new \Exception('Curl error: ' . curl_error($ch), curl_errno($ch));
    }

    if ($this->callInfo['http_code'] != 200) {
      throw new \Exception('HTTP Error: ' . $this->callInfo['http_code']);
    }

    curl_close($ch);

    $response = new Response($this->lastResponse);
    return $response->parse();
  }
}
