<?php
	$status = [];
	$status["error"] = false;
	$status["msg"] = "";
	$status["sql"] = "";

	$mysql_usuario = "leticia";
	$mysql_senha = "";
	$mysql_host = "localhost";
	$mysql_db = "sql_injection";

	if (isset($_POST["submit"])) {
		if (isset($_POST["email"]) && isset($_POST["senha"])) {
			$email = $_POST["email"];
			$senha = $_POST["senha"];
			$senha = hash('sha256', $senha);

			$mysqli = new mysqli($mysql_host, $mysql_usuario, $mysql_senha, $mysql_db);

			if ($mysqli->connect_errno) {
				$status["error"] = true;
				$status["msg"] = "Falha na conexão.";
			} else {
				$query = "select id from user_secure where email = ? and password = ?";
				$stmt = $mysqli->prepare($query);

				if ($stmt) {
					$stmt->bind_param("ss", $email, $senha);
					$stmt->execute();
					$stmt->store_result();

					if ($stmt->num_rows > 0) {
						$status["error"] = false;
						$status["msg"] = "Usuário encontrado";
					} else {
						$status["error"] = true;
						$status["msg"] = "Usuário não encontrado";
					}
				} else {
					$status["error"] = "Falha ao executar instrução: ".$stmt->error;
				}

				$stmt->close();
				$mysqli->close();
			}
		} else {
			$status["error"] = true;
			$status["msg"] = "Email e/ou senha devem ser informados.";
		}
	}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Login</title>
</head>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Login</h1>
        </div>
    </div>
    <div class="container">
        <form name="form" action="index.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" id="email" name="email"
                    placeholder="Digite seu nome de usuário" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha"
                    required>
			</div>
			
			<?php
				if($status["msg"] != "") {
					if($status["error"]) { ?>
						<p class="alert alert-danger"><strong>Falha no login.</strong> <?php echo $status["msg"] ?></p> <?php
					}
					else{ ?>
						<p class="alert alert-success"><strong>Login com sucesso!</strong> <?php echo $status["msg"] ?></p> <?php
					}
				}
			?>

		<input type="submit" name="submit" class="btn btn-primary" value="Login"/>
        </form>
    </div>   
</body>

</html>