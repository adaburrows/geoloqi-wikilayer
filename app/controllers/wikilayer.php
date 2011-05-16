<?php
class wikilayer extends controller {

  private $geoloqi;
  private $wikisource;
  private $wiki_hist;
  private $user_tokens;
  private $fb;

  private $radius;

  public function initialize() {
    $this->radius = 1000;

    $this->geoloqi = app::getLib('geoloqi');
    $this->fb = app::getLib('facebook_graph');

    $geoloqi_oauth = array(
      'app_id' => app::$config['geoloqi_client_id'],
      'app_secret' => app::$config['geoloqi_client_secret'],
      'redirect_uri' => site_url(array('wikilayer','oauth'))
    );
    $fb_oauth = array(
      'app_id' => app::$config['fb_client_id'],
      'app_secret' => app::$config['fb_client_secret'],
      'redirect_uri' => site_url(array('wikilayer','facebook'))
    );

    $this->geoloqi->init($geoloqi_oauth);
    $this->fb->init($fb_oauth);
    
    $this->wikisource = app::getModel('wikilayer_datasource');
    $this->wiki_hist = app::getModel('wiki_article_history');
    $this->user_tokens = app::getModel('user_tokens');
  }

/*
 * wikilayer::index()
 * ------------------
 * Randomly, this grbs the articles around (45.511, -122.682)!
 * =============================================================================
 */
  public function index() {
    $lat = 45.511;
    $lng = -122.682;
    $data = $this->wikisource->getWithinRadius($lat, $lng, $this->radius);
    $data = $this->wikisource->filterArticles($data);
    return($data);
  }

/*
 * wikilayer::update()
 * -------------------
 * This function goes through all users grabs their location
 * =============================================================================
 */
  public function update() {
    $data = array();
    $users = $this->user_tokens->all();
    foreach ($users as $user) {
      $this->geoloqi->restore_token($user['token']);
      $this->geoloqi->getLocation();
      $articles = $this->wikisource->getWithinRadius($lat, $lng, $radius);
      $articles = $this->wikisource->filterArticles($articles, $this->wiki_hist->all());
      $this->_add_articles_to_layer($articles);
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

      $this->user_tokens->add($data);
    }

    return($data);
  }

/*
 * wikilayer::_add_articles_to_layer)
 * ----------------------------------
 * adds new articles to the geoloqi layer.
 * =============================================================================
 */
  protected function _add_articles_to_layer($articles) {
    
  }

/*
 * wikilayer::facebook)
 * ----------------------------------
 * Tests my facebook auth mechanism
 * =============================================================================
 */
  public function facebook() {
    $data = array();
    // Redirect user if we don't have a code
    $this->fb->auth_redirect();

    // If we've got the token then go ahead and process it
    if($this->fb->token()) {

      $data = array (
        'token'      => $this->fb->access_token,
        'expiration' => $this->fb->expiration
      );

      //$this->user_tokens->add($data);
      $data = json_decode($this->fb->get('me'), true);
    }

    return($data);
  }

}
