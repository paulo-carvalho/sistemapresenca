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

		if(isset($_POST['senha_antiga']))
			if($_POST['senha_antiga'] == "")
				$senha_antiga = "";
			else
				$senha_antiga = hash('sha256', $_POST['senha_antiga']);

		if(isset($_POST['senha_nova']))
			if($_POST['senha_nova'] == "")
				$senha_nova = "";
			else
				$senha_nova = hash('sha256', $_POST['senha_nova']);

		if(isset($_POST['confirma_senha_nova']))
			if($_POST['confirma_senha_nova'] == "")
				$confirma_senha_nova = "";
			else
				$confirma_senha_nova = hash('sha256', $_POST['confirma_senha_nova']);

		$checar_senha = $conn->prepare("SELECT `senha` FROM `usuarios` WHERE `matr`=? LIMIT 1");
		// definir dependencias da query preparada
		$checar_senha->bind_param("i", $_SESSION['matricula']);
		$checar_senha->execute();

		$checar_senha->bind_result($verificador);
		$checar_senha->fetch();
		$checar_senha->close();

		// Condicoes de falha para edicao de usuario (else = sucesso para edicao)
		if($senha_antiga != "" && ($senha_nova == "" || $confirma_senha_nova == "")) {
			// Impossivel alterar senha! Campo nova senha e obrigatorio.
			$_SESSION['msg_edicao'] = 1;
			header("Location: editar_usuario.php?id=$matricula");
		} else if($senha_nova != $confirma_senha_nova) {
			// Nova senha não pode ser confirmada (valores diferentes).
			$_SESSION['msg_edicao'] = 2;
			header("Location: editar_usuario.php?id=$matricula");
		} else if(!empty($senha_antiga) && $verificador != $senha_antiga) {
			// Senha incorreta.
			$_SESSION['msg_edicao'] = 3;
			header("Location: editar_usuario.php?id=$matricula");
		} else {
			// preparado para editar
			// condicao para ver se altera os dados junto da senha
			if(empty($senha_antiga) && empty($senha_nova) && empty($confirma_senha_nova)) {
				$editar = $conn->prepare("UPDATE usuarios SET nome=?, email_pessoal=?,
					email_profissional=?, diretoria=?, cargo=?, ingresso_faculdade=?,
					ingresso_empresa=?, permissao=?, data_desligamento=?
					WHERE matr=?;");

				$editar->bind_param("sssisssisi", $nome, $email_pessoal,
					$email_profissional, $diretoria, $cargo, $ingresso_faculdade,
					$ingresso_empresa, $permissao, $data_desligamento,
					$matricula);
			} else {
				$editar = $conn->prepare("UPDATE usuarios SET nome=?, email_pessoal=?,
					email_profissional=?, diretoria=?, cargo=?, ingresso_faculdade=?,
					ingresso_empresa=?, permissao=?, data_desligamento=?, senha=?
					WHERE matr=? AND senha=?;");

				$editar->bind_param("ss"."siss"."siss"."is", $nome, $email_pessoal,
					$email_profissional, $diretoria, $cargo, $ingresso_faculdade,
					$ingresso_empresa, $permissao, $data_desligamento, $senha_nova,
					$matricula, $senha_antiga);
			}

			if(!$editar->execute()) {
				// Problemas na conexao com o servidor. Tente novamente mais tarde.
				$_SESSION['msg_edicao'] = 4;
				header("Location: editar_usuario.php?id=$matricula");
			} else {
				// Usuario alterado com sucesso!
				$_SESSION['msg_edicao'] = 0;
				header("Location: ver_usuario.php?id=$matricula");
			}
		}
	}

	mysqli_close($conn);
?>
