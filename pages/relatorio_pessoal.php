<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	session_start();

	// redirecionar para a pagina de login caso não esteja logado
	if(!isset($_SESSION['matricula']))
    	header("Location: ../index.php");

	$relatorioDataInicio = ''; //para nao dar falha ao primeiro acesso da pagina
	$relatorioDataFim = ''; //para nao dar falha ao primeiro acesso da pagina

// FILTRAR PERIODO DE CONSULTA PARA O RELATORIO DE HORAS DE TRABALHO ---
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$relatorioDataInicio = (isset($_POST['relatorioDataInicio'])) ? $_POST['relatorioDataInicio'] : '';
		$relatorioDataFim = (isset($_POST['relatorioDataFim'])) ? $_POST['relatorioDataFim'] : '';

		// caso o botão de atualizar seja acionado com campos vazios
		if($relatorioDataFim == '') {
			$dataFimFormatada = new DateTime();
			$dataFimFormatada = $dataFimFormatada->format('Y-m-d');
		} else {
			$arrDataFim = explode('/', $relatorioDataFim);
			$dataFimFormatada = $arrDataFim[2].'-'.$arrDataFim[1].'-'.$arrDataFim[0];
		}
		if($relatorioDataInicio == '') {
			$dataInicioFormatada = '2016-01-01';
		} else {
			$arrDataFim = explode('/', $relatorioDataInicio);
			$dataInicioFormatada = $arrDataFim[2].'-'.$arrDataFim[1].'-'.$arrDataFim[0];
		}

		//montando esqueleto da sentenca
		$stmt = $conn->prepare("SELECT `data`, `entrada` FROM `presenca` WHERE `matr`=? AND `data` BETWEEN ? AND ?;");
		$stmt->bind_param("sss", $matricula, $dataInicioFormatada, $dataFimFormatada);

	} else {
		// ELSE: listar todas as presencas do usuario
		//montando esqueleto da sentenca
		$stmt = $conn->prepare("SELECT `data`, `entrada` FROM `presenca` WHERE `matr`=?;");
		// definir dependencias da query preparada
		$stmt->bind_param("s", $matricula);
	}

	// definindo parametro comum e executando a query
	$matricula = $_SESSION['matricula'];
	$stmt->execute();

	// matriz que recebe informacoes da presenca do usuario
	$presenca = array("data" => array(),
					"entrada" => array());
	// alinhar variaveis de resultados com ordem
	$stmt->bind_result($presenca_data, $presenca_entrada);

	// variaveis usadas para realizar operacoes dos intervalos de presenca
	$data_inicio = new DateTime();
	$data_fim = new DateTime();

	// para armazenar todos os intervalos de tempo da matricula que "bateu ponto"
	$presenca_matricula = array("horarioEntrada" => array(),
								"horarioSaida" => array(),
								"permanencia" => array(),
								"tipo" => array());

	// variavel que realiza a soma das horas contaveis (presenca, evento, reuniao geral)
	$soma_presenca = new DateTime('0000-00-00 00:00:00');

	// definindo valores por linha encontrada no select
	for($i=0; $stmt->fetch(); $i++) {
	    array_push($presenca['data'], $presenca_data);
	    array_push($presenca['entrada'], $presenca_entrada);

		$data_fim = new DateTime($presenca['data'][$i]);
		// se nao for a primeira linha de result E nos intervalos entrada-saida, e nao saida-entrada
		if($i > 0 && ($presenca['entrada'][$i-1] - $presenca['entrada'][$i]) == 1) {
			array_push($presenca_matricula['permanencia'], date_diff($data_inicio, $data_fim)->format('%H:%I:%S'));
			$soma_presenca->add(date_diff($data_inicio, $data_fim));
	    	array_push($presenca_matricula['tipo'], "Presencial");
		}
		// linhas pares: membro bate ponto para entrar. Linhas impares: membro bate ponto para sair.
		if($i % 2 == 0)
			array_push($presenca_matricula['horarioEntrada'], $data_fim);
		else
			array_push($presenca_matricula['horarioSaida'], $data_fim);

		$data_inicio = clone $data_fim;
	}

	var_dump($soma_presenca);

	// Caso especial tratado: caso o usuario AINDA esta na empresa
	if(count($presenca_matricula['horarioEntrada']) > count($presenca_matricula['horarioSaida']))
		array_pop($presenca_matricula['horarioEntrada']);

// LISTAR HORARIOS DE EVENTO ---
	$stmt = $conn->prepare("SELECT `nome_evento`, `data_inicio`, `data_fim` FROM `evento` WHERE `matr`=?");
	// definir dependencias da query preparada
	$stmt->bind_param("s", $matricula);
	$stmt->execute();

	$stmt->bind_result($nomeEvento, $inicioEvento, $fimEvento);
	for($i=0; $stmt->fetch(); $i++) {
		$data_inicio = new DateTime($inicioEvento);
		$data_fim = new DateTime($fimEvento);

		array_push($presenca_matricula['horarioEntrada'], $data_inicio);
		array_push($presenca_matricula['horarioSaida'], $data_fim);
		array_push($presenca_matricula['permanencia'], date_diff($data_inicio, $data_fim)->format('%H:%I:%S'));
	    array_push($presenca_matricula['tipo'], $nomeEvento);
	}

// LISTAR PRESENCA EM REUNIÃO GERAL ---
	$stmt = $conn->prepare(
		"SELECT `data_inicio`, `data_fim` FROM `reuniao_geral` AS rg INNER JOIN
		`presenca_reuniao` AS pr ON rg.`id_reuniao`=pr.`id_reuniao` WHERE pr.`matr`=?");
	// definir dependencias da query preparada
	$stmt->bind_param("s", $matricula);
	$stmt->execute();

	$stmt->bind_result($inicioReuniao, $fimReuniao);
	for($i=0; $stmt->fetch(); $i++) {
		$data_inicio = new DateTime($inicioReuniao);
		$data_fim = new DateTime($fimReuniao);

		array_push($presenca_matricula['horarioEntrada'], $data_inicio);
		array_push($presenca_matricula['horarioSaida'], $data_fim);
		array_push($presenca_matricula['permanencia'], date_diff($data_inicio, $data_fim)->format('%H:%I:%S'));
	    array_push($presenca_matricula['tipo'], 'Reunião Geral');
	}

// RECONHECER NOME DE USUARIO
	$stmt = $conn->prepare("SELECT `nome` FROM `usuarios` WHERE `matr`=?");
	// definir dependencias da query preparada
	$stmt->bind_param("s", $matricula);
	$stmt->execute();

	$stmt->bind_result($nomeUsuario);
	$stmt->fetch();

	$stmt->close();
?>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Relatório de Presença Pessoal</title>
	<!-- Foundation CSS -->
	<link rel="stylesheet" href="../css/foundation.css" />
	<!-- Foundation Icons CSS -->
    <link rel="stylesheet" href="../foundation-icons/foundation-icons.css" />
	<!-- Foundation-datepicker CSS -->
	<link rel="stylesheet" href="../css/foundation-datepicker.min.css" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>

<body>
	<?php
		require_once("menu/menu.php");
	?>

	<br>

	<div class="row">
		<div class="large-12 medium-10 large-push-0 medium-push-1 columns">
			<div class="panel">
				<h3 class="text-center">Relatório de Presença Pessoal</h3>
				<br>
				<div class="row">
					<div class="large-8 medium-10 large-push-2 medium-push-1 columns">
						<div class="text-center">
							<h4><?php echo $nomeUsuario; ?></h4>
							<h5><?php echo $_SESSION['matricula'];?></h5>
						</div>
						<br>

						<div class="row">
						<form name="periodoRelatorio" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
							<?php
								$arrInicio = explode("-" ,$relatorioDataInicio);
								$arrFim = explode("-" ,$relatorioDataFim);
							?>
							<div class="large-4 columns">
								<label> Data início: </label>
								<input type="text" id="relatorioDataInicio" name="relatorioDataInicio"
								placeholder="DD/MM/AAAA" class="fdatepicker" autocomplete="off"
								value="<?php echo isset($relatorioDataInicio) ? $relatorioDataInicio : ''; ?>" />
							</div>

							<div class="large-4 columns">
								<label> Data fim: </label>
								<input type="text" id="relatorioDataFim" name="relatorioDataFim"
								placeholder="DD/MM/AAAA" class="fdatepicker" autocomplete="off"
								value="<?php echo isset($relatorioDataFim) ? $relatorioDataFim : ''; ?>" />
							</div>

							<div class="large-4 columns">
								<br>
								<button class="tiny button" name="Atualizar" type="submit">Atualizar</button>
							</div>
						</form>
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
								<div id="grafico">Gerando gráfico, aguarde...</div>
							</div>
						</div>

						<br><br>

						<table class="large-12 small-12 columns">
							<thead>
								<tr>
									<th class="text-center">Horário Entrada</th>
									<th class="text-center">Horário Saída</th>
									<th class="text-center">Permanência</th>
									<th class="text-center">Tipo</th>
								</tr>
							</thead>
							<tbody>
							<?php
								for($i=0; $i < count($presenca_matricula['permanencia']); $i++) {
							?>
								<tr>
									<td class="text-center"><?php echo $presenca_matricula['horarioEntrada'][$i]->format('d/m/Y H:i:s'); ?></td>
									<td class="text-center"><?php echo $presenca_matricula['horarioSaida'][$i]->format('d/m/Y H:i:s');; ?></td>
									<td class="text-center"><?php echo $presenca_matricula['permanencia'][$i]; ?></td>
									<td class="text-center"><?php echo $presenca_matricula['tipo'][$i]; ?></td>
								</tr>
							<?php
								}
							?>
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
	<script type="text/javascript">
		$(document).foundation();
	</script>
	<!-- Datepicker para campos com data. Repositorio: https://github.com/najlepsiwebdesigner/foundation-datepicker -->
	<script src="../js/foundation-datepicker/foundation-datepicker.min.js"></script>
	<script src="../js/foundation-datepicker/locales/foundation-datepicker.pt-br.js"></script>
	<script type="text/javascript">
	$('.fdatepicker').fdatepicker({
		language: 'pt-br', //versao brasileira de foundation-datepicker
		format: 'dd/mm/yyyy'
	});
	</script>
	<!-- Carrega AJAX API para Google Charts-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">

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
				['Semanas', 'Horas de Presença', 'Média'],
				['31/01/2016',  165,	614.6],
				['07/02/2016',  135,      682],
				['14/02/2016',  157,      623]
			]);

			// Set chart options
			var options = {
				title : 'Relatório de Presença Pessoal',
				vAxis: {title: 'Horas Acumuladas'},
				hAxis: {title: 'Semanas'},
				seriesType: 'bars',
				series: {1: {type: 'line'}}, // A quinta coluna da tabela de dados é gráfico de linha
				height: '500'
			};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.ComboChart(document.getElementById('grafico'));
			chart.draw(data, options);
		}
    </script>
</body>
<?php
	$conn->close();
?>
</html>
