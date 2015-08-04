<?php
	include 'lib/requireLogin.php';
	ob_start();
?>

<p>Hello, <?php echo $_SESSION['user']->first_name; ?></p>

<?php
	$page['content'] = ob_get_clean();
	include 'templates/layout.php';
?>
