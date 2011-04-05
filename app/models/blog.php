<?php
class blog extends db {

  public function __construct() {
    parent::__construct();
    $this->aspects = array (
      'posts' => array (
        'post_id',
        'post_slug',
        'title',
        'description',
        'keywords',
        'content',
        'category_id'),
      'categories' => array (
        'cat_id',
        'cat_name',
        'cat_slug',
        'cat_desc')
    );

    $this->join_on = array (
      'posts' => array(
        'categories' => '`categories`.`cat_id` = `posts`.`category_id`'
      )
    );
  }

  public function get_blog_name() {
    return "Blog";
  }

  public function get_categories() {
    $select = $this->build_select('categories').';';
    return db::query_array($select);
  }

  public function get_category_by_id($id) {
    $select = $this->build_select('categories');
    return db::query_item("$select WHERE `cat_id` = $id;");
  }

  public function get_category_by_slug($slug) {
    $select = $this->build_select('categories');
    return db::query_item("$select WHERE `cat_slug` = '$slug';");
  }

  public function get_all() {
    $select = $this->build_select().';';
    return db::query_array($select);
  }

  public function get_posts($limit = '', $offset = '') {
    $select = $this->build_select();
    if ($limit != '')
      $select .= " LIMIT $limit";
    if ($offset != '')
      $select .= " OFFSET $offset";
    $select .= ';';
    $result = db::query_array($select);    
    return $result;
  }

  public function get_posts_by_category($category, $limit = '', $offset = '') {
    $select = $this->build_select();
    $select .= " WHERE `categories`.`cat_slug` = $category";
    if ($limit != '')
      $select .= " LIMIT $limit";
    if ($offset != '')
      $select .= " OFFSET $offset";
    $select .= ';';
    return db::query_array($select);    
  }

  public function get_post_by_id($id) {
    $select = $this->build_select();
    $post = db::query_item("$select WHERE `posts`.`post_id` = $id;");
    return $post;
  }

  public function get_post_by_slug($slug) {
    $select = $this->build_select();
    $post = db::query_item("$select WHERE `posts`.`post_slug` = '$slug';");
    return $post;
  }

  public function set_post($data) {
    if (isset($data['post_id']) && $this->get_post_by_id($data['post_id'])) {
      $query = $this->build_update($data, 'posts');
    } else {
      $query = $this->build_insert($data, 'posts');
    }
    $result = db::query_ins($query);
    return $result;
  }

  public function set_category($data) {
    if (isset($data['cat_id']) && $this->get_category_by_id($data['cat_id'])) {
      $query = $this->build_update($data, 'categories');
    } else {
      $query = $this->build_insert($data, 'categories');
    }
    $result = db::query_ins($query);
    return $result;
  }

  public function delete_post($id) {
    return db::query_ins("DELETE FROM `posts` WHERE `post_id` = $id;");
  }

  public function delete_category($id) {
    return db::query_ins("DELETE FROM `categories` WHERE `cat_id` = $id;");
  }

}
