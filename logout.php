<?php
    //retoma a sessão existente
    session_start();

    // Verifica se o 'cliente_id' está definido na sessão
    if (isset($_SESSION['cliente_id'])){
        // A função 'session_unset()' limpa todas as variáveis de sessão
        // Isso é útil para quando você quer limpar todas as variáveis de sessão, mas não quer destruir a sessão em si
        session_unset();

        // A função 'session_destroy()' destrói todas as informações registradas de uma sessão
        // Isso é útil quando você quer terminar completamente a sessão
        session_destroy();

        // 'headers_sent()' verifica se os cabeçalhos HTTP já foram enviados para o cliente
        // Isso é útil porque a função 'header()' deve ser chamada antes de qualquer saída real ser enviada
        if (!headers_sent()) {
            // Redireciona o usuário para 'index.php'
            header('location: index.php');
            // A função 'exit' termina a execução do script
            // Isso é útil para garantir que nenhum código adicional seja executado após o redirecionamento
            exit;
        } else {
            // Se a saída já tiver começado, uma mensagem de erro é exibida
            echo "Não foi possível redirecionar, a saída já começou!";
        }
    }

    //Redireciona o usuário, pois ele não está logado
    else{
        if (!headers_sent()) {
            // Redireciona o usuário para 'index.php'
            header('location: index.php');
            // A função 'exit' termina a execução do script
            // Isso é útil para garantir que nenhum código adicional seja executado após o redirecionamento
            exit;
        } else {
            // Se a saída já tiver começado, uma mensagem de erro é exibida
            echo "Não foi possível redirecionar, a saída já começou!";
        }
    }
?>
