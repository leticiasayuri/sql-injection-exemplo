<?php
	$status = [];
	$status['error'] = false;
	$status['msg'] = '';
	$status['sql'] = '';
	
	$host = 'localhost';
	$user = 'root';
	$password = 'root';
	$database = 'sql_injection';

	if(isset($_POST['submit'])) {
		if(isset($_POST['email']) && isset($_POST['password'])) {
			
			$email = $_POST['email'];
			$pass = $_POST['password'];
			
			$connection = mysqli_connect($host, $user, $password, $database); 
			
			if($connection) {
				$sql = "select id from users_insecure where email = '" . $email . "' and password = '" . hash('sha256', $pass) . "';";
				$status['sql'] = $sql;
				$res = mysqli_query($connection, $sql);

				if($res) {
					if($res->num_rows > 0) {
						$status['error'] = false;
						$status['msg'] = "Usuário encontrado.";
					}
					else {
						$status['error'] = true;
						$status['msg'] = "Usuário não encontrado.";
					}
				}
				else {
					$status['error'] = true;
					$status['msg'] = "Falha ao executar instrução: " . mysqli_error($connection);
				}
				
				mysqli_close($connection);
			}
			else {
				$status['error'] = true;
				$status['msg'] = "Falha na conexão: " . mysqli_connect_error();
			}
		}
		else {
			$status['error'] = true;
			$status['msg'] = 'Email e/ou senha devem ser informados.';
		}
	}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Signin</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
	<?php
	if($status['sql'] != '') { ?>
		<p class="alert alert-info"><strong>SQL: </strong> <?php echo $status['sql'] ?></p> <?php
	}
	?>

    <form class="col-md-4 offset-md-4" action="index.php" method="POST">
		<h1>Acessar</h1>
	
		<div class="form-group">
			<label for="exampleInputEmail1">E-mail</label>
			<input type="text" name="email" class="form-control" required value="<?php echo $_POST['email'] ?? '' ?>">
		</div>
		
		<div class="form-group">
			<label for="exampleInputPassword1">Senha</label>
			<input type="password" name="password" class="form-control" required>
		</div>
			
		<?php
			if($status['msg'] != '') {
				if($status['error']) { ?>
					<p class="alert alert-danger"><strong>Falha no login.</strong> <?php echo $status['msg'] ?></p> <?php
				}
				else{ ?>
					<p class="alert alert-success"><strong>Login com sucesso!</strong> <?php echo $status['msg'] ?></p> <?php
				}
			}
		?>
			
		<input type="submit" name="submit" class="btn btn-primary" value="Submit"/>
	</form>
</body>

</html>