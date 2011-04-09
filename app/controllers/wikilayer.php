<?php
class wikilayer extends controller {

  private $wikisource;

  public function initialize() {
    $this->wikisource = app::getModel('wikilayer_datasource');
  }

/*
 * wikilayer::index()
 * -----------------------------------
 * Randomly, this grbs the articles around (45.511, -122.682)!
 * =============================================================================
 */
  public function index() {
    $lat = 45.511;
    $lng = -122.682;
    $radius = 400;
    $data = $this->wikisource->getWithinRadius($lat, $lng, $radius);
    return($data);
  }

}
