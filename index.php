<?php

/*
 *  User changeable data:
 * ================================================================
 *
 * ---------------------------------------------------------------
 *  Paths to the framework files
 * ---------------------------------------------------------------
 */

$dyn = array(
  'sys' => "dynamis",     //dynamis core folder
  'app' => "app",         //user defined files (mostly)
  'web' => "."            //web facing folder (by default, everything is -- and this is not used)
);

/*
 * ================================================================
 *  No user serviceable parts inside:
 *  Just some standard bootloader 
 *
 *  This part of the file is inspired by CakePHP and CodeIgniter
 *  Thanx, guys!
 * ================================================================
 */

/*
 * ---------------------------------------------------------------
 *  Check for paths.
 *  If non-existent, use defaults: app = . ; sys = dynamos
 * ---------------------------------------------------------------
 */

//Check all paths
foreach ($dyn as $key => $path) {
  if (strpos($path, '/') === FALSE) {
    if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE) {
      $dyn[$key] = realpath(dirname(__FILE__)).'/'.$path;
    }
  } else {
    // Swap directory separators to Unix style for consistency
    $dyn[$key] = str_replace("\\", "/", $path);
  }
}
/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */

// Extension for files loaded by the framework:
define('EXT', '.php');
// Path to the system files:
define('BASEPATH', $dyn['sys'].'/');
// Path to the application files:
define('APPPATH', $dyn['app'].'/');
// PAth to the web document root:
define('WEBROOT', $dyn['web'].'/');

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once BASEPATH.'bootstrap'.EXT;
