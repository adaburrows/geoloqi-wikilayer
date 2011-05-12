<?php 

class user_tokens extends db {
  public function __construct() {
    parent::__construct();
    $this->aspects = array(
      'user_tokens' => array(
        'id',
        'token',
        'expiration',
        'refresh'
      )
    );
  }

  public function add($data) {
    $query = $this->build_insert($data, 'user_tokens');
    $result = db::query_ins($query);
    return $result;
  }

  public function get($id) {
    $query = $this->build_select();
    $result = db::query_item($query." WHERE `id` = '$id';");
    return $result;
  }

  public function all() {
    $query = $this->build_select().';';
    return db::query_select($query);
  }

}
