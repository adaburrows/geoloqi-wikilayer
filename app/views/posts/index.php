<a name="#flash"></a>
<?php echo $flash!=null ? "<div id=\"flash\">$flash</div>" : ''; ?>
<table>
  <caption>Manage Posts</caption>
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Category</th>
      <th>Added</th>
      <th>Modified</th>
      <th colspan="2">Controls</th>
    </tr>
  </thead>
  <tbody>
    <?php $count = 0; ?>
    <?php foreach($posts as $post) :?>
    <tr<?php if (($count%2)==1) {echo ' class="odd"';}?>>
      <th scope="row"><?php echo $post['post_id']; ?></th>
      <td><a href="<?php echo site_url(array('posts', 'view', $post['post_slug'])); ?>"><?php echo $post['title']; ?></a></td>
      <td><?php echo $post['cat_name']; ?></td>
      <td><?php echo $post['created']; ?></td>
      <td><?php echo $post['modified']; ?></td>
      <td>
        <a href="<?php echo site_url(array('posts', 'edit', $post['post_id'])); ?>">Edit</a>
      </td>
      <td>
        <a href="<?php echo site_url(array('posts', 'delete', $post['post_id'])); ?>">Delete</a>
      </td>
    </tr>
    <?php $count++; ?>
    <?php endforeach; ?>
  </tbody>
</table>
