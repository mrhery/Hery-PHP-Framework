<h1>This is home page</h1>
Find this file here: <?= __FILE__ ?>

<hr />

<h4>Form Controller</h4>
<?php
/*

## HPFv4 Form Control
To make a request froma form to specific `Controller` you can do like this:

1. Put this code in `action=''` form attribute:
```
Controller::url("TestController::index()"); // This method will generate an encrypted string to make it unreadable by human being even thanos can't read it.
```

2. Put this code before closing the form tag:
```
Controller::form(); // This line will automatically generate a secure token to avoid CSRF attack.
```

But before that, you need to make that your `PORTAL` constant in `configure.json` has been setup correctly or the request will be redirected to wrong URL.

Full example:
```
<form action="<?= Controller::url("TestController::index") ?>" method="POST"> 
	<input type="text" name="data" />
	<button>
		Send
	</button>
	
<?php
	Controller::form();
?>
</form>
```
*/

?>

<form action="<?= Controller::url("TestController::index") ?>" method="POST"> 
	<input type="text" name="data" />
	<button>
		Send
	</button>
	
<?php
	Controller::form();
?>
</form>