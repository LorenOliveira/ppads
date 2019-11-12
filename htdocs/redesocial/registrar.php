<?php
	include("db.php");

	if  (isset($_POST['criar'])) {
		$nome = $_POST['nome'];
		$sobrenome = $_POST['sobrenome'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$data_nasc = date("Y/m/d");

		$email_check = mysql_query("SELECT email FROM users WHERE email='$email'");
		$do_email_check = mysql_num_rows($email_check);
		if ($do_email_check >= 1){
			echo '<h3> Este email já está registrado, faça seu login <a href="login.php"> aqui </a></h3>';
		}elseif ($nome == '' OR  strlen($nome) <3){
			echo '<h3>Escreva seu nome corretamente! </h3>';
		}elseif ($email == '' OR  strlen($email) <10){
			echo '<h3>Escreva seu email corretamente! </h3>';
		}elseif ($pass == '' OR  strlen($pass) <5){
			echo '<h3>Escreva sua senha corretamente, ela deve ter mais que 5 caracteres!</h3>';
		}else {
			$query = "INSERT INTO users (nome, sobrenome, email, password, data_nasc) VALUES ('$nome', '$sobrenome', '$email', '$pass', '$data_nasc')";

			$data_nasc = mysql_query($query) or die (mysql_error());
			if ($data_nasc){
				setcookie("login", $email);
				header("location: ./");
			}else {
				echo "<h3> Desculpe, houve um erro ao registrar sua conta! </h3>";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

	<style type="text/css">
		*{font-family: 'Montserrat', cursive;}
		img{display: block; margin: auto; margin-top: 20px; width: 200px;}
		form{ text-align: center; margin-top: 10px;}
		input[type="text"]{border: 1px solid #CCC; width: 250px; height: 25px; padding-left: 10px; border-radius: 3px; margin-top: 10px;}
		input[type="email"]{border: 1px solid #CCC; width: 250px; height: 25px; padding-left: 10px; border-radius: 3px; margin-top: 10px;}
		input[type="password"]{border: 1px solid #CCC; width: 250px; height: 25px; padding-left: 10px; margin-top: 10px; border-radius: 3px;}
		input[type="submit"]{border: none ; width: 120px; height: 30px; margin-top: 20px; border-radius: 3px;}
		input[type="submit"]:hover{background-color: #1E90FF; color: #FFF; cursor: pointer; }
		h2{text-align: center; margin-top: 20px;}
		h3{text-align: center; color: #1E90FF; margin-top: 15px;}
		a{text-decoration: none; color: #333;}
	</style>

</head>
<body>
	<img src="img/logo.png"> <br>
	<h2> Cria a tua conta: </h2>
	<form method="POST">
		<input type="text" placeholder="Nome" name="nome"> <br>
		<input type="text" placeholder="Sobrenome" name="sobrenome"> <br>
		<input type="email" placeholder="Email" name="email"> <br>
		<input type="password" placeholder="Senha" name="pass"> <br>
		<input type="submit" value="Criar uma conta" name="criar"> 
	</form>
	<h3> Já tem uma conta? <a href="login.php"> Faça login aqui!</a></h3>
</body>
</html>


