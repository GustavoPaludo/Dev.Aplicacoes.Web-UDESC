<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

$link = mysqli_connect("localhost", "root", "", "registration");

$username = mysqli_real_escape_string($link, $_SESSION['username']);

$query = "SELECT * FROM activities INNER JOIN users ON activities.username = users.username WHERE users.username = '$username' ORDER BY activities.activity_name";
$result = mysqli_query($link, $query);
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            table-layout: auto;
        }

	</style>
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
                            <div class="table-wrapper">
                                <table border="1">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Descrição</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>

                                    <?php
									mysqli_data_seek($result, 0);
									while ($row = mysqli_fetch_assoc($result)) {
										echo "<tr>";
										echo "<td>" . $row['activity_name'] . "</td>";
										echo "<td>" . $row['date'] . "</td>";
										echo "<td>" . substr($row['timeInt'], 0, 2) . ":" . substr($row['timeInt'], 2, 2) . "</td>";
										echo "<td>" . $row['description'] . "</td>";
										echo "<td><a href=\"delete_produtos.php?codigo=" . $row['id'] . "\">deletar</a>";
										echo "<td><a href=\"editar_produtos.php?codigo=" . $row['id'] . "\">editar</a></td>";
										echo "</tr>";
									}
									?>
                                </table>
                            </div><br>
                            <a class="form-control btn btn-primary rounded submit px-3" href="inserir_produtos.php">Adicionar atividade</a><br>
							<p class="text-center"> <a href="menu_functions.php">Voltar</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
