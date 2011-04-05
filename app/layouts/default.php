<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="<?php _e($keywords); ?>" />
  <meta name="description" content="<?php _e($description); ?>" />
  <title><?php _e($title); ?></title>
  <?php _e($css); ?>
  <?php _e($scripts) ?>
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
</head>
<body>
  <div id="header">
    <div class="wrap">
      <a class="logo" href="<?php echo site_url(''); ?>"></a>
      <?php _e($header); ?>
    </div>
  </div>
  <div id="main">
    <div class="wrap">
      <?php _e($content); ?>
    </div>
  </div>
  <div id="footer">
    <div class="wrap">
      <?php _e($footer); ?>
    </div>
  </div>
</body>
</html>
