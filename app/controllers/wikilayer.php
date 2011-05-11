<?php
class wikilayer extends controller {

  private $geoloqi;
  private $wikisource;
  private $wiki_hist;
  private $user_tokens;

  private $radius;

  public function initialize() {
    $this->radius = 1000;

    $this->geoloqi = app::getLib('geoloqi');

    $this->geoloqi->init(array(
      'app_id' => app::$config['geoloqi_client_id'],
      'app_secret' => app::$config['geoloqi_client_secret'],
      'redirect_uri' => site_url(array('wikilayer','index'))
    ));
    
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

      $this->user_store->add($data);
    }

    return($data);
  }

/*
 * wikilayer::_add_articles_to_layer)
 * ----------------------------------
 * adds new articles to the geoloqi layer.
 * =============================================================================
 */
  public function _add_articles_to_layer($articles) {
    
  }

}
