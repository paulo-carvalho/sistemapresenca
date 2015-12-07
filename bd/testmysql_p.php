<?php
    $hostname = "127.0.0.1";    // Vamos considerar localhost ou máquina local
    $username = "root";    // Username é userTeste
    $password = "";     // Password é passTeste (Cuidado com maiúsculas e minúsculas
 
    @mysql_connect("$hostname", "$username", "$password") or die(mysql_error());
    echo "Conexão efectuada com sucesso!<br/>";
     
    mysql_select_db("sistema_presenca") or die(mysql_error());
    echo "Base de dados seleccionada!<br/>";

	$result = mysql_query('SELECT * FROM usuario');
	
	if (!$result) {
	    $message  = 'Invalid query: ' . mysql_error() . "\n";
	    $message .= 'Whole query: ' . $query;
    	die($message);
	}

	while ($row = mysql_fetch_assoc($result)) {
	    echo $row['matr'];
	    echo $row['nome'];
	    echo $row['email'];
	    echo $row['cargo'];
	}
?>
