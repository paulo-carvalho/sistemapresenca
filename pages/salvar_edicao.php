	<?php
		require_once("connect/testmysql_p.php");

		//EDIÇÃO USUÁRIO	
		if(isset($_POST['matricula']))
			$matricula = $_POST['matricula'];
		else
			$matricula = "";

		if(isset($_POST['nome']))
			$nome = $_POST['nome'];
		else
			$nome = "";

		if(isset($_POST['email_pessoal']))
			$email_pessoal = $_POST['email_pessoal'];
		else
			$email_pessoal = "";

		if(isset($_POST['email_profissional']))
			$email_profissional = $_POST['email_profissional'];
		else
			$email_profissional = "";

		if(isset($_POST['cargo']))
			$cargo = $_POST['cargo'];
		else
			$cargo = "";

		if(isset($_POST['diretoria']))
			$diretoria = $_POST['diretoria'];
		else
			$diretoria = "";


		$editar = "UPDATE usuarios SET nome='$nome', email_pessoal='$email_pessoal', email_profissional='$email_profissional' WHERE matr='$matricula';";

		/* OPERAÇÃO DE INSERÇÃO */
		if (isset($editar)) {
			if (!mysqli_query($conn, $editar)) {
		  		$msg_erro = 'Erro: editar';
		  		echo "fail";
		  		//$msg_erro = "Erro ao inserir no banco.";
			} else {
				$msg_sucesso = "Dados alterados com sucesso!";
				echo "sucesso;";
			}
		}					

		mysqli_close($conn);
	?>
