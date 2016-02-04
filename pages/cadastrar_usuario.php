<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	/* PARAMETROS */
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

	if(isset($_POST['matr']))
		$matr = substr($_POST['matr'], 2);
	else
		$matr = "";

	if(isset($_POST['senha']))
		$senha = hash('sha256', $_POST['senha']);
	else
		$senha = "";

	if(isset($_POST['confirm_passw']))
		$confirm_passw = hash('sha256', $_POST['confirm_passw']);
	else
		$confirm_passw = "";

	if($passw != $confirm_passw)
		echo "SENHAS NAO COINCIDEM!";

	if($cargo == "diretor" || ($cargo == "membro" && $setor == "rh"))
		$permissao = "admin";
	else
		$permissao = "comum";

        /* QUERIES  */
        if($matricula != "")
                $sql = "INSERT INTO usuario VALUES('".$matr."', '".$nome."', '".$senha."', '".$email_pessoal."', '".$email_profissional."', '".$diretoria."', '".$cargo."', '".$permissao."', '".$conectado."', '".$ingresso_faculdade."', '".$data_criacao."', '".$data_desligamento."')" ;


        $diretorias = "SELECT id_diretoria, nome_diretoria FROM diretorias";                       
	$select_diretorias = mysqli_query($conn, $diretorias);
			while ($row = mysqli_fetch_assoc($select_diretorias)) {
									    echo "<tr>".
											"<td>".$row['id_diretoria']."</td>".
											"<td>".$row['nome_diretoria']."</td>".
											"<td class='text-center'><i class='fi-zoom-in'></td>".
											"<td class='text-center'><i class='fi-page-edit'></i></td>".
											"<td class='text-center'><i class='fi-x'></td>".
										"</tr>";
									}
	

								

	/* DEBUG */
	//if(isset($sql))
		//echo $sql;

	/* OPERAÇÃO DE INSERÇÃO */
	$msg_erro = "";
	$msg_sucesso = "";
	if (isset($sql))
		if (!mysqli_query($conn, $sql)) {
	  		//$msg_erro = 'Erro: ' . mysqli_error($con);
	  		$msg_erro = "Não foi possível realizar essa operação.";
		} else {
			$msg_sucesso = "Usuário cadastrado com sucesso!";
		}
	mysqli_close($conn);
?>

<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Cadastro</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
	<?php
		require_once("menu/menu.html");
	?>

	<br>

	<div class="row">
		<div class="large-12 medium-10 large-push-0 medium-push-1 columns">
			<?php
				if($msg_erro != "")
					echo "<div data-alert='' class='alert-box alert'>
							".$msg_erro."
							<a href='#' class='close'>×</a>
						</div>";

				if($msg_sucesso != "")
					echo "<div data-alert='' class='alert-box success'>
							".$msg_sucesso."
							<a href='#' class='close'>×</a>
						</div>";
			?>
			<div class="panel">
				<h3 class="text-center">Cadastro de novo usuário</h3>
				<br>
				<div class="row">
					<div class="large-8 medium-10 small-12 large-push-2 medium-push-1 columns">
						<form id="cadastro" name="cadastro" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" data-abide>
							
							<label for="name"> Nome Completo: <span style="color: red;">*</span> 
								<input type="text" id="nome" name="nome" required pattern="[a-zA-Z]+" autocomplete="off" />
							</label>
    						<small class="error">Nome é um campo obrigatório.</small>

							<label for="email"> Email Pessoal: <span style="color: red;">*</span> 
								<input type="text" id="email_pessoal" name="email_profissional" required pattern="[a-zA-Z]+@[a-zA-Z]+\.[a-zA-z]+" autocomplete="off" />
							</label>
    						<small class="error">E-mail Pessoal é um campo obrigatório.</small> 
                                                       
							 <label for="email"> Email Profissional: 
                                                                <input type="text" id="email_profissional" name="email_profissional" required pattern="[a-zA-Z]+@[a-zA-Z]+\.[a-zA-z]+" autocomplete="off" />
                                                        </label>

							<label for="cargo">Cargo: <span style="color: red;">*</span> 
								<select name="cargo" id="cargo" required>
									<option value="trainee">Trainee</option>
									<option value="diretor">Diretor</option>
									<option value="membro">Membro</option>
								</select>
							</label>
    						<small class="error">Cargo é um campo obrigatório.</small>

							<label for="diretoria">Diretoria:
								<?php
 require_once("connect/testmysql_p.php");

  $diretorias = "SELECT id_diretoria, nome_diretoria FROM diretorias";
        $select_diretorias = mysqli_query($conn, $diretorias);
                        while ($row = mysqli_fetch_assoc($select_diretorias)) {
                                                                            echo "<tr>".
                                                                                        "<td>".$row['id_diretoria']."</td>".
                                                                                        "<td>".$row['nome_diretoria']."</td>".
                                                                                        "<td class='text-center'><i class='fi-zoom-in'></td>".
                                                                                        "<td class='text-center'><i class='fi-page-edit'></i></td>".
                                                                                        "<td class='text-center'><i class='fi-x'></td>".
                                                                                "</tr>";
                                                                        }
		
							//	echo '<select name="diretoria" id="diretoria">';
		//					 		while ($row = mysqli_fetch_assoc($select_diretorias)) {
                                                                           /* echo "<tr>".
                                                                                        "<td>".$row['id_diretoria']."</td>".
                                                                                        "<td>".$row['nome_diretoria']."</td>".
                                                                                        "<td class='text-center'><i class='fi-zoom-in'></td>".
                                                                                        "<td class='text-center'><i class='fi-page-edit'></i></td>".
                                                                                        "<td class='text-center'><i class='fi-x'></td>".
                                                                                "</tr>";*/

									// echo "<option value='0'>".$row['nome_diretoria']."</option>";
									//	echo '<option value="'.$row['id_diretoria'].'" >'.$row['nome_diretoria'].'</option>';
								//	echo "$row[id_diretoria], $row[id_diretoria]";

								//	}
							//	echo '</select>'; 
								?>
									<!-- puxar opções do banco e adicionar linha null-->
								<!--	<option value="financeiro">Financeiro</option>
									<option value="marketing">Marketing</option>
									<option value="presidencia">Presidência</option>
									<option value="projetos">Projetos</option>
									<option value="rh">Recursos Humanos</option>
								-->
							</label>

							<hr>

							<label for="matricula"> Número de matrícula: <span style="color: red;">*</span> 
								<input type="text" name="matricula" id="matricula" required pattern="11[0-9]{10}" autocomplete="off"/>
    						<small class="error">Número de matrícula é um campo obrigatório.</small>
							</label>

							<label for="passw"> Senha: <span style="color: red;">*</span> 
								<input type="password" name="passw" id="passw" required/> 
							</label>
    						<small class="error">Senha é um campo obrigatório.</small>

							<label for="confirm_passw"> Confirmar senha: <span style="color: red;">*</span> 
								<input type="password" name="confirm_passw" id="confirm_passw" required /> 
							</label>
    						<small class="error">As senhas devem ser iguais.</small>
						</div>
					</div>

					<br>
					<div class="row">
						<div class="large-12 columns text-center">
							<button type="submit" id="cadastrar" class="small round button">Cadastrar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>

	<script src="../js/vendor/modernizr.js"></script>
	<script src="../js/vendor/jquery.js"></script>
	<script src="../js/foundation/foundation.js"></script>
	<script src="../js/foundation/foundation.topbar.js"></script>
	<script type="text/javascript">
		$(document).foundation();

		$('.close').click(function() {
			$(this).parent().fadeOut(500);
		});
	</script>
</body>
</html>
