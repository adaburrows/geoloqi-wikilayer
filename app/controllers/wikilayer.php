<?php
class wikilayer extends controller {

  private $geoloqi;
  private $wikisource;
  private $wiki_hist;
  private $user_store;

  private $radius;

  public function initialize() {
    $this->radius = 1000;

    $this->geoloqi = app::getLib('geoloqi');

    $this->geoloqi->init(
      app::$config['geoloqi_client_id'],
      app::$config['geoloqi_client_secret'],
      site_url(array('wikilayer','index'))
    );
    
    $this->wikisource = app::getModel('wikilayer_datasource');
    $this->wiki_hist = app::getModel('wiki_article_history');
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
    $data = $this->wikisource->getWithinRadius($lat, $lng, $this->radius);
    return($data);
  }

/*
 * wikilayer::update()
 * -----------------------------------
 * Randomly, this grbs the articles around (45.511, -122.682)!
 * =============================================================================
 */
  public function update() {
    $data = array();
    $users = $this->user_store->getUsers();
    foreach ($users as $user) {
      
      $data = $this->wikisource->getWithinRadius($lat, $lng, $radius);
    }
    return($data);
  }

/*
 * wikilayer::oauth()
 * ------------------
 * after signup this is where we get the token
 * =============================================================================
 */
  public function oauth() {
    $data = array();
    // Redirect user if we don't have a code
    $this->geoloqi->auth_redirect();

    // If we've got the token then go ahead and process it
    if($this->geoloqi->token()) {

      $data = array (
        'token'      => $this->geoloqi->access_token,
        'expiration' => $this->geoloqi->expiration,
        'refresh'    => $this->geoloqi->refresh_token
      );

      $this->user_store->add($data);
    }

    return($data);
  }

}
