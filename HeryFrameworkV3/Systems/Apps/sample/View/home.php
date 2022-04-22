
<h1>This is home page</h1>
Find this file here: <?= __FILE__ ?>

<hr />

<h4>Login: <?= $name ?></h4>

<form action="<?= Controller::url("HomeController::validateLogin"); ?>" method="POST">
	Username:
	<input type="text" name="username" /><br />
	
	Password:
	<input type="password" name="password" /><br />
	
	<button>
		Login
	</button>
	
	<?= Controller::form() ?>
</form>

