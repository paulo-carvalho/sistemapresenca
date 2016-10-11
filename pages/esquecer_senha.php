<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once("connect/testmysql_p.php");

    $to = (isset($_POST['email'])) ? $_POST['email'] : '';
    $novaSenha = geraSenha(15, true, true, true);

    if($to != "") {
        $stmt = $conn->prepare("SELECT matr FROM usuarios WHERE email_pessoal=? OR email_profissional=? LIMIT 1;");
    	// definir dependencias da query preparada
    	$stmt->bind_param("ss", $to, $to);
    	$stmt->execute();
        $stmt->bind_result($temp_matr);
    	$stmt->fetch();
        $stmt->close();

        $editar = $conn->prepare("UPDATE usuarios SET senha=? WHERE matr=? LIMIT 1;");
        $editar->bind_param("ss", hash("sha256", $novaSenha), $temp_matr);
        $editar->execute();
        $editar->close();
        unset($temp_matr);

     	$conn->close();

        $subject = '[Sistema de Presença] Recuperar Senha';
        $message = "Sua nova senha é ".$novaSenha."\n".
            "Entre com a credencial acima e, em 'Editar Perfil', faça a alteração da sua senha.";

        $headers = 'From: rh@ijunior.com.br' . "\r\n" .
        'Reply-To: rh@ijunior.com.br' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        // para testar a funcao mail, o codigo deve ser enviado ao servidor
        mail($to, $subject, $message, $headers);
        unset($novaSenha);
    }
}
/**
* Função para gerar senhas aleatórias
*
* @author    Thiago Belem <contato@thiagobelem.net>
*
* @param integer $tamanho Tamanho da senha a ser gerada
* @param boolean $maiusculas Se terá letras maiúsculas
* @param boolean $numeros Se terá números
* @param boolean $simbolos Se terá símbolos
*
* @return string A senha gerada
*/
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';

    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;
    if ($simbolos) $caracteres .= $simb;

    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand-1];
    }
    return $retorno;
}
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Controle de Presença</title>
    <link rel="stylesheet" href="../css/foundation.css" />
    <script src="../js/vendor/modernizr.js"></script>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <link rel="icon" href="../favicon.ico" type="image/x-icon" />
  </head>
  <body>
    <br>
    <div class="row">
      <div class="large-4 medium-6 small-12 large-push-4 medium-push-3 columns">
        <center><a href="../index.php"><img src="../img/logo.png"></a></center>
      </div>
    </div>
    <br>

    <div class="row">
      <div class="large-4 medium-6 small-12 large-push-4 medium-push-3 columns">
        <div class="panel">
          <h3 class="text-center">Recuperar Senha</h3>
          <br>
          <div class="row">
            <div class="large-12 medium-12 small-12 columns text-center">
            <form name="esqueciSenha" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
              <label> Email: <input type="text" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" tabindex="1" /> </label>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="large-12 medium-12 small-12 columns text-center">
                <button class="small round button" name="Enviar" type="submit">Enviar</button>
            </div>
          </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
