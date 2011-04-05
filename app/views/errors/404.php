<img src="assets/Title_404Error.png" width="600" height="50" alt="404Error" /><br /><br />
<?php if(isset($_SESSION['Error_reason'])): ?>
<p style="width:550px;"> <?php echo $_SESSION['Error_reason'];?> <br /><br /></p>
<?php else: /*Show the USer the Default error Screen*/ ?>
<p style="width:550px;"> The page you were trying to visit does not exist. The page may have been moved or linked incorrectly. We're sorry for the inconvenience! <br /><br />If you entered the url yourself, please double check that it was typed correctly. If a link you clicked on this site brought you here, please <a href="contact.php">let us know</a>. </p><br /><br />
<p style="width:550px;">From here you can use the "back" button on your browser to return to where you came from, or use the navigation links at the top of this page to browse the site for what you were looking for.<br /> <br />If you want to visit our homepage,  <a href="index.php">click here</a>.</p>
<?php endif; ?>
