<?php
	include("header.php");

	$id = $_GET["id"];
	$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
	$saber = mysql_fetch_assoc($saberr);
	$email = $saber["email"];

	if($email==$login_cookie) {
		header("Location: myprofile.php");
	}


	$pubs = mysql_query("SELECT * FROM pubs WHERE user='$email' ORDER BY id desc");
	
	if(isset($_POST['add'])){
		add();
	}

	function add(){
		$login_cookie = $_COOKIE['login'];
		if (!isset($login_cookie)){
			header("Location: login.php");
		}
		$id = $_GET['id'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];
		$data = date("Y/m/d");

		$ins = "INSERT INTO amizades (`de`,`para`,`data`) VALUES ('$login_cookie', '$email', '$data')";
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf){
			header("Location: profile.php?id=".$id);
		}else{
			echo '<h3>Erro ao enviar pedido...</h3>';
		}
	}

	if(isset($_POST['cancelar'])){
		cancel();
	}

	function cancel(){
		$login_cookie = $_COOKIE['login'];
		if (!isset($login_cookie)){
			header("Location: login.php");
		}
		$id = $_GET['id'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];
		

		$ins = "DELETE FROM amizades WHERE `de` = '$login_cookie' AND para = '$email'"; 
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf){
			header("Location: profile.php?id=".$id);
		}else{
			echo '<h3>Erro ao cancelar pedido...</h3>';
		}
	}

	if(isset($_POST['remover'])){
		remove();
	}

	function remove(){
		$login_cookie = $_COOKIE['login'];
		if (!isset($login_cookie)){
			header("Location: login.php");
		}
		$id = $_GET['id'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];
		

		$ins = "DELETE FROM amizades WHERE `de` = '$login_cookie' AND para = '$email' OR `para` = '$login_cookie' AND de = '$email'"; 
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf){
			header("Location: profile.php?id=".$id);
		}else{
			echo '<h3>Erro ao eliminar pedido...</h3>';
		}
	}


	if(isset($_POST['aceitar'])){
		aceitar();
	}

	function aceitar(){
		$login_cookie = $_COOKIE['login'];
		if (!isset($login_cookie)){
			header("Location: login.php");
		}
		$id = $_GET['id'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];
		

		$ins = "UPDATE amizades SET `aceite`='sim' WHERE `de`='$email' AND para ='$login_cookie'";

		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf){
			header("Location: profile.php?id=".$id);
		}else{
			echo '<h3>Erro ao eliminar pedido...</h3>';
		}
	}
?>
<html>
<header> 
	<style type="text/css">
	h2{text-align: center; padding-top: 30px;color: #fff; }

	img#profile{width: 100px; height: 100px; display: block; margin: auto; margin-top: 30px;  border: 5px solid #000000; background-color: #000000; border-radius: 10px; margin-bottom: -22px;}

	div#menu{width: 300px; height: 120px; display: block; margin: auto; border: none; border-radius: 5px; background-color:000000; text-align: center;}
	div#menu input{height: 25px; border: none; border-radius: 3px; background-color: #FFF; cursor: pointer;}
	div#menu input[name="add"]{margin-right: 40px;}
	div#menu input[name="aceitar"]{margin-right: 40px;}
	div#menu input[name="remover"]{margin-right: 40px;}
	div#menu input[name="cancelar"]{margin-right: 40px;}
	div#menu input:hover{height: 25px; border: none; border-radius: 3px; background-color: transparent; cursor: pointer; color: #FFF;}

	div.pub{width: 400px; min-height: 70px; max-height: 1000px; display: block; margin: auto; border-radius: 5px; background-color: #FFF; box-shadow: 0 0 6px #A1A1A1; margin-top: 30px;}
	div.pub a{color: #666; text-decoration: none;}
	div.pub a:hover{color: #111; text-decoration: none;}
	div.pub p{margin-left: 10px; content: #666; padding-top: 10px;}
	div.pub span{display: block; margin: auto; width: 380px; margin-top: 10px;}
	div.pub img{display: block; margin: auto; width: 100%; margin-top: 10px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;}

	</style>
</header>
<body>
	<?php
		if ($saber["img"]==""){
			echo '<img src="img/user.png" id="profile">';
		}else{
			echo '<img src="upload/'.$saber["img"].'" id="profile">';
		}

	?>
	<div id="menu"> 
		<form method="POST">
		<h2> <?php echo $saber['nome']." ".$saber['sobrenome']; ?> </h2><br />
	<?php
		$amigos = mysql_query("SELECT * FROM amizades WHERE de='$login_cookie' AND para='$email' OR para='$login_cookie' AND de='$email'");
		$amigoss = mysql_fetch_assoc($amigos);
		if (mysql_num_rows($amigos)>=1 AND $amigoss["aceite"]=="sim") {
			echo '<input type="submit" value="Remover amigo"  name="remover"> <input type="submit" name="denunciar" value="Denunciar">';
		}elseif (mysql_num_rows($amigos)>=1 AND $amigoss["aceite"]=="nao" AND $amigoss["para"]==$login_cookie){
			echo '<input type="submit" value="Aceitar Pedido" name="aceitar"> <input type="submit" name="denunciar" value="Denunciar">';
		}elseif (mysql_num_rows($amigos)>=1 AND $amigoss["aceite"]=="nao" AND $amigoss["de"]==$login_cookie){
			echo '<input type="submit" value="Cancelar Pedido" name="cancelar"> <input type="submit" name="denunciar" value="Denunciar">';
		}else{
			echo '<input type="submit" value="Adicionar amigo" name="add"><input type="submit" name="denunciar" value="Denunciar">';
		}
	?>
		</form>
	</div>
	
	<?php
		while($pub=mysql_fetch_assoc($pubs)) {
			$email = $pub['user'];
			$saberr = mysql_query("SELECT * FROM users WHERE email='$email'");
			$saber = mysql_fetch_assoc($saberr);
			$nome = $saber['nome']." ".$saber['sobrenome'];
			$id = $pub['id'];

			if ($pub['imagem']=="") {
				echo '<div class="pub" id="'.$id.'">
					<p><a href="profile.php?id='.$saber['id'].'">'.$nome.'</a> - '.$pub["data"].'</p>
				<span>'.$pub['texto'].'</span><br /> </div>';
			}else {
				echo '<div class="pub" id="'.$id.'">
				<p><a href="profile.php?id='.$saber['id'].'">'.$nome.'</a> - '.$pub["data"].'</p>
				<span>'.$pub['texto'].'</span> 
				<img src="upload/'.$pub["imagem"].'"/>
				</div>';
			}
		}
	?>
	<br />
	<div id="footer"><p>&copy; Rede+Cientistas, 2019 - Todos os direitos reservados.</p></div> <br />
</body>
</html>

