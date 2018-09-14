<?php

echo "Hello World! <br /><hr />";

new Controller($_POST);
echo '
	<form action="" method="POST">
		Your name: <input type="text" class="form-control" placeholder="Your name" name="name" /><br />
		<button>
			Send
		</button>
		
		<input type="hidden" name="submit" value="'. $_SESSION["IR"] . '" />
		<input type="hidden" name="route" value="TestController" />
	</form>
	<br /><br />
	<hr />
';

new Test();
echo " class";
?>