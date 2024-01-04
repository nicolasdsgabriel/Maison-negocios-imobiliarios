<?php
    /**
     * O que falta fazer nesta página:
     * Verificar cada linha
     * Possibilidade de verificar se o cliente quer receber receber ligações sobre o imovel;
     * Possibilidade do Usuário excluir sua conta;
     * O usuário pode remover itens da sua lista de desejo;
     */

    // Inicia a sessão
    session_start();

    // Inclui a classe Cliente
    require_once("CLASSES/Classe.Cliente.php");

    // Cria uma nova instância da classe Cliente
    $requerindo_classe = new Cliente("maison2","localhost","root","11153025192Fd@");

    // Verifica se o usuário está logado e não é um administrador
    if (isset($_SESSION['cliente_id']) && (isset($_SESSION['cliente_adm'])) && ($_SESSION['cliente_adm'] == 0)){
        // Lista os imóveis desejados do usuário
        $listagem_dos_imoveis_desejados = $requerindo_classe->listarDesejos();

        echo "Lista de todos os usuários";
        echo "<pre>";
        var_dump($listagem_dos_imoveis_desejados);
        echo "</pre>";

        $listagem_dos_imoveis = $requerindo_classe->listarDesejosUnicoUsuario($_SESSION['cliente_id']);
        echo "<br><br>lista do usuário<br>";
        echo "<pre>";
        var_dump($listagem_dos_imoveis);
        echo "</pre>";
    }
    // Verifica se o usuário é um administrador
    else if ((isset($_SESSION['cliente_adm'])) && ($_SESSION['cliente_adm'] == 1)) {
        // Redireciona para a pasta ADM
        header('location: ADM');
        exit(); // Fecha a área do cliente
    }
    // Verifica se o usuário não está logado
    else if (!isset($_SESSION['cliente_adm'])){
        // Exibe uma mensagem de erro amigável
        echo "Você precisa estar logado para acessar esta página.";
        // Redireciona para a página de login
        header('location: login.php');
        exit();
    }
?>
