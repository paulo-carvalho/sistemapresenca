<?php
	//require_once("connect/testmysql_p.php");
	require_once("listar_usuarios.php");

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['desativar'])) 
			$desativar = $_POST['desativar'];
		else
			$desativar="";
		if (isset($_POST['matr'])) 
			$matr = $_POST['matr'];
		else
			$matr="";
	}

	$msg_erro = "";
	$msg_sucesso = "";

	if($desativar!="" && $matr!="") {
		$atualiza_permissao = "UPDATE usuarios SET permissao='$desativar' WHERE matr='$matr'";
		
		if (isset($atualiza_permissao)) {
			if (!mysqli_query($conn, $atualiza_permissao)) {
		  		echo 'Erro: ' . mysqli_error($conn);
		  		$msg_erro = "Não foi possível realizar essa operação.";
			} else {
				$result = mysqli_query($conn, $atualiza_permissao);
				$msg_sucesso = "Usuário desativado com sucesso.";
			}
		}
	}
	mysqli_close($conn);
	//unset($conn);
?>

