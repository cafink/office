<?php ob_start(); ?>

<p>Hello, world!</p>

<?php
	$page['content'] = ob_get_clean();
	include 'layout.php';
?>
