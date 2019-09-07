<?php
	$status = [];
	$status['error'] = false;
	$status['msg'] = '';

	if(isset($_POST['submit'])) {
		if(isset($_POST['email']) && isset($_POST['password'])) {
			
		}
		else {
			$status['error'] = true;
			$status['msg'] = 'Email\senha devem ser informados.';
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
    <form class="col-md-4 offset-md-4" action="index.php" method="POST">
		<h1>Acessar</h1>
	
		<div class="form-group">
			<label for="exampleInputEmail1">E-mail</label>
			<input type="email" name="email" class="form-control" required>
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