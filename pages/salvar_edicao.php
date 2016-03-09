<?php
	require_once("connect/testmysql_p.php");

	session_start();

	//EDIÇÃO USUÁRIO	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['matr']))
			$matricula = $_POST['matr'];			

		if(isset($_POST['nome'])) 
			$nome = $_POST['nome'];

		if(isset($_POST['email_pessoal'])) 
			$email_pessoal = $_POST['email_pessoal'];

		if(isset($_POST['email_profissional']))
			$email_profissional = $_POST['email_profissional'];
		else
			$email_profissional = "";

		if(isset($_POST['ingresso_faculdade']))
			$ingresso_faculdade = $_POST['ingresso_faculdade'];
		else
			$ingresso_faculdade = "";

		if(isset($_POST['ingresso_empresa']))
			$ingresso_empresa = $_POST['ingresso_empresa'];
		else
			$ingresso_empresa = "";

		if(isset($_POST['data_desligamento']))
			$data_desligamento = $_POST['data_desligamento'];
		else
			$data_desligamento = "";

		if(isset($_POST['cargo']))
			$cargo = $_POST['cargo'];
		else
			$cargo = "";

		if(isset($_POST['diretoria']))
			$diretoria = $_POST['diretoria'];
		else
			$diretoria = "";

		if(isset($_POST['permissao']))
			$permissao = $_POST['permissao'];
		else
			$permissao = "";

		

		$editar = "UPDATE usuarios SET nome='$nome', email_pessoal='$email_pessoal', email_profissional='$email_profissional', diretoria='$diretoria', cargo='$cargo', ingresso_faculdade='$ingresso_faculdade', ingresso_empresa='$ingresso_empresa', permissao=$permissao, data_desligamento='$data_desligamento' WHERE matr='$matricula';";

		/* OPERAÇÃO DE INSERÇÃO */
		if (isset($editar)) {
			if (!mysqli_query($conn, $editar)) {
		  		$msg_erro = 'Erro ao editar usuário! ';
		  		$_SESSION['erro_edicao'] = $msg_erro;
		  		header("Location: editar_usuario.php?id=$matricula");
			} else {
				$msg_sucesso = "Dados alterados com sucesso!";
				$_SESSION['sucesso_edicao'] = $msg_sucesso;
				header("Location: ver_usuario.php?id=$matricula");
			}
		}					
	}
	mysqli_close($conn);
?>