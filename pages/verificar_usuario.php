<?php
// Fonte: https://gist.githubusercontent.com/TiuTalk/4951b195d2d842458b4f/raw/bd627917a50d8e1b170622b505d89331dd215e22/valida.php
// Inclui o arquivo com o sistema de segurança
// require_once("seguranca.php");

// Verifica se um formulário foi enviado
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Salva duas variáveis com o que foi digitado no formulário
    // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
    $matricula = (isset($_POST['matricula'])) ? $_POST['matricula'] : '';
    $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';

    var_dump ($matricula);
    // O usuário e a senha digitados foram validados, manda pra página interna
    header("Location: pages/home.php");
// }
?>
