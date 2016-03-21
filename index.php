<!doctype html>
<?php
// variavel booleana para verificar se o usuario informou senha de forma incorreta
$senha_incorreta = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once("pages/connect/testmysql_p.php");

    // Salva duas variáveis com o que foi digitado no formulário
    // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
    $matricula = (isset($_POST['matricula'])) ? $_POST['matricula'] : '';
    $senha = (isset($_POST['senha'])) ? hash("sha256", $_POST['senha']) : '';

	// preparar query
	$stmt = $conn->prepare("SELECT `senha` FROM `usuarios` WHERE `matr`=? LIMIT 1");
	// definir dependencias da query preparada
	$stmt->bind_param("s", $matricula);
	$stmt->execute();

	$stmt->bind_result($verificador);
	$stmt->fetch();

	if($verificador == $senha) {
		session_start();
		$_SESSION['matricula'] = $matricula;
    	header("Location: pages/home.php");
	} else {
		$senha_incorreta = 1;
	}

	$stmt->close();
 	$conn->close();
}
?>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Controle de Presença</title>
	<link rel="stylesheet" href="css/foundation.css" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
	<br>
	<div class="row">
		<div class="large-4 medium-4 small-12 push-4 columns ">
			<center><a href="<?php echo $_SERVER['PHP_SELF'];?>"><img src="img/logo.png"></a></center>
		</div>
	</div>
	<br>

<?php
	if($senha_incorreta == 1) {
?>
	<div class="row">
		<div class="large-8 medium-8 small-12 large-push-2 medium-push-2 alert-box alert">
			Credenciais incorretas! Informe sua matrícula e senha novamente.
			<a href="" class="close">&times;</a>
		</div>
	</div>

<?php
	}
?>

	<div class="row">
		<div class="large-6 medium-6 small-12 push-3 columns">
			<div class="panel">
				<h3 class="text-center">Login </h3>
				<br>
				<div class="row">
					<div class="large-8 medium-8 small-12 push-2 columns text-center">
						<form name="credenciamento" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
							<label> Matrícula: <input type="text" pattern="[0-9]{10}" tabindex="1" name="matricula" /> </label>
							<label> Senha: <input type="password" tabindex="2" name="senha"/> </label>
						</div>
					</div>
					<div class="row">
						<div class="large-6 medium-6 small-12 push-6 columns text-right">
							<a href="pages/esquecer_senha.php" style="font-size:11px">Esqueceu sua senha?</a>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="large-12 medium-12 small-12 columns text-center">
							<button class="small round button" name="Enviar" type="submit">Enviar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="large-12 columns">
			<p class="text-center">&copy; 2016 UFMG Informática Júnior.</p>
		</div>
	</div>

</body>
	<script src="js/vendor/modernizr.js"></script>
	<script src="js/vendor/jquery.js"></script>
	<script src="js/foundation/foundation.js"></script>
	<script src="js/foundation/foundation.topbar.js"></script>
	<script type="text/javascript">
		$(document).foundation();
	</script>
</html>
