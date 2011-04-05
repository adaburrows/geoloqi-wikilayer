<?php
class pages extends controller {
  private $Page;
  
  public function initialize() {
    parent::initialize();
    $this->Page = app::getModel('page');
  }

  public function view($id) {
    $data = $this->Page->get_by_id($id);
    if (!$data) {
      $data = $this->Page->get_by_name($id);
    }
    if (!$data) {
      throw new Exception("Page $id not found.");
    }
    return($data);
  }

  public function add() {
    $data = array();
    if (isset($_POST['add_page'])) {
      $success = $this->Page->set($_POST);
      if ($success) {
        $id = mysql_insert_id();
        header("Location: /page/edit/$id");
        exit(0);
      } else {
        // add code to handle failure adding a page.
      }
    }
    return $data;
  }

  public function edit($id) {
    $data = array('flash' => NULL);
    if (isset($_POST['id']) && ($id == $_POST['id'])) {
      $_POST['id'] = $id;
      $success = $this->Page->set($_POST);
      if ($success) {
        $data['flash'] = "Page saved.";
      } else {
        $data['flash'] = "I'm sorry, but that failed.";
      }
    }
    $data = array_merge($data, $this->Page->get_by_id($id));
    return $data;
  }

  public function delete($id) {
    $this->Page->delete($id);
    header("Location: ".site_url(array('pages', 'index')));
    exit(0);
  }

  public function index() {
    $data['pages'] = $this->Page->get_all();
    $data['title'] = "Pages in uLynk";
    return $data;
  }
  
}
