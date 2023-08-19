<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You have to log in first";
	header('location: login.php');
	exit();
}

if (isset($_GET['codigo'])) {
	$activity_id = $_GET['codigo'];
	$link = mysqli_connect("localhost", "root", "", "registration");

	$username = mysqli_real_escape_string($link, $_SESSION['username']);

    $query = "SELECT * FROM activities INNER JOIN users ON activities.username = users.username WHERE users.username = '$username' AND activities.id = $activity_id";
	$result = mysqli_query($link, $query);

	if (mysqli_num_rows($result) == 1) {
		$delete_query = "DELETE FROM activities WHERE id = '$activity_id'";
		mysqli_query($link, $delete_query);
		$_SESSION['success_msg'] = "Atividade excluída com sucesso!";
	} else {
		$_SESSION['error_msg'] = "Você não tem permissão para excluir essa atividade.";
	}

	mysqli_close($link);
	header('location: ver_produtos.php');
	exit();
} else {
	header('location: menu_functions.php');
	exit();
}
?>
