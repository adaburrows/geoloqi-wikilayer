<style type="text/css">
  #page_edit {
    text-align: left;
    width: 80%;
  }

  #page_edit label {
    text-align: left;
    margin: 0em;
    padding: 0em;
    display: block;
    float: none;
  }

  #page_edit input {
    width: 40em;
    display: block;
    float: none;
  }

  #page_edit #content {
    width: 100%;
    height: 30em;
  }
</style>
<form id="page_edit" action="<?php echo site_url(array('pages', 'edit', $id)); ?>" enctype="multipart/form-data" method="post">
  <input type="hidden" name="id" value="<?php echo $id; ?>" />
  <label for="title">Title</label>
  <input type="text" id="title" name="title" value="<?php echo $title; ?>" />
  <label for="name">Name (seo-friendly)</label>
  <input type="text" id="name" name="name" value="<?php echo $name; ?>" />
  <label for="description">Description</label>
  <input type="text" id="description" name="description" value="<?php echo $description; ?>" />
  <label for="keywords">Keywords</label>
  <input type="text" id="keywords" name="keywords" value="<?php echo $keywords; ?>" />
  <label for="content">Content</label>
  <textarea id="content" name="content"><?php echo $content; ?></textarea>
  <input type="submit" value="Save" name="save" />
</form>
