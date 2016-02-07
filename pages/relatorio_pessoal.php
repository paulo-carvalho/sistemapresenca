<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	session_start();

	$stmt = $conn->prepare("SELECT `nome` FROM `usuarios` WHERE `matr`=?");
	// definir dependencias da query preparada
	$stmt->bind_param("s", $_SESSION['matricula']);
	$stmt->execute();

	$stmt->bind_result($nomeUsuario);
	$stmt->fetch();

	$stmt->close();
 	$conn->close();
?>
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
								<h4><?php echo $nomeUsuario; ?></h4>
								<h5><?php echo $_SESSION['matricula'];?></h5>
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
							<div class="row">
								<div class="large-12 columns">
									<div id="chart_div"></div>
								</div>
							</div>
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
	<!-- Scripts para carregar foundation -->
	<script src="../js/vendor/modernizr.js"></script>
	<script src="../js/vendor/jquery.js"></script>
	<script src="../js/foundation/foundation.js"></script>
	<script src="../js/foundation/foundation.topbar.js"></script>
	<!-- Carrega AJAX API para Google Charts-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		$(document).foundation();

		// Load the Visualization API and the piechart package.
		google.charts.load('current', {packages: ['corechart'], 'language': 'pt-br'});

		// Set a callback to run when the Google Visualization API is loaded.
		google.charts.setOnLoadCallback(drawChart);

		// Callback that creates and populates a data table,
		// instantiates the pie chart, passes in the data and
		// draws it.
		function drawChart() {
			// Create the data table.
			var data = google.visualization.arrayToDataTable([
				['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
				['2004/05',  165,      938,         522,             998,           450,      614.6],
				['2005/06',  135,      1120,        599,             1268,          288,      682],
				['2006/07',  157,      1167,        587,             807,           397,      623],
				['2007/08',  139,      1110,        615,             968,           215,      609.4],
				['2008/09',  136,      691,         629,             1026,          366,      569.6]
			]);

			// Set chart options
			var options = {
				title : 'Relatório de Presença Pessoal',
				vAxis: {title: 'Horas Acumuladas'},
				hAxis: {title: 'Semanas'},
				seriesType: 'bars',
				series: {5: {type: 'line'}}, // A quinta coluna da tabela de dados é gráfico de linha
				height: '500'
			};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
    </script>

</body>
</html>
