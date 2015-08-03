<?php
	include 'lib/User.php';
	include 'lib/Slot.php';
	include 'lib/requireLogin.php';

	ob_start();
?>

<form action="order.php" method="post">

	<div>
		<label for="service">service:</label><br />
		<select name="service" id="service">
			<option value="">- select -</option>
			<?php

				$service_type = $_GET['service'];

				$services = Slot::availableServices($service_type);
				foreach ($services as $service)
					echo '<option value="' . $service->id . '">' . $service->name . '</option>'
			?>
		</select>
	</div>

	<?php foreach ($services as $service) { ?>
		<div class="slot" data-service-id="<?php echo $service->id; ?>" style="display: none;">
			<label for="slot"><?php echo $service->name; ?> slot:</label></br />
			<select name="slot" disabled>
				<option value="">- select -</option>
				<?php
					$slots = Slot::available($service_type, $service->id);
					foreach ($slots as $slot)
						echo '<option value="' . $slot->id . '">' . $slot->time . '</option>';
				?>
			</select>
		</div>
	<?php } ?>

	<div><input type="submit" name="submit" value="Place Order" /></div>

</form>

<?php
	$page['title'] = 'Order Form';
	$page['content'] = ob_get_clean();
	include 'templates/layout.php';
?>
