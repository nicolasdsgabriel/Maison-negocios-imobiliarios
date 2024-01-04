<?php 

    /**
     * Falta:
     * Validação formulário
     * CSS
     * Arrumar os links
     * Recomendo olhar linha por linha
     * Verificação do login
     */

    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Cliente.php');

    $requerindo_classe = new Cliente("maison2","localhost","root","11153025192Fd@");

    if(isset($_GET['Alterar'])){

        $id = $_GET["id_do_usuario"];
        $nome = $_GET["nome_cliente"];
        $cpf = $_GET["CPF_CLIENTE"];
        $email = $_GET["email_cliente"];
        $senha = $_GET["senha_cliente"]; // Parece que a senha não está sendo passada na URL
        $telefone = $_GET["telefone_cliente"];
        $adm = $_GET["tipo_usuario"];


        $resultado = $requerindo_classe->AlterarUsuario($id, $nome, $cpf, $email, $senha, $telefone, $adm);
        
        if ($resultado){
            $mensagem = "USUÁRIO ATUALIZADO COM SUCESSO";
        }
        else {
            echo $resultado;
        }

        $Usuario = $requerindo_classe->listarUsuarioPeloId($id);
    }

    $Usuario = $requerindo_classe->listarUsuarioPeloId($_GET['id_do_usuario']);

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
              <li class="breadcrumb-item active" aria-current="page">Editar Cliente</li>
            </ol>
        </div>
        <div>

        </div>
        <div class="container-fuild d-flex align-items-center mt-5 mb-5 p-5" style="border: solid black 1px;">
            <p><?php
                    if (isset($mensagem)) {
                        echo $mensagem;
                    }
            ?></p>
        </div>
        <div class="container-fluid mb-5 mt-5 p-5" style="border: solid black 1px;">
            Informações do cliente que vai ser alterado
            <div class="card">
                <div class="card-body">
                  <form action="" method="GET" class="align-items-center">
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="identificado_cliente" class="col-form-label">IDENTIFICADOR DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="hidden" name="id_do_usuario" value="<?= $Usuario['clienteID'];?>">
                              <p class="form-control"><?=$Usuario['clienteID']?></p>
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="nome_cliente" class="col-form-label">NOME DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="text" id="nome_cliente" name="nome_cliente" class="form-control" value="<?=$Usuario['clienteNome']?>">
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="telefone_cliente" class="col-form-label">TELEFONE DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="tel" id="telefone_cliente" name="telefone_cliente" class="form-control" value="<?=$Usuario['clienteTel']?>">
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                        <div class="col-auto">
                            <label for="senha_cliente" class="col-form-label">SENHA: </label>
                        </div>
                        <div class="col-auto">
                            <input type="tel" id="senha_cliente" name="senha_cliente" class="form-control" value="<?=$Usuario['clienteSenha']?>">
                        </div>
                    </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="email_cliente" class="col-form-label">EMAIL DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="email" id="email_cliente" name="email_cliente" class="form-control" value="<?=$Usuario['clienteEmail']?>">
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="CPF_CLIENTE" class="col-form-label">CPF DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="text" id="CPF_CLIENTE" name="CPF_CLIENTE" class="form-control" value="<?=$Usuario['clienteCPF']?>">
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="tipo_usuario" class="col-form-label">USUÁRIO ADIMINISTRADOR:</label>
                          </div>
                          <div class="col-auto">
                            <select name="tipo_usuario" class="form-select">
                                <option value="1" <?php echo $Usuario['adm'] == '1' ? 'selected' : ''; ?>>SIM</option>
                                <option value="0" <?php echo $Usuario['adm'] == '0' ? 'selected' : ''; ?>>NÃO</option>
                            </select>
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <input type="submit" name="Alterar" value="Alterar" class="btn btn-primary">
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