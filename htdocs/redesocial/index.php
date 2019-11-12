<?php
	include("header.php");

	$pubs = mysql_query("SELECT * FROM pubs ORDER BY id desc");

	if (isset($_POST['publish'])) {
		if ($_FILES["file"]["error"] > 0) {
			$texto = $_POST["texto"];
			$hoje = date("Y-m-d");

			if ($texto == ""){
				echo "<h3> Você precisa digitar algo antes de publicar! </h3>";
			}else {
				$query = "INSERT INTO pubs (user, texto, data) VALUES ('$login_cookie', '$texto', '$hoje')";
				$data = mysql_query($query) or die();
				if ($data){
					header("Location: ./");
				}else{
					echo "Alguma coisa não ocorreu bem... Tente outra vez mais tarde!";
				}
			}
		}else {
			$n = rand(0, 1000000);
			$img = $n.$_FILES["file"]["name"];

			move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$img);
			$texto = $_POST['texto'];
			$hoje = date("Y-m-d");

			if ($texto == ""){ 
				echo "<h3> Você precisa digitar algo antes de publicar! </h3>";
			}else {
				$query = "INSERT INTO pubs (user, texto, imagem, data) VALUES ('$login_cookie', '$texto', '$img', '$hoje')";
				$data = mysql_query($query) or die();
				if ($data){
					header("Location: ./");
				}else{
					echo "Alguma coisa não ocorreu bem... Tente outra vez mais tarde!";
				}
			}	
		}
	}
?>
<html>
<header> 
	<style>
	div#publish{width: 400px; height: 210px; display: block; margin: auto; border: none; border-radius:5px; background: #FFF; box-shadow: 0 0 6px #A1A1A1; margin-top: 30px;}	
	div#publish textarea{width: 365px; height: 150px; display: block; margin: auto; border-radius: 5px; padding-left: 5px; padding-top: 5px; border-width: 1px; border-color: #A1A1A1;}
	div#publish img{margin-top: 4px; margin-left: 10px; width: 30px; cursor: pointer;}
	div#publish input[type="submit"]{width: 70px; height: 25px; border-radius: 3px; float: right;; margin-right: 15px; border:none; margin-top: 5px; background: #4169E1; color: #FFF; cursor: pointer;}
	div#publish input[type="submit"]:hover{background: #001F3F; }

	div.pub{width: 400px; min-height: 70px; max-height: 1000px; display: block; margin: auto; border-radius: 5px; background-color: #FFF; box-shadow: 0 0 6px #A1A1A1; margin-top: 30px;}
	div.pub a{color: #666; text-decoration: none;}
	div.pub a:hover{color: #111; text-decoration: none;}
	div.pub p{margin-left: 10px; content: #666; padding-top: 10px;}
	div.pub span{display: block; margin: auto; width: 380px; margin-top: 10px;}
	div.pub img{display: block; margin: auto; width: 100%; margin-top: 10px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;}

	</style>
</header>
<body>
	<div id="publish">
		<form method="POST" enctype="multipart/form-data">
			<br/>
			<textarea placeholder="Escreva uma publicação nova..." name="texto"></textarea>
			<label for="file-input">
				<img src="img/imagegrey.png" title="Inserir uma fotografia"/>
			</label>
			<input type="submit" value="Publicar" name="publish"/>

			<input type="file" id="file-input" name="file" hidden/>
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

