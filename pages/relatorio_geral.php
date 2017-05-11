<?php
	require_once("connect/testmysql_p.php");

	//VALIDA A SESSÃO
	session_start();

	if(!isset($_SESSION['matricula'])) {
    	header("Location: ../index.php");
	}
	else {
		$matricula = $_SESSION['matricula'];
	}
	
	date_default_timezone_set('America/Sao_Paulo');

	$filtro_nome = '';
	$dataRef_inicio = '';
	$dataRef_fim = '';

	//cria o array que vai armazenar os dados
	$dados_bd = array("matr" => array(), 
					"nome" => array(),
					"data" => array(),
					"entrada" => array(), 
					"data" => array());


	$usuarios = array("matr" => array(), 
					"nome" => array(), 
					"horario_entrada" => array(),
					"horario_saida" => array(),
					"permanencia" => array());

	// variaveis usadas para realizar operacoes dos intervalos de presenca
	$data_inicio = new DateTime();
	$data_fim = new DateTime();
	$data_aux = new DateTime();

	//quando algum filtro é acionado
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		if (isset($_POST['membros'])) {
			$filtro_nome=$_POST['membros'];
		}

		if ($_POST['dataRef_inicio'] != '') {
			$dataRef_inicio=$_POST['dataRef_inicio'];

			$filtro_data_inicio = explode('/', $dataRef_inicio);

			$ano_inicio = $filtro_data_inicio[2];
			$mes_inicio = $filtro_data_inicio[1];
			$dia_inicio = $filtro_data_inicio[0];

			$param_inicio = $ano_inicio.'-'.$mes_inicio.'-'.$dia_inicio;
		}

		if ($_POST['dataRef_fim'] != '') {
			$dataRef_fim=$_POST['dataRef_fim'];

			$filtro_data_fim = explode('/', $dataRef_fim);

			$ano_fim = $filtro_data_fim[2];
			$mes_fim = $filtro_data_fim[1];
			$dia_fim = $filtro_data_fim[0];

			$param_fim = $ano_fim.'-'.$mes_fim.'-'.$dia_fim;
		}

		//FILTRAR APENAS PELO NOME
		if($filtro_nome != '' && $filtro_nome != 'Todos') {
			//busca no banco a matricula correspondente a determinado nome filtrado
			$stmt = $conn->prepare("SELECT matr FROM usuarios WHERE nome=?;");
			$stmt->bind_param("s", $filtro_nome);
			$stmt->execute();
			$stmt->bind_result($matricula);

			$aux = array("matr" => array()); 

			for($i=0; $stmt->fetch(); $i++) {
				array_push($aux['matr'], $matricula);
			}

			$filtro_matr = $aux['matr'][0];

			//sem filtrar pela data
			if ($dataRef_inicio == '' && $dataRef_fim == '') {
				//echo 'FILTRA APENAS PELO NOME';
				//pega os dados do usuario filtrado
				$stmt = $conn->prepare("SELECT U.matr, U.nome, P.data, P.entrada FROM usuarios U, presenca P  where U.matr=? AND U.matr=P.matr ORDER BY data DESC;");
				$stmt->bind_param("s", $filtro_matr);
				$stmt->execute();
			}
			else {
				$stmt = $conn->prepare("SELECT U.matr, U.nome, P.data, P.entrada FROM usuarios U, presenca P  WHERE U.matr=? AND U.matr=P.matr AND DATE(data) BETWEEN ? AND ?;");
				$stmt->bind_param("sss", $filtro_matr, $param_inicio, $param_fim);
				$stmt->execute();
			}
		}

		if($filtro_nome == 'Todos') {
			if ($dataRef_inicio == '' && $dataRef_fim == '') {
				//echo 'FILTRA TODOS SEM DATA com envio de form';
				//pega os dados do usuario filtrado
				$stmt = $conn->prepare("SELECT U.matr, U.nome, P.data, P.entrada FROM usuarios U, presenca P where U.matr=? AND U.matr=P.matr ORDER BY data DESC;");
				$stmt->bind_param("s", $filtro_matr);
				$stmt->execute();
			}

			else {
				//echo 'Filtra todos COM DATA';
				$stmt = $conn->prepare("SELECT U.matr, U.nome, data, entrada FROM usuarios U, presenca P  WHERE U.matr=P.matr AND DATE(data) BETWEEN ? AND ?;");
				$stmt->bind_param("ss", $param_inicio, $param_fim);
				$stmt->execute();
			}
		}				
	}

	//página inicial, exibe todos os usuários e sua presença, em ordem decrescente de data
	if (!($_SERVER['REQUEST_METHOD'] == 'POST') || $filtro_nome == 'Todos') {
		if ($dataRef_inicio == '' && $dataRef_fim == '') {
			//echo 'FILTRA TODOS SEM DATA pag inicial';
			// Query para buscar todos os usuários do sistema
			$stmt = $conn->prepare("SELECT U.matr, U.nome, P.data, P.entrada FROM usuarios U, presenca P where U.matr=P.matr ORDER BY data DESC;");
			$stmt->execute();
			$stmt->bind_result($matr, $nome, $data, $entrada); //passa o resultado para as variaveis correspondentes

				}
	
	}

	$stmt->bind_result($matr, $nome, $data, $entrada); //passa o resultado para as variaveis correspondentes

	$k=0;
	for($i=0; $stmt->fetch(); $i++) {
		array_push($dados_bd['matr'], $matr);
		array_push($dados_bd['nome'], $nome);
		array_push($dados_bd['data'], $data);
		array_push($dados_bd['entrada'], $entrada);

		if($i >= 0 && ($dados_bd['entrada'][$i] == 1)) {
			$data_inicio = new DateTime($dados_bd['data'][$i]);
			for ($j=$i-1; $j>0; $j--) {
				if ($dados_bd['matr'][$i] == $dados_bd['matr'][$j]) {
					$data_fim = new DateTime($dados_bd['data'][$j]);
					$j=-1;;
				}
			}

			$permanencia = date_diff($data_fim,$data_inicio)->format('%H:%I:%S');

			$usuarios['matr'][$k] = $dados_bd['matr'][$i];
			$usuarios['nome'][$k] = $dados_bd['nome'][$i]; 
			$usuarios['horario_entrada'][$k] = $data_inicio;
			$usuarios['horario_saida'][$k] = $data_fim;
			$usuarios['permanencia'][$k] = $permanencia;			
			$k++;
		}
	}
?>

<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Relatório Geral</title>
		<link rel="stylesheet" href="../css/foundation-datepicker.css" />
		<link rel="stylesheet" href="../css/foundation.css" />
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
			<div class="large-12 columns">
				<div class="panel">
					<h3 class="text-center">Relatório Geral</h3>
						<br>
							<div class="row">
								<div class="large-8 medium-10 large-push-2 medium-push-1 columns">
									<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<label>Membros:
											<select name="membros">
												<option>Todos</option>
												<?php
												//MOSTRA NO SELECT OS USUARIOS PARA RELATORIO GERAL
												$sql_usuarios = "SELECT * FROM usuarios";
												if (isset($sql_usuarios)) {
													$resultado = mysqli_query($conn, $sql_usuarios);
												}
												else
													echo 'Erro na query sql_usuarios';
												while ($dados = mysqli_fetch_assoc($resultado)) {
													$nome = $dados['nome'];
													if ($nome == $filtro_nome)
														echo "<option selected>$nome</option>";
													else
														echo "<option>$nome</option>";
												}
												?>
											</select>
										</label>
										<?php
											//$arrInicio = explode("-" ,$dataRef_inicio);
										?>	
										<div class="large-6 columns text-left">
											<label> Data Início:
												<input type="text" id="dataRef_inicio"
												name="dataRef_inicio" placeholder="DD/MM/AAAA"
												class="fdatepicker" autocomplete="off"
												pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
												value="<?php echo isset($dataRef_inicio) ? $dataRef_inicio : ''; ?>" />
											</label>
										</div>
										<div class="large-6 columns text-right">
											<label> Data Fim:
												<input type="text" id="dataRef_fim"
												name="dataRef_fim" placeholder="DD/MM/AAAA"
												class="fdatepicker" autocomplete="off"
												pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
												value="<?php echo isset($dataRef_fim) ? $dataRef_fim : ''; ?>" />
											</label>
										</div>
										<div class="large-12 columns text-center">
											<button type="submit" id="cadastrar" class="small large button">Filtrar</button>
										</div>
										<table class="large-12 columns">
											<thead>
												<tr>
													<th class="text-center">Matrícula</th>
													<th class="text-center">Nome</th>
													<th class="text-center">Horário Entrada</th>
													<th class="text-center">Horário Saída</th>
													<th class="text-center">Permanência</th>
													<!--<th class="text-center">Tipo</th>-->
												</tr>
											</thead>
											<tbody>
											<?php
												for($i=0; $i < count($usuarios['permanencia']); $i++) {
											?>
												<tr>
													<td class="text-center"><?php echo $usuarios['matr'][$i];?></td>
													<td class="text-center"><?php echo $usuarios['nome'][$i];?></td>
													<td class="text-center"><?php echo $usuarios['horario_entrada'][$i]->format('d/m/Y H:i:s'); ?></td>
													<td class="text-center"><?php echo $usuarios['horario_saida'][$i]->format('d/m/Y H:i:s'); ?></td>
													<td class="text-center"><?php echo $usuarios['permanencia'][$i]; ?></td>
													<!--<td class="text-center"><span style="text-transform: uppercase;"><?php echo $usuarios['tipo'][$i]; ?></td>-->
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
								</form>
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
		<!-- Datepicker para campos com data. Repositorio: https://github.com/najlepsiwebdesigner/foundation-datepicker -->
		<script src="../js/foundation-datepicker/foundation-datepicker.js"></script>
		<script src="../js/foundation-datepicker/locales/foundation-datepicker.pt-br.js"></script>
		<!-- ... -->
		<script>
		$('.fdatepicker').fdatepicker({
			language: 'pt-br',
			format: 'dd/mm/yyyy'
		});
		</script>

	</script>
	</body>
</html>
