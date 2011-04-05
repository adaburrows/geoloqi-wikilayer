<?php
class posts extends controller {
  private $Blog;
  
  public function initialize() {
    parent::initialize();
    $this->Blog = app::getModel('blog');
  }

  public function index($page = 0) {
    $data = array();
    if (array_key_exists('page', app::$named_params))
      $page = app::$named_params['page'];
    $limit = 10;
    $offset = $page * $limit;

    if (array_key_exists('category', app::$named_params)){
      $cateogry = app::$named_params['category'];
      $data['posts'] = $this->Blog->get_posts_by_category($category, $limit, $offset);
      $cat_info = $this->Blog->get_category_by_name($category);
      $data['title'] = 'Posts in category '. $cat_info['name'];
    } else {
      $data['posts'] = $this->Blog->get_posts($limit, $offset);
      $data['title'] = $this->Blog->get_blog_name();
    }
    return $data;
  }

  public function view($id) {
    $data = $this->Blog->get_post_by_id($id);
    if (!$data) {
      $data = $this->Blog->get_post_by_slug($id);
    }
    if (!$data) {
      throw new Exception("Entry $id not found.");
    }
    return($data);
  }

  public function add() {
    if (isset($_POST['add_post'])) {
      print_r($_POST);
      $success = $this->Blog->set_post($_POST);
      if ($success) {
        $id = mysql_insert_id();
        header('Location: '.site_url(array('posts', 'edit', $id));
        exit(0);
      } else {
        // add code to handle failure adding a post.
      }
    }
    $data = array(
      'categories' => $this->Blog->get_categories()
    );
    return($data);
  }

  public function edit($id) {
    $data = array('flash' => NULL);
    if (isset($_POST['post_id'])) {
      print_r($_POST);
      $_POST['post_id'] = $id;
      $success = $Blog->set_post($_POST);
      if ($success) {
        $data['flash'] = "Blog saved.";
      } else {
        $data['flash'] = "I'm sorry, but that failed.";
      }
    }
    $data = array_merge($data, $this->Blog->get_post_by_id($id));
    $data['categories'] = $this->Blog->get_categories();
    return $data;
  }

  public function delete($id) {
    $this->Blog->delete_post($id);
    header("Location: ".site_url(array('posts', 'index')));
    exit(0);
  }
  
}
