<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Lançamento de horas não-presenciais</title>
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
		<div class="large-8 push-2 columns">
			<div class="panel">
				<h3 class="text-center">Lançamento de horas não-presenciais</h3>
				<br>
				<div class="row">
					<div class="large-12 columns">
						<form>
							<label> Hora início: <input type="text" id="hora_inicio" placeholder="DD/MM/AAAA"/> </label>
							<label> Hora fim: <input type="text" id="hora_fim" placeholder="DD/MM/AAAA"/> </label>
							<label> Evento: <input type="text" id="evento"/> </label>
							<label> Observações: <textarea></textarea> </label>
						</div>
					</div>

					<br>
					<div class="row">
						<div class="large-12 columns text-center">
							<a href="ponto_sucesso.html" class="small round button">Lançar </a>
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
	</script>
</body>
</html>
