<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	</head>
<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="wrap">
						<div class="img" style="background-image: url(images/bg-1.png);"></div>
						<div class="login-wrap p-4 p-md-5">
							<div class="d-flex">
								<div class="w-100">
									<h3 class="mb-4">Atividades</h3>
								</div>
							</div>
							<div class="content">
							<?php
								session_start();

								if (!isset($_SESSION['username'])) {
									$_SESSION['msg'] = "You have to log in first";
									header('location: login.php');
									exit();
								}

								$link = mysqli_connect("localhost", "root", "", "registration");

								$username = mysqli_real_escape_string($link, $_SESSION['username']);

								if (!isset($_GET['codigo'])) {
									echo "Código da atividade não fornecido";
									exit();
								}

								$codigo = $_GET['codigo'];

								$query = "SELECT * FROM activities INNER JOIN users ON activities.username = users.username WHERE users.username = '$username' AND activities.id = $codigo";
								$result = mysqli_query($link, $query);

								if (mysqli_num_rows($result) == 0) {
									echo "Atividade não encontrada";
									exit();
								}

								$row = mysqli_fetch_assoc($result);

								if ($_SERVER['REQUEST_METHOD'] === 'POST') {

									$nome = mysqli_real_escape_string($link, $_POST['nome']);
									$data = mysqli_real_escape_string($link, $_POST['data']);
									$hora = mysqli_real_escape_string($link, $_POST['hora']);
									$descricao = mysqli_real_escape_string($link, $_POST['descricao']);

									$active = true;
									$timeInt = date('Gi', strtotime($hora));

									$updateQuery = "UPDATE activities SET activity_name = '$nome', date = '$data', time = '$hora', timeInt = '$timeInt', description = '$descricao', active = $active WHERE id = '$codigo'";
									mysqli_query($link, $updateQuery);

									header('location: ver_produtos.php');
									exit();
								}
							?>

							<form class="form" method="POST" action="">
								<label for="nome">Nome:</label><br>
								<input type="text" name="nome" value="<?php echo $row['activity_name']; ?>" required>
								<br>
								<label for="data">Data:</label><br>
								<input type="date" name="data" value="<?php echo $row['date']; ?>" required>
								<br>
								<label for="hora">Hora:</label><br>
								<input type="time" name="hora" value="<?php echo $row['time']; ?>" required>
								<br>
								<label for="descricao">Descrição:</label><br>
								<textarea name="descricao" required><?php echo $row['description']; ?></textarea><br>
								<br>
								<input type="submit"class="form-control btn btn-primary rounded submit px-3" value="Salvar Alterações">
							</form>
                            </div><br>
							<p class="text-center"> <a href="ver_produtos.php">Voltar</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
