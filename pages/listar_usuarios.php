<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	/* QUERY */
	$sql = "SELECT `matr`, `nome` FROM `usuario` ORDER BY `cargo` ASC, `nome` ASC";

	/* DEBUG */
	//if(isset($sql))
	//	echo $sql;

	/* OPERAÇÃO DE CONSULTA */
	$msg_erro = "";
	if (isset($sql))
		if (!mysqli_query($con, $sql)) {
	  		//$msg_erro = 'Erro: ' . mysqli_error($con);
	  		$msg_erro = "Não foi possível realizar essa operação.";
		} else {
			$result = mysqli_query($con, $sql);
		}
	mysqli_close($con);
?>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Lista de usuários</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<link rel="stylesheet" href="../foundation-icons/foundation-icons.css" />
	<link rel="stylesheet" href="../foundation-icons/ foundation-icons.[eot/ttf/svg/woff]" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
	<?php
		require_once("template/menu.html");
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
			?>
			<div class="panel">
				<h3 class="text-center">Lista de usuários</h3>
				<br>
				<div class="row">

					<div class="large-8 push-2 columns">
						<table class="large-12">
							<thead>
								<tr>
									<th>Matrícula</th>
									<th>Nome</th>
									<th class="text-center">Ver</th>
									<th class="text-center">Editar</th>
									<th class="text-center">Excluir</th>

								</tr>
							</thead>
							<tbody>
								<?php
									while ($row = mysqli_fetch_assoc($result)) {
									    echo "<tr>".
											"<td>".$row['matr']."</td>".
											"<td>".$row['nome']."</td>".
											"<td class='text-center'><i class='fi-zoom-in'></td>".
											"<td class='text-center'><i class='fi-page-edit'></i></td>".
											"<td class='text-center'><i class='fi-x'></td>".
										"</tr>";
									}
								?>
							</tbody>
						</table>

					</div>
				</div>

				<br>

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
