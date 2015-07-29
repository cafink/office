<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php if(isset($page['title'])) echo $page['title'] . ' - '; ?>Office Scheduler</title>
	</head>
	<body>
		<div id="content"><?php echo $page['content']; ?></div>
	</body>
</html>
