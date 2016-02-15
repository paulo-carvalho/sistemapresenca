<?php
				
	//require_once("connect/testmysql_p.php");
	require_once("listar_pos_juniores.php");

	$ativar="";
	$matr="";

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['ativar'])) 
			$ativar = $_POST['ativar'];
		if (isset($_POST['matr'])) 
			$matr = $_POST['matr'];
	}

	$msg_erro = "";
	$msg_sucesso = "";

	if($ativar!="" && $matr!="") {
		$atualiza_permissao = "UPDATE usuarios SET permissao='$ativar' WHERE matr='$matr'";
		
		if (isset($atualiza_permissao)) {
			if (!mysqli_query($conn, $atualiza_permissao)) {
		  		echo 'Erro: ' . mysqli_error($conn);
		  		$msg_erro = "Não foi possível realizar essa operação.";
			} else {
				$result = mysqli_query($conn, $atualiza_permissao);
				$msg_sucesso = "Usuário ativado com sucesso.";
			}
		}
	}
	mysqli_close($conn);
	//unset($conn);
?>



