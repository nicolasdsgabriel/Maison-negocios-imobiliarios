<?php 

    /**
     * Falta:
     * Validação formulário
     * CSS
     * Arrumar os links
     * Recomendo olhar linha por linha
     * Verificação do login
     * Colocar o formulário dentro do php, para que possa sumir caso o usuário não exista, mais
     */

    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Cliente.php');

    $requerindo_classe = new Cliente("maison2","localhost","root","11153025192Fd@");

    if(isset($_GET['excluir'])){

        $id = $_GET["id_do_usuario"];

        $resultado = $requerindo_classe->ExcluirUsuario($id);
        
        if ($resultado){
            $mensagem = "USUÁRIO EXCLUIDO COM SUCESSO";
        }
        else {
            echo $resultado;
        }

        $Usuario = $requerindo_classe->listarUsuarioPeloId($id);
    }
    else{
        $Usuario = $requerindo_classe->listarUsuarioPeloId($_GET['id_do_usuario']);
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
                          <a class='nav-link' href='ListaCliente.php'>Listar Cliente</a>
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
              <li class="breadcrumb-item active" aria-current="page">Excluir Cliente</li>
            </ol>
        </div>
        <div class="container-fuild d-flex align-items-center mt-5 mb-5 p-5" style="border: solid black 1px;">
            <?php  
                if (isset($mensagem)){
                    echo "<p>" . $mensagem . "</p>";
                }
            ?>
        </div>
            <div class="container-fluid mb-5 mt-5 p-5" style="border: solid black 1px;">
                Informações do cliente que vai ser Excluido
                <div class="card">
                    <div class="card-body">
                        <form action="" method="GET" class="align-items-center">
                            <input type="hidden" name="id_do_usuario" value="<?=$Usuario['clienteID']?>">
                            <p><?php
                                if ((!is_null($Usuario)) && ($Usuario != false)){
                                    echo "<p>{$Usuario['clienteID']}</p>";
                                    echo "<p>{$Usuario['clienteNome']}</p>";
                                    echo "<p>{$Usuario['clienteCPF']}</p>";
                                    echo "<p>{$Usuario['clienteEmail']}</p>";
                                    echo "<p>{$Usuario['clienteSenha']}</p>";
                                    echo "<p>{$Usuario['clienteTel']}</p>";
                                    echo "<p>{$Usuario['adm']}</p>";
                                }
                            ?></p>    
                            <div class="row mt-2 g-3 align-items-center">
                                <div class="col-auto">
                                    <input type="submit" name="excluir" value="EXCLUIR" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
    </main>

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