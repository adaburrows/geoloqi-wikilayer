<?php 

class wiki_article_history extends db {
  public function __construct() {
    parent::__construct();
    $this->aspects = array(
      'wiki_articles' => array(
        'article_id'
      )
    );
  }

  public function add($id) {
    $query = $this->build_insert(array('article_id'), 'wiki_articles').';';
    $result = db::query_ins($query);
    return $result;
  }

  public function all() {
    $query = $this->build_select().';';
    $result = db::query_item();
    return $result;
  }

}
