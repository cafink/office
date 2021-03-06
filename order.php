<?php
	include 'lib/classes/Slot.php';
	include 'lib/requireLogin.php';

	if(isset($_POST['submit'])) {

		$purchase = new Purchase($_POST);
		$purchase->user_id = $_SESSION['user']->id;
		$purchase->purchased_at = date('Y-m-d H:i:s');

		if ($purchase->save()) {
			header('Location: thanks.php');
			die();
		}

		$errors = $purchase->errors;
	}

	// Redirect to homepage if no service is specified.
	if (!isset($_GET['service'])) {
		header('Location: index.php');
		die();
	}

	ob_start();

	$service_type = $_GET['service'];
	$service_class = Slot::className($service_type);
?>

<h1><?php echo ucwords($service_type, '-'); ?> Order Form</h1>

<?php include 'templates/errors.php'; ?>

<form action="order.php?service=<?php echo $service_type; ?>" method="post">

	<?php
		if ($service_class::$single) {
			$services = array($service_class::find(null, null, true));
		} else {
	?>
		<div>
			<label for="service">service:</label><br />
			<select name="service" id="service">
				<option value="">- select -</option>
				<?php
					$services = Slot::availableServices($service_type);
					foreach ($services as $service) {
						echo '<option value="' . $service->id . '"';
						if (isset($_POST['service']) && $_POST['service'] == $service->id)
							echo ' selected';
						echo '>' . $service->name . '</option>';
					}
				?>
			</select>
		</div>
	<?php } ?>

	<?php foreach ($services as $service) { ?>
		<div class="slot" data-service-id="<?php echo $service->id; ?>"<?php if (!$service_class::$single && (!isset($_POST['service']) || $service->id != $_POST['service'])) echo ' style="display: none;"'; ?>>
			<label for="slot_id"><?php if (isset($service->name)) echo $service->name . ' '; ?>slot:</label></br />
			<select name="slot_id"<?php if (!$service_class::$single && (!isset($_POST['service']) || $service->id != $_POST['service'])) echo ' disabled'; ?>>
				<option value="">- select -</option>
				<?php
					$slots = Slot::available($service_type, $service->id);
					foreach ($slots as $slot) {
						echo '<option value="' . $slot->id . '"';
						if (isset($_POST['slot_id']) && $_POST['slot_id'] == $slot->id)
							echo ' selected';
						echo '>' . $slot->time . '</option>';
					}
				?>
			</select>
		</div>
	<?php } ?>

	<div><input type="submit" name="submit" value="Place Order" /></div>

</form>

<?php if (!$service_class::$single) { ?>
	<script type="text/javascript">
		$(function() {
			$('#service').change(function() {

				// Hide and disable all slot dropdowns.
				$('.slot').hide();
				$('.slot select').prop('disabled', true);

				// Re-enable and display the one for the selected service.
				$('.slot[data-service-id="' + $(this).val() + '"] select').prop('disabled', false);
				$('.slot[data-service-id="' + $(this).val() + '"]').show();
			});
		});
	</script>
<?php } ?>

<?php
	$page['title'] = 'Order Form';
	$page['content'] = ob_get_clean();
	include 'templates/layout.php';
?>
