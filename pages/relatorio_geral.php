<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Relatório Geral</title>
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
				<h3 class="text-center">Relatório Geral</h3>
				<br>
				<div class="row">

					<div class="large-8 medium-10 large-push-2 medium-push-1 columns">
						<form>
							<label>Cargo:
								<select>
									<option value="trainee">Trainee</option>
									<option value="diretor">Diretor</option>
									<option value="membro">Membro</option>
								</select>
							</label>
							<label>Setor:
								<select>
									<option value="financeiro">Financeiro</option>
									<option value="marketing">Marketing</option>
									<option value="presidencia">Presidência</option>
									<option value="projetos">Projetos</option>
									<option value="rh">Recursos Humanos</option>
								</select>
							</label>

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

							<table class="large-12 columns">
								<thead>
									<tr>
										<th>Número matrícula</th>
										<th>Nome</th>
										<th>Dia</th>
										<th>Horas</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Content Goes Here</td>
										<td>Content Goes Here</td>
										<td class="text-center">05/11/2015</td>
										<td class="text-center">4:00</td>
									</tr>
									<tr>
										<td>Content Goes Here</td>
										<td>Content Goes Here</td>
										<td class="text-center">05/11/2015</td>
										<td class="text-center">1:43</td>
									</tr>
									<tr>
										<td>Content Goes Here</td>
										<td>Content Goes Here</td>
										<td class="text-center">05/11/2015</td>
										<td class="text-center">2:10</td>
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