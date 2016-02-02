<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Relatório de Presença Pessoal</title>
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
			<div class="panel">
				<h3 class="text-center">Relatório de Presença Pessoal</h3>
				<br>
				<div class="row">
					<div class="large-8 medium-10 large-push-2 medium-push-1 columns">
						<form>
							<div class="text-center">
								<h4>Gabriela Brant Alves</h4>
								<h5>2013062901</h5>
							</div>
							<br>

							<div class="row">
								<div class="large-4 columns">
									<label> Data início: </label> <input type="text" id="data_inicio" placeholder="DD/MM/AAAA"/>
								</div>

								<div class="large-4 columns">
									<label> Data fim: </label> <input type="text" id="data_fim" placeholder="DD/MM/AAAA"/>
								</div>

								<div class="large-4 columns ">
									<br>
									<a href="#" class="tiny button">Atualizar </a>
								</div>
							</div>

							<br>
							<div class="row">
								<div class="large-12 columns text-center">
									<a href="#" class="small round button">Imprimir relatório </a>
								</div>
							</div>

							<br>
							<img src="../img/pareto_chart.jpg">
							<br><br>

							<table class="large-12 small-12 columns">
								<thead>
									<tr>
										<th>Dia</th>
										<th>Horário Entrada</th>
										<th>Horário Saída</th>
										<th>Horas</th>
										<th>Tipo</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-center">04/11/2015</td>
										<td class="text-center">16:00</td>
										<td class="text-center">17:00</td>
										<td class="text-center">1:00</td>
										<td class="text-center">Presencial</td>
									</tr>
									<tr>
										<td class="text-center">03/11/2015</td>
										<td class="text-center">13:10</td>
										<td class="text-center">15:00</td>
										<td class="text-center">1:50</td>
										<td class="text-center">Capacitação JavaScript</td>
									</tr>
									<tr>
										<td class="text-center">01/11/2015</td>
										<td class="text-center">16:00</td>
										<td class="text-center">17:00</td>
										<td class="text-center">1:00</td>
										<td class="text-center">Presencial</td>
									</tr>
								</tbody>
							</table>

							<div class="row">
								<div class="large-12 columns text-center">
									<a href="#" class="small round button">Imprimir relatório </a>
								</div>
							</div>

						</div>
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
	</script>
</body>
</html>
