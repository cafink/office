<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php if(isset($page['title'])) echo $page['title'] . ' - '; ?>Office Scheduler</title>
	</head>
	<body>
		<div id="header">
			<?php

				// strpos() "may return Boolean FALSE, but may also
				// return a non-Boolean value which evaluates to FALSE."
				if (strpos($_SERVER['SCRIPT_NAME'], 'login.php') === false) {

					if (isset($_SESSION['user'])) {
						echo 'logged in as: <strong>' .
							$_SESSION['user']->first_name . ' ' .
							$_SESSION['user']->last_name .
							'</strong> (<a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/logout.php">log out</a>)';
					} else {
						echo '<a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/login.php">log in</a>';
					}

				}
			?>
		</div>
		<div id="content"><?php echo $page['content']; ?></div>
	</body>
</html>
