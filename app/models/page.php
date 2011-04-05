<?php
class page extends db {

  public function __construct() {
    parent::__construct();
    $this->aspects = array(
      'pages' => array(
        'id',
        'name',
        'title',
        'description',
        'keywords',
        'content'
      )
    );
  }

  public function get_by_id($id) {
    $select = $this->build_select('pages');
    return db::query_item("$select WHERE `id` = $id;");
  }

  public function get_by_name($name) {
    $select = $this->build_select('pages');
    return db::query_item("$select WHERE `name` = '$name';");
  }

  public function get_all() {
    $select = $this->build_select().';';
    return db::query_array($select);
  }

  public function set($data) {
    if (isset($data['id']) && $this->get_by_id($data['id'])) {
      $query = $this->build_update($data, 'pages');
    } else {
      $query = $this->build_insert($data, 'pages');
    }
    $result = db::query_ins($query);
    return $result;
  }

  function delete($id) {
    return db::query_ins("DELETE FROM `pages` WHERE `id` = $id;");
  }

}
