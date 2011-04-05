<div id="post">
<a name="#flash"></a>
<?php if ($flash!=null): ?>
<div id="flash"><?php echo $flash; ?></div>
<?php endif; ?>
<h2 id="post_title"><?php echo $title; ?></h2>
<div id="post_meta">
<span class="category"><?php echo $cat_name; ?></span>
<span class="date"><?php echo $created; ?>
</div>
<div id="post_content"><?php echo $content; ?></div>
</div>
