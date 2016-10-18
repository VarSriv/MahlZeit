<?php
	session_start();
	session_unset();
	session_destroy();
	header('Location: /');
	echo '<html><a href="/">Click here if you are not redirected</a></html>';
?>