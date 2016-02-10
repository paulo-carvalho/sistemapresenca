<?php

	echo "Encerrando sessão. Aguarde...";

	session_start();
	session_destroy();

	header("Location: ../index.php");

?>