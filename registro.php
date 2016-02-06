<html>
	<head>
		<title>Registro</title>
		<link rel="stylesheet" type="text/css" href="registro.css">
		<meta charset="UTF-8">
		<script type="text/javascript">
			function habilitar(checkbox) {
				
				if(checkbox.checked){
					boton.disabled = false;
				}else{
					boton.disabled = true;
				}
			}
		</script>
	</head>

	<body>
		<h1>Registrase</h1>
		<p id="info">Por favor, rellene los datos del siguiente formulario para lelvar a cabo su registro en la web</p>
		<form method="POST" action="#">

			
			<label for="nick">Login/Nickname</label><span class="aster">*</span><input type="text" name="nick" required/><br>
			<label for="pass1">Contraseña</label><span class="aster">*</span><input type="password" name="pass1" required/><br>
			<label for="pass2">Repita la Contraseña</label><span class="aster">* </span><input type="password" name="pass2" required/><br>
			<label for="name">Nombre</label><span class="aster">*</span><input type="text" name="name" required/><br>
			<label for="mail">Correo electrónico</label><span class="aster">* </span> <input type="email" name="mail" required/><br>
			
			<p id="info_mail">(Es importante introducir una dirección de correo real, puesto que se utilizará para el 
				envío de sus datos de registro)</p><br>
			<label for="firma">Firma Personal</label><span class="aster">* </span><input type="text" name="firma" required/><br>

			<p id="info_firma">La firma es su distintivo personal que se mostrará al pie de sus comentarios y mensajes</p><br>
			<p id="info_campos">*Todos los campos son obligatorios</p><br>

			<label for="check">Acepto los <span>Términos y Condiciones de Uso</span> de esta página web.
				<input onchange="habilitar(this)" type="checkbox" name="check"/><br><br>
			<input disabled type="submit" id = "boton" name="subButton" value="Aceptar">
		</form>

		<?php
			/*Creamos una variable para hacer los POST de cada uno de los campos del formulario.
			Al trabajar con variables eviatremos errores si hacemos POST en la consulta.
			Con isset($_POST['nick']) ? $_POST['nick'] : null; estamos comprobando si existe la variable,
			en caso afirmativo le asigna el valor del POST, en caso negativo le asigna NULL
			*/
			$nick 	=  	isset($_POST['nick']) ? $_POST['nick'] : null;
			$pass1 	= 	isset($_POST['pass1']) ? $_POST['pass1'] : null;
			$pass2 	= 	isset($_POST['pass2']) ? $_POST['pass2'] : null;
			$nom 	= 	isset($_POST['name']) ? $_POST['name'] : null;
			$mail 	= 	isset($_POST['mail']) ? $_POST['mail'] : null;
			$firma 	=	isset($_POST['firma']) ? $_POST['firma'] : null;
			



			if(isset($_POST['subButton'])){//Comprobar que han pulsado el botón Aceptar
				//Validaciones, en cada una se crearán unos tokens para comprobar que todo ha ido bien y mandarlo a la BD
				//1. Nickname
				$tokenNick = false;

				if(!empty($nick)){//Comprobamos que siga el patrón
					$tokenNick = true;
				}

				//2.Contraseña
				$tokenPass = false;
				//Expresión regular para la validación de una contraseña. Puede ser alfanumérica y con un mínimo de 8 caracteres
				$patronPass = '/([a-zA-Z0-9\_-]){8,}/';
	
				if($pass1 == $pass2){ //Miramos si las dos son iguales y si siguen el patrón
					if (preg_match($patronPass,$pass1)){
						$tokenPass = true;
					}
				} else{
					echo "<h2>Las contrase%ntilde;as no coinciden</h2>";
				}

				//3.Nombre
				//Expresión regular que SOLO acepta letras
				$tokenNombre = false;
				$patronNombre = '^([a-zA-Z]+)$^';

				if(preg_match($patronNombre, $nom)){//Comprobamos que siga el patrón
					$tokenNombre = true;
				}

				//4.Mail
				$tokenMail = false;
				//Expresión reguñar alfanumérica para comprobar una dirección de correo electrónico.
				//Además de cadenas alfanuméricas debe contener un @.
				$patronMail = '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/';

				if(preg_match($patronMail, $mail)){//Comprobamos que siga el patrón
					$tokenMail = true;
				}

				//5.Firma
				$tokenFirma = false;
				//No lo comparamos con ninguna expresión regular ya que el usuario puede escribir cualquier caracter
				if(!empty($firma)){
					$tokenFirma = true;
				}

      			//Una vez validado todo, mediante los tokens comprobamos que todo haya ido bien

      			if($tokenNick && $tokenPass && $tokenNombre && $tokenMail && $tokenFirma){
      				$conexion = mysqli_connect("localhost", "a7886665_APPphp", "a7886665_APPphp","rosita") or die ("No se puede conectar con el servidor");
      				
					$consulta = "INSERT INTO rosita (`Nick`, `Password`, `Nombre`, `Mail`, `Firma`)";
					$consulta.= "VALUES ('$nick', '$pass1', '$nom', '$mail','$firma')";

					$sql = mysqli_query($conexion, $consulta) or die('Algo ha fallado; ' .mysqli_error($conexion));
					mysqli_close($conexion);
					echo "<h2>¡Gracias por registrarte!</h2>";
      			} 
      			/*Si alguno de los tokens no ha cambiado su valor a true, se debe a que el campo rellenado
      			no cumple la expresión regular con la que debe validar*/
      			if(!$tokenNick) {
      				echo"<h2 color = 'red'>El nick no cumple el formato correcto</h2>";
      			} 
      			if(!$tokenPass) {
      				echo"<h2 color = 'red'>La contraseña no cumple el formato correcto</h2>";
      			} 
      			if (!$tokenNombre) {
      				echo"<h2 color = 'red'>El nombre no cumple el formato correcto</h2>";
      			} 
      			if (!$tokenMail) {
      				echo"<h2 color = 'red'>El email no cumple el formato correcto</h2>";
      			} 
      			if (!$tokenFirma) {
      				echo"<h2 color = 'red'>La firma no cumple el formato correcto</h2>";
      			} 

			}
		?>
	</body>
</html>