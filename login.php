<?php
	include 'lib/classes/User.php';

	if(isset($_POST['submit'])) {

		$user = User::find('email', $_POST['email'], true);

		if (isset($user)) {

			$success = $user->checkPassword($_POST['password']);

			if ($success) {
				session_start();
				$_SESSION['user'] = $user;
				header('Location: index.php');
				die();
			}
		}

		$errors = 'Invalid username/password combination.';
	}

	ob_start();
?>

<h1>Log In</h1>

<?php include 'templates/errors.php'; ?>

<form action="login.php" method="post">

	<div>
		<label for="email">e-mail address:</label><br />
		<input type="text" name="email"<?php if (isset($_POST['email'])) echo " value=\"{$_POST['email']}\""; ?> />
	</div>

	<div>
		<label for="password">password:</label><br />
		<input type="password" name="password" />
	</div>

	<div><input type="submit" name="submit" value="Login" /></div>

</form>

<?php
	$page['content'] = ob_get_clean();
	include 'templates/layout.php';
?>
