<?php
	include 'lib/requireLogin.php';

	include_once 'lib/classes/Purchase.php';

	ob_start();
?>

<h1>Reports</h1>

<p><strong><?php echo count(Purchase::purchasesThisMonth()); ?></strong> packages have been sold this month.</p>

<p><strong><?php echo count(User::withNoPurchases()); ?></strong> users in the system haven't purchased a package yet.</p>

<?php
	$page['title'] = 'Reports';
	$page['content'] = ob_get_clean();
	include 'templates/layout.php';
?>
