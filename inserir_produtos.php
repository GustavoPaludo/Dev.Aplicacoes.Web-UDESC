<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You have to log in first";
        header('location: login.php');
        exit();
    }

    $link = mysqli_connect("localhost", "root", "", "registration");

    $nome = mysqli_real_escape_string($link, $_POST['nome']);
    $data = mysqli_real_escape_string($link, $_POST['data']);
    $hora = mysqli_real_escape_string($link, $_POST['hora']);
    $descricao = mysqli_real_escape_string($link, $_POST['descricao']);
    $username = mysqli_real_escape_string($link, $_SESSION['username']);
    $username2 = mysqli_real_escape_string($link, $_POST['username2']); 
	$active = true;

    $timeInt = date('Gi', strtotime($hora));

    $query = "SELECT MAX(id) AS max_id FROM activities";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
    $id = $row['max_id'] + 1;

	$query = "INSERT INTO activities (id, activity_name, description, date, time, timeInt, username, active) VALUES ($id, '$nome', '$descricao', '$data', '$hora', $timeInt, '$username', $active)";
    mysqli_query($link, $query);

    mysqli_close($link);

    header("location: ver_produtos.php");
    exit();
}
?>

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
									<h3 class="mb-4">Cadastro de Atividade</h3>
								</div>
							</div>
							<div class="content">
                            <form class="form" method="POST" action="">
								<label for="nome">Nome:</label><br>
								<input type="text" name="nome" required>
								<br>
								<label for="data">Data:</label><br>
								<input type="date" name="data" required>
								<br>
								<label for="hora">Hora:</label><br>
								<input type="time" name="hora" required>
								<br>
								<label for="descricao">Descrição:</label><br>
								<textarea name="descricao" required></textarea>
								<br>
								<input type="submit"class="form-control btn btn-primary rounded submit px-3" value="Adicionar Atividade">
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
