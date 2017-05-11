<!doctype html>
<?php
	require_once("connect/testmysql_p.php");

	session_start();

	date_default_timezone_set('America/Sao_Paulo');

	// redirecionar para a pagina de login caso não esteja logado
	if(!isset($_SESSION['matricula']))
    	header("Location: ../index.php");

	$mesReferencia = ''; //para nao dar falha ao primeiro acesso da pagina

	// para armazenar todos os intervalos de tempo da matricula que "bateu ponto"
	$usuario = array("horarioEntrada" => array(),
						"horarioSaida" => array(),
						"permanencia" => array());

	// matriz que recebe informacoes da presenca do usuario
	$presenca = array("data" => array(),
					"entrada" => array());

	// variaveis usadas para realizar operacoes dos intervalos de presenca
	$data_inicio = new DateTime();
	$data_fim = new DateTime();




// FILTRAR PERIODO DE CONSULTA PARA O RELATORIO DE HORAS DE TRABALHO ---
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['mesReferencia'] != "") {
		$mesReferencia = $_POST['mesReferencia'];

		// botao atualizar acionado com parametro imposto
		$mesReferenciaFragmentado = explode('/', $mesReferencia);
		$paramMesReferenciaInicio = $mesReferenciaFragmentado[1].'-'.$mesReferenciaFragmentado[0]."-01";
		$paramMesReferenciaFim = $mesReferenciaFragmentado[1].'-'.($mesReferenciaFragmentado[0]+1)."-01";

		//montando esqueleto da sentenca
		$stmt = $conn->prepare("SELECT P.data, P.entrada FROM presenca P WHERE P.matr=? AND P.data BETWEEN ? AND ? ORDER BY P.data DESC;");
		$stmt->bind_param("sss", $matricula,  $paramMesReferenciaInicio, $paramMesReferenciaFim);

	} else {
		// ELSE: listar todas as presencas do usuario
		//montando esqueleto da sentenca
		$stmt = $conn->prepare("SELECT P.data, P.entrada FROM presenca P WHERE P.matr=? ORDER BY P.data DESC;");
		// definir dependencias da query preparada
		$stmt->bind_param("s", $matricula);
	}

	// definindo parametro comum e executando a query
	$matricula = $_SESSION['matricula'];
	$stmt->execute();
	// alinhar variaveis de resultados com ordem
	$stmt->bind_result($data, $entrada);

	// definindo valores por linha encontrada no select
	$k=0;
	for($i=0; $stmt->fetch(); $i++) {
	    array_push($presenca['data'], $data);
	    array_push($presenca['entrada'], $entrada);
	
		if($presenca['entrada'][$i] == 1) {
			$data_inicio = new DateTime($presenca['data'][$i]);
			for ($j=$i-1; $j>0; $j--) {
				$data_fim = new DateTime($presenca['data'][$j]);
				$j=-1;
			}
		
			$permanencia = date_diff($data_fim,$data_inicio)->format('%H:%I:%S');

			$usuario['horario_entrada'][$k] = $data_inicio;
			$usuario['horario_saida'][$k] = $data_fim;
			$usuario['permanencia'][$k] = $permanencia;			
			$k++;
		}	
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
								$arrInicio = explode("-" ,$mesReferencia);
							?>
							<div class="large-4 large-push-3 medium-4 medium-push-2 small-6 small-push-1 columns">
								<label> Mês/Ano de Referência:
									<input type="text" id="mesReferencia"
									name="mesReferencia" placeholder="MM/AAAA"
									class="fdatepicker" autocomplete="off"
									pattern="[0-9]{2}/[0-9]{4}"
									value="<?php echo isset($mesReferencia) ? $mesReferencia : ''; ?>" />
								</label>
							</div>

							<div class="large-4 large-pull-1 medium-4 medium-pull-2 small-5 columns">
								<br>
								<button class="tiny button" name="Atualizar" type="submit">Atualizar</button>
							</div>
						</form>
						</div>

						

						<!-- <div class="row">
							<div class="large-12 columns">
								<div id="grafico">Gerando gráfico, aguarde...</div>
							</div>
						</div> -->

						

						<table class="large-12 small-12 columns">
							<thead>
								<tr>
									<th class="text-center">Horário Entrada</th>
									<th class="text-center">Horário Saída</th>
									<th class="text-center">Permanência</th>
									<!--<th class="text-center">Tipo</th>-->
								</tr>
							</thead>
							<tbody>
							<?php
								for($i=0; $i < count($usuario['permanencia']); $i++) {
							?>
								<tr>
									<td class="text-center"><?php echo $usuario['horario_entrada'][$i]->format('d/m/Y H:i:s'); ?></td>
									<td class="text-center"><?php echo $usuario['horario_saida'][$i]->format('d/m/Y H:i:s');; ?></td>
									<td class="text-center"><?php echo $usuario['permanencia'][$i]; ?></td>
									<!--<td class="text-center"><span style="text-transform: uppercase;"><?php echo $usuario['tipo'][$i]; ?></td>-->
								</tr>
							<?php
								}

								// se não foram encontrado registros, imprime mensagem
								if($i == 0)
									echo "<tr><td class='text-center' colspan='4'>Nenhum registro encontrado</td></tr>";
							?>
							</tbody>
						</table>
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
	<!-- Foundation topbar para menu no topo da pagina -->
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
			format: 'mm/yyyy',
			startView: 3,
			minView: 3
		});
	</script>
	<!-- Carrega AJAX API para Google Charts-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</body>
<?php
	$conn->close();
?>
</html>
