<style type="text/css">
  #post_edit {
    text-align: left;
    width: 80%;
  }

  #post_edit label {
    text-align: left;
    margin: 0em;
    padding: 0em;
    display: block;
    float: none;
  }

  #post_edit input {
    width: 40em;
    display: block;
    float: none;
  }

  #post_edit #content {
    width: 100%;
    height: 30em;
  }
</style>
<h1>Add Post</h1>
<form id="post_edit" action="<?php echo site_url(array('posts', 'add')); ?>" enctype="multipart/form-data" method="post">
  <input type="hidden" name="add_post" value="1" />
  <label for="title">Title</label>
  <input type="text" id="title" name="title" />
  <label for="post_slug">Slug (used in user friendly URLs)</label>
  <input type="text" id="post_slug" name="post_slug" />
  <label for="description">Description</label>
  <input type="text" id="description" name="description" />
  <label for="keywords">Keywords</label>
  <input type="text" id="keywords" name="keywords" />
  <label for="content">Content</label>
  <textarea id="content" name="content"></textarea>
  <label for="category_id">Category</lable>
  <select name="category_id" multiple="false" />
<?php foreach($categories as $c) : ?>
    <option value="<?php echo $c['cat_id']; ?>"><?php echo $c['cat_name']; ?></option>
<?php endforeach; ?>
  </select> 
  <input type="submit" value="Save" name="save" />
</form>
