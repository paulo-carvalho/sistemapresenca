<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Ver usuário</title>
	<link rel="stylesheet" href="../css/foundation.css" />
	<script src="../js/vendor/modernizr.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
	<nav class="top-bar" data-topbar role="navigation">
		<ul class="title-area">
			<li class="name logo">
				<a href="index.html"><img src="../img/logomenu.png"></a>
			</li>
			<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
			<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
		</ul>
		<section class="top-bar-section">
			<!-- Right Nav Section -->
			<ul class="right">
				<li><a href="home.html">Home</a></li>
				<li class="has-dropdown">
					<a href="#">Usuário</a>
					<ul class="dropdown">
						<li><a href="cadastro.html">Cadastrar</a></li>
						<li><a href="editar_usuario.html">Editar</a></li>
						<li><a href="ver_usuario.html">Listar</a></li>
					</ul>
				</li>
				<li class="has-dropdown">
					<a href="#">Relatório</a>
					<ul class="dropdown">
						<li><a href="relatorio_pessoal.html">Pessoal</a></li>
						<li><a href="relatorio_geral.html">Geral</a></li>
					</ul>
				</li>
				<li><a href="lancar_horas.html">Lançar Horas</a></li>
				<li><a href="#">Sair</a></li>
			</ul>
			<!-- Left Nav Section -->
			<ul class="left">
			</ul>
		</section>
	</nav>

	<br>

	<div class="row">
		<div class="large-12 columns">
			<div class="panel">
				<h3 class="text-center">Ver usuário</h3>
				<br>
				<div class="row">

					<div class="large-8 push-2 columns">

						<form>
							<label> Nome Completo: <input type="text" id="name" value="Gabriela Brant Alves" disabled/> </label>
							<label> Email: <input type="text" id="email" value="gabibrantalves@gmail.com" disabled/> </label>
							<label>Cargo:
								<select disabled>
									<option value="trainee" >Trainee</option>
								</select>
							</label>
							<label>Setor:
								<select disabled>
									<option value="projetos">Projetos</option>
								</select>
							</label>
							<label> Número matrícula: <input type="text" id="matricula" value="2013062901" disabled /> </label>
							<label> Senha: <input type="password" id="passw" disabled/> </label>
							<label> Confirmar senha: <input type="password" id="confirm_passw" disabled/> </label>
						</form>
					</div>
				</div>


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
