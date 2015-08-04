<?php
	include 'lib/requireLogin.php';

	ob_start();
?>

<p>Thank you, your order has been placed.</p>

<?php
	$page['title'] = 'Thank You';
	$page['content'] = ob_get_clean();
	include 'templates/layout.php';
?>
