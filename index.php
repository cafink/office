<?php

	include 'lib/requireLogin.php';

	include_once 'lib/Slot.php';

	ob_start();

	$service_types = Slot::availableServiceTypes();
?>

<ul>
	<?php foreach ($service_types as $service_type) { ?>
		<li><a href="order.php?service=<?php echo $service_type; ?>"><?php echo ucwords($service_type, '-'); ?> Order Form</a></li>
	<?php } ?>
</ul>

<?php
	$page['content'] = ob_get_clean();
	include 'templates/layout.php';
?>
