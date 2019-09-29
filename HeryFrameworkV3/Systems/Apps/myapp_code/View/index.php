<?php
new Controller($_POST);
?>
<form action="" method="POST">
	Name:<br />
	<input type="text" name="name" /><br />
	Address:<br />
	<textarea name="address"></textarea><br />
	
	<?= Controller::form("route", ["action" => "hery"]); ?>
	<button>
		Submit
	</button>
</form>