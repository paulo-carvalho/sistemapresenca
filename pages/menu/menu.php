<?php
	if(isset($_SESSION['matricula'])) {
    	$matricula_sessao = $_SESSION['matricula'];
	}

	//Seleciona a permissão do usuário logado
	$sql_controle = "SELECT permissao FROM usuarios WHERE matr=$matricula_sessao;";
	if (isset($sql_controle)) {
		$controle = mysqli_query($conn, $sql_controle);
	}
	//Armazena o resultado da query acima no array permissao_sessao.
	//O valor fica armazenado na posição permissao_sessao[0]
	$permissao_sessao = mysqli_fetch_row($controle);
	
	if($permissao_sessao[0] == 3) { //Se o usuário for pós-júnior, não tem acesso ao sistema
		header("Location: ../index.php");
	} 
?>

<!-- MENU -->
	<nav class="top-bar" data-topbar role="navigation">
		<ul class="title-area">
			<li class="name logo">
				<a href="home.php"><img src="../img/logomenu.png"></a>
			</li>
			<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
			<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
		</ul>
		<section class="top-bar-section">
			<!-- Right Nav Section -->
			<ul class="right">
				<li><a href="home.php">Home</a></li>
				<li class="has-dropdown">
					<a href="#">Usuário</a>
					<ul class="dropdown">
						<li><a href="editar_usuario.php">Editar Perfil</a></li>
						<?php
							if($permissao_sessao[0] == 1) {
						?>
							<li><a href="cadastrar_usuario.php">Cadastrar</a></li>
						<?php
							}
						?>
						<li><a href="listar_usuarios.php">Listar</a></li>						
					</ul>
				</li>
				<li class="has-dropdown">
					<a href="#">Horários</a>
					<ul class="dropdown">
						<li><a href="horarios_usuario.php">Presenciais Fixos </a></li>
						<li><a href="lancar_horas.php">Não Presenciais</a></li>
					</ul>
				</li>
				<li class="has-dropdown">
					<a href="#">Relatório</a>
					<ul class="dropdown">
						<li><a href="relatorio_pessoal.php">Pessoal</a></li>
						<?php
							if($permissao_sessao[0] == 1) {
						?>
							<li><a href="relatorio_geral.php">Geral</a></li>
						<?php
							}
						?>								
					</ul>
				</li>
				<li><a href="logout.php">Sair</a></li>
			</ul>
			<!-- Left Nav Section -->
			<ul class="left">
			</ul>
		</section>
	</nav>
