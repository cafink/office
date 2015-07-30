<?php if (isset($errors)) { ?>
	<ul class="error">
		<?php

			if (!is_array($errors))
				$errors = array($errors);

			foreach ($errors as $error)
				echo "<li>{$error}</li>";

		?>
	</ul>
<?php } ?>
