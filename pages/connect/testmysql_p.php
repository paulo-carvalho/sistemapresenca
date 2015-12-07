<?php
    $hostname = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "sistema_presenca";
 
    $con = mysqli_connect("$hostname", "$username", "$password", "$database") or die(mysqli_connect_errno());
    //echo "Conexão efectuada com sucesso!<br/>";
    //echo "Base de dados seleccionada!<br/>";

	//$result = mysqli_query($con, 'SELECT * FROM usuario');
	
	/*
	if (!$result) {
	    $message  = 'Invalid query: ' . mysql_error() . "\n";
	    $message .= 'Whole query: ' . $query;
    	die($message);
	}
	*/

	/*
	while ($row = mysqli_fetch_assoc($result)) {
	    echo $row['matr'];
	    echo $row['nome'];
	    echo $row['email'];
	    echo $row['cargo'];
	}
	*/
?>
