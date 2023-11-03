<?php 
session_start();

	include("../inc/auth.php");
	include("../inc/connection.php");
	include("../inc/functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$username = $_POST['username'];
		$email = $_POST['email'];
		$c_email = $_POST['c_email'];
		$password = $_POST['password'];
		$c_password = $_POST['c_password'];

		if(!$err)
		{
			$user_id = random_num(20);
			$query = "insert into users (user_id,username,email,password) values ('$user_id','$username','$email','$password')";

			mysqli_query($con, $query);

			header("Location: login.php");
			die;
		}else
		{
			echo "Entre com informação válida!";
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Cadastro</title>
</head>
<body>

	<div id="box">
		

		<form method="post">
			<div>Cadastrar</div>
			Username: <input id="text" type="text" name="username"><br>
			<?php if (!empty($err_username)): ?>
              <?php echo $err_username ?><br>
            <?php endIf; ?>

			E-mail:   <input id="text" type="text" name="email"><br>
			<?php if (!empty($err_email)): ?>
              <?php echo $err_email ?><br>

			Confirm E-mail:<input id="text" type="text" name="c_email"><br>
			<?php if (!empty($err_c_email)): ?>
              <?php echo $err_c_email ?><br>
            <?php endIf; ?>

			Password: <input id="text" type="password" name="password"><br>
			<?php if (!empty($err_password)): ?>
              <?php echo $err_password ?><br>
            <?php endIf; ?>

			Confirm Password: <input id="text" type="password" name="c_password"><br>
			<?php if (!empty($err_c_password)): ?>
              <?php echo $err_c_password ?><br>
            <?php endIf; ?>
			
			<input id="button" type="submit" value="Cadastrar"><br><br>

			<a href="login.php">Clique para logar</a><br><br>
		</form>
	</div>
</body>
</html>
