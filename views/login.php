<form method="POST" action="index.php">
	<label>Login<br><input name="username" type="text"></label><br>
	<label>Password<br><input name="password" type="password"></label><br>
	<?php
	if(!empty($_GET['error'])){
		echo '<b style="color:red;">Не верный логи/пароль</b>';
	}
	?>
	<input type="submit">
</form>
