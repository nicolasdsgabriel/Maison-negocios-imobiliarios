<?php
    /*
     * Falta:
     * Validação de formulário
     * CSS
     * O que falta nesta página:
    - Adicionar os links certos para a navbar
    - CSS em geral
    - Adicionar o sistema de codificação de senhas
    - Adicionar filtros para os inputs, onde não possar haver SQL insert
    - Adicionar validação de formulário
    - Alterar o input de adm para a versão de adm
    - Verificação de login
    - Quando registrar-se, faça o login automaticamente.
    */
    session_start();

    require_once("../BD/config.php");
    require_once("../CLASSES/Classe.Cliente.php");
    
    if(isset($_POST['button_registrar'])){// Verifica se o botão de registro foi clicado
    
        // Cria um novo objeto Cliente
        $adicionar_novo_usuario = new Cliente("maison2","localhost","root","11153025192Fd@");

        // Recupera os dados do formulário
        $nome = $_POST['nome_cliente'];
        $cpf = $_POST['cliente_cpf'];
        $email = $_POST['cliente_email']; 
        $senha = $_POST['cliente_senha'];
        $tel = $_POST['cliente_telefone'];
        $adm = $_POST['cliente_adm'];

        // Tenta registrar um novo usuário com os dados fornecidos
        if($adicionar_novo_usuario->registrar_novo_usuario($nome, $cpf, $email, $senha, $tel, $adm)){
            
            // Se o registro for bem-sucedido, exibe uma mensagem de sucesso
            $msg = "Usuário cadastrado com sucesso";
        
        }

        else{
            // Se o registro falhar (por exemplo, se o usuário já existir), exibe uma mensagem de erro
            $msg = "Usuário já cadastrado";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>ADM | editar cliente</title>
    <style>
        .nav-link {
            transition: color 0.5s ease;
        }
        .nav-link:hover {
            color: white;
            font-style: italic;
            font-weight: bold;
            background-color: #29b6f6;
        }
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    
        main {
            padding-top: 40px; /* Altura da navbar */
            padding-left: 100px; /* Largura da sua barra de navegação */
            flex: 1 0 auto;
        }
    
        footer {
            flex-shrink: 0;
        }
    </style>

</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top" style="background-color: whitesmoke;">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.html">MAISON</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                      <li class="nav-item">
                          <a class='nav-link' href='../logout.php'>Deslogar</a>
                      </li>
                      <li class="nav-item">
                          <a class='nav-link' href='ListaCliente.php'>Listar Clientes</a>
                      </li>
                      <li class="nav-item">
                          <a class='nav-link' href='editarImovel.html'>Adicionar/Editar/Excluir Imovel</a>
                      </li>
                      <li class="nav-item">
                        <a class='nav-link' href='interessados.html'>Interessados</a>
                    </li>
                    </ul>
                </div>
                <a class="nav-link" href="index.html"><img src="../IMG/logo_maison.PNG" alt="Logo da Maison" style="width: 32px; height: 32px;"></a>
            </div>
        </nav>
    </header>
    
    <!--Conteudo da página-->
    <main class="container-fluid mb-5 mt-5">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">MAISON</a></li>
                <li class="breadcrumb-item"><a href="ListaCliente.php">Listar Clientes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Adicionar Cliente</li>
            </ol>
        </div>
        
        <div>
            <?php if(isset($msg)){echo "$msg";}?>
        </div>

        <form action="" method="POST" class="form-control">
            <label for="nome_cliente">Nome do Cliente:</label>
            <input type="text" id="nome_cliente" name="nome_cliente" required>
            
            <label for="cliente_cpf">CPF do Cliente:</label>
            <input type="text" id="cliente_cpf" name="cliente_cpf" required>
            
            <label for="cliente_email">Email do Cliente:</label>
            <input type="text" id="cliente_email" name="cliente_email" required>
            
            <label for="cliente_senha">Senha do Cliente:</label>
            <input type="text" id="cliente_senha" name="cliente_senha" required>
            
            <label for="cliente_telefone">Telefone do Cliente:</label>
            <input type="text" id="cliente_telefone" name="cliente_telefone" required>
            
            <label for="cliente_adm">ADM do Cliente:</label>
            <input type="text" id="cliente_adm" name="cliente_adm" required>
            
            <input type="submit" name="button_registrar" value="ADICIONAR" required>
        </form>

    </main>
    
    <!--FOOTER DA PÁGINA-->
    <footer class="bg-light text-center text-lg-start footer">
        <div class="container p-4">
          <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
              <h5 class="text-uppercase">Sobre nós</h5>
              <p>
                Aqui você pode usar linhas e parágrafos para permitir que os usuários saibam mais sobre você.
              </p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
              <h5 class="text-uppercase">Links úteis</h5>
              <ul class="list-unstyled mb-0">
                <li>
                  <a href="#!" class="text-dark">Link 1</a>
                </li>
                <li>
                  <a href="#!" class="text-dark">Link 2</a>
                </li>
                <li>
                  <a href="#!" class="text-dark">Link 3</a>
                </li>
                <li>
                  <a href="#!" class="text-dark">Link 4</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
              <h5 class="text-uppercase mb-0">Contatos</h5>
              <ul class="list-unstyled">
                <li>
                  <a href="#!" class="text-dark">Facebook</a>
                </li>
                <li>
                  <a href="#!" class="text-dark">Twitter</a>
                </li>
                <li>
                  <a href="#!" class="text-dark">Instagram</a>
                </li>
                <li>
                  <a href="#!" class="text-dark">LinkedIn</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>