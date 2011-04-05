<a name="#flash"></a>
<?php echo $flash!=null ? "<div id=\"flash\">$flash</div>" : ''; ?>
<table>
  <caption>Manage Pages</caption>
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Added</th>
      <th>Modified</th>
      <th colspan="2">Controls</th>
    </tr>
  </thead>
  <tbody>
    <?php $count = 0; ?>
    <?php foreach($pages as $page) :?>
    <tr<?php if (($count%2)==1) {echo ' class="odd"';}?>>
      <th scope="row"><?php echo $page['id']; ?></th>
      <td><a href="<?php echo site_url(array('pages', 'view', $page['name'])); ?>"><?php echo $page['title']; ?></a></td>
      <td><?php echo $page['created']; ?></td>
      <td><?php echo $page['modified']; ?></td>
      <td>
        <a href="<?php echo site_url(array('pages', 'edit', $page['id'])); ?>">Edit</a>
      </td>
      <td>
        <a href="<?php echo site_url(array('pages', 'delete', $page['id'])); ?>">Delete</a>
      </td>
    </tr>
    <?php $count++; ?>
    <?php endforeach; ?>
  </tbody>
</table>
