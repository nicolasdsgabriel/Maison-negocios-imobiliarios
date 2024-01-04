<?php

    /**
     * Falta:
     * Validação de formulário
     * CSS
     * Aumentar a quantidade de usuários por página
     */

    session_start();

    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Cliente.php');

    $requerindo_classe = new Cliente("maison2","localhost","root","11153025192Fd@");

    //$lista_de_todos_usuarios = $requerindo_classe->listarUsuarios();

    $_SESSION['identificador_cliente_LC'] = $id_do_filtro = filter_input(INPUT_GET, 'identificador_cliente', FILTER_SANITIZE_NUMBER_INT);
    $_SESSION['nome_cliente_LC'] = $nome_do_filtro = filter_input(INPUT_GET, 'nome_cliente', FILTER_SANITIZE_STRING);
    $_SESSION['telefone_cliente_LC'] = $telefone_do_filtro = filter_input(INPUT_GET, 'telefone_cliente', FILTER_SANITIZE_NUMBER_INT);
    $_SESSION['email_cliente_LC'] = $email_do_filtro = filter_input(INPUT_GET, 'email_cliente', FILTER_SANITIZE_STRING);
    $_SESSION['caixa_pesquisa_filtro_usuarios'] = $busca_do_filtro = filter_input(INPUT_GET, 'caixa_pesquisa_filtro_usuarios', FILTER_SANITIZE_STRING);
    $_SESSION['cpf_cliente_LC'] = $cpf_do_filtro = filter_input(INPUT_GET, 'CPF_CLIENTE', FILTER_SANITIZE_STRING);
    $_SESSION['tipo_usuario_LC'] = $adm = filter_input(INPUT_GET, 'tipo_usuario', FILTER_SANITIZE_NUMBER_INT);

    $_SESSION['LISTA_USUARIOS_FILTRO'] = $requerindo_classe->BUSCAR($id_do_filtro, $nome_do_filtro, $telefone_do_filtro, $email_do_filtro, $busca_do_filtro, $cpf_do_filtro, $adm);    

    //-------------------------------------------SISTEMA DA PAGINAÇÃO------------------------------------------------------------------
    if(!is_null($_SESSION['LISTA_USUARIOS_FILTRO'])){//Se o resultado do filtro não for nulo, então prossiga

        // Defina o número de resultados por página
        $por_pagina = 5;

        // Obtenha o número da página atual ou defina como 1 se não estiver definido
        $pagina_atual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

        // Calcule o início do slice do array
        $inicio = ($pagina_atual - 1) * $por_pagina;

        // Calcule o número total de páginas
        $total_paginas = ceil(count($_SESSION['LISTA_USUARIOS_FILTRO']) / $por_pagina);

        // Obtenha os dados para a página atual
        $resultados = array_slice($_SESSION['LISTA_USUARIOS_FILTRO'], $inicio, $por_pagina);
    }
    //------------------------------------FIM DO SISTEMA DA PAGINAÇÃO------------------------------------------------------------------
    
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
                <a class="navbar-brand" href="indexAdm.php">MAISON</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                      <li class="nav-item">
                          <a class='nav-link' href='../logout.php'>Deslogar</a>
                      </li>
                      <li class="nav-item">
                          <a class='nav-link' href='ListaCliente.php'>Listar Clientes</a>
                      </li>
                      <li class="nav-item">
                        <a class='nav-link' href='interessados.php'>Interessados</a>
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
              <li class="breadcrumb-item active" aria-current="page">Listar Cliente</li>
            </ol>
        </div>


        <div class="container md-2 mt-2 p-2 d-flex flex-column justify-content-center align-items-center">
            <h2>Filtros</h2>
            <div class="card">
                <div class="card-body">
                  <form action="" method="GET" class="align-items-center">
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="identificador_cliente" class="col-form-label">IDENTIFICADOR DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="number" id="identificador_cliente" name="identificador_cliente" class="form-control" placeholder="IDENTIFICADOR DO CLIENTE" <?php if(isset($id_do_filtro)){echo "value='$id_do_filtro'";}?>>
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="nome_cliente" class="col-form-label">NOME DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="text" id="nome_cliente" name="nome_cliente" class="form-control" placeholder="NOME DO CLIENTE" <?php if(isset($nome_do_filtro)){echo "value='$nome_do_filtro'";}?>>
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="telefone_cliente" class="col-form-label">TELEFONE DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="tel" id="telefone_cliente" name="telefone_cliente" class="form-control" placeholder="TELEFONE DO CLIENTE" <?php if(isset($telefone_do_filtro)){echo "value='$telefone_do_filtro'";}?>>
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="email_cliente" class="col-form-label">EMAIL DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="email" id="email_cliente" name="email_cliente" class="form-control" placeholder="EMAIL DO CLIENTE" <?php if(isset($email_do_filtro)){echo "value='$email_do_filtro'";}?>>
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="CPF_CLIENTE" class="col-form-label">CPF DO CLIENTE:</label>
                          </div>
                          <div class="col-auto">
                              <input type="text" id="CPF_CLIENTE" name="CPF_CLIENTE" class="form-control" placeholder="CPF DO CLIENTE" <?php if(isset($cpf_do_filtro)){echo "value='$cpf_do_filtro'";}?>>
                          </div>
                      </div>
                      <div class="col-auto">
                            <label for="tipo_usuario" class="col-form-label">TIPO DE USUÁRIO:</label>
                        </div>
                        <div class="col-auto">
                            <select name="tipo_usuario" class="form-select">
                                <option value="2" <?php echo $adm == '2' ? 'selected' : ''; ?>>AMBOS</option>
                                <option value="1" <?php echo $adm == '1' ? 'selected' : ''; ?>>SIM</option>
                                <option value="0" <?php echo $adm == '0' ? 'selected' : ''; ?>>NÃO</option>
                            </select>
                        </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <label for="caixa_pesquisa_filtro_usuarios" class="col-form-label">ABA DE PESQUISA:</label>
                          </div>
                          <div class="col-auto">
                              <input type="text" id="caixa_pesquisa_filtro_interessado" name="caixa_pesquisa_filtro_usuarios" class="form-control" placeholder="Digite sua pesquisa aqui" value="<?=$busca_do_filtro//imprima a ultima pesquisa feita pelo usuário?>">
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                          <div class="col-auto">
                              <input type="submit" name="botton_pesquisa_usuarios" value="PESQUISAR" class="btn btn-primary">
                          </div>
                      </div>
                      <div class="row mt-2 g-3 align-items-center">
                        <div class="col-auto d-inline">
                            <a href="ListaCliente.php" class="btn btn-primary">RESETAR O FILTRO</a>
                        </div>
                      </div>
                  </form>
                </div>
            </div>                          
        </div>

        <div class="row mb-2 mt-3">
            <h2 class="h2">Usuários</h2>
        </div>
        <div class="mb-2 mt-2">
            <a href="AdicionarCliente.php" class="btn btn-primary">ADICIONAR NOVO USUÁRIO</a>
        </div>

        <hr>

        <?php

            if (!is_null($_SESSION['LISTA_USUARIOS_FILTRO'])){
                echo "<div class='table-responsive'>";
                echo "    <table class='table table-striped table-sm text-center'>";
                echo "        <thead>";
                echo "            <tr role='row'>";
                echo "                <th scope='col' role='columnheader'>IDENTIFICADOR DO CLIENTE</th>";
                echo "                <th scope='col' role='columnheader'>NOME DO CLIENTE</th>";
                echo "                <th scope='col' role='columnheader'>CPF DO CLIENTE</th>";
                echo "                <th scope='col' role='columnheader'>E-MAIL</th>";
                echo "                <th scope='col' role='columnheader'>SENHA DO CLIENTE</th>";
                echo "                <th scope='col' role='columnheader'>TELEFONE</th>";
                echo "                <th scope='col' role='columnheader'>ADM</th>";
                echo "                <th scope='col' colspan='2' role='columnheader'>AÇÃO</th>";
                echo "            </tr>";
                echo "        </thead>";
                echo "        <tbody>";
                foreach ($resultados as $chave => $elemento){
                    echo "            <tr role='row'>";
                    echo "                <td role='cell'>" . $elemento['clienteID'] . "</td>";
                    echo "                <td role='cell'>" . $elemento['clienteNome'] . "</td>";
                    echo "                <td role='cell'>" . $elemento['clienteCPF'] . "</td>";
                    echo "                <td role='cell'>" . $elemento['clienteEmail'] . "</td>";
                    echo "                <td role='cell'>" . $elemento['clienteSenha'] . "</td>";
                    echo "                <td role='cell'>" . $elemento['clienteTel'] . "</td>";
                    echo "                <td role='cell'>" . $elemento['adm'] . "</td>";
                    echo "                <td role='cell'><a class='btn btn-primary' href='AlteraCliente.php?id_do_usuario=".$elemento['clienteID']."'>Editar</a></td>";
                    echo "                <td role='cell'><a class='btn btn-primary' href='ExcluirCliente.php?id_do_usuario=".$elemento['clienteID']."'>Excluir</a></td>";
                    echo "            </tr>";
                }
                echo "        </tbody>";
                echo "    </table>";   
                echo "</div>";
            }
            
            else{
                echo "<p class='my-2 text-center'>Nenhum Usuário encontrado</p>";
            }

        ?>
        <hr>
        <!-- Paginação -->
    <?php
        if(!is_null($_SESSION['LISTA_USUARIOS_FILTRO'])){
            if(count($_SESSION['LISTA_USUARIOS_FILTRO']) > 5){
                echo "<div class='container my-4 text-center' style='border: 1px solid black;'>";
            
                $max_links = 2; // Número máximo de links
                $start = max(1, $pagina_atual - $max_links);
                $end = min($total_paginas, $pagina_atual + $max_links);

                // Botões primeiro e anterior
                if($pagina_atual > 1){
                    //Boãto primeiro
                    echo "<a href='?pagina=1";
                    if(isset($id_do_filtro)){
                        echo "&identificador_cliente=$id_do_filtro";
                    }
                    if(isset($nome_do_filtro)){
                        echo "&nome_cliente=$nome_do_filtro";
                    }
                    if(isset($telefone_do_filtro)){
                        echo "&telefone_cliente=$telefone_do_filtro";
                    }
                    if(isset($email_do_filtro)){
                        echo "&email_cliente=$email_do_filtro";
                    }
                    if(isset($cpf_do_filtro)){
                        echo "&CPF_CLIENTE=$cpf_do_filtro";
                    }
                    if(isset($adm)){
                    echo "&tipo_usuario=$adm";
                    }
                    if(isset($busca_do_filtro)){
                        echo "&caixa_pesquisa_filtro_usuarios=$busca_do_filtro";
                    }
                    echo "'>Primeiro</a> ";
                    //Botão para anterior

                    echo "<a href='?pagina=".($pagina_atual - 1)."";
                    if(isset($id_do_filtro)){
                        echo "&identificador_cliente=$id_do_filtro";
                    }
                    if(isset($nome_do_filtro)){
                        echo "&nome_cliente=$nome_do_filtro";
                    }
                    if(isset($telefone_do_filtro)){
                        echo "&telefone_cliente=$telefone_do_filtro";
                    }
                    if(isset($email_do_filtro)){
                        echo "&email_cliente=$email_do_filtro";
                    }
                    if(isset($cpf_do_filtro)){
                        echo "&CPF_CLIENTE=$cpf_do_filtro";
                    }
                    if (isset($adm)){
                        echo "&tipo_usuario=$adm";
                    }
                    if(isset($busca_do_filtro)){
                        echo "&caixa_pesquisa_filtro_usuarios=$busca_do_filtro";
                    }
                    echo "'>Anterior</a> ";
                }
            
                // Links de página
                for ($i = $start; $i <= $end; $i++) {
                    echo "<a href='?pagina=$i";
                    if(isset($id_do_filtro)){
                        echo "&identificador_cliente=$id_do_filtro";
                    }
                    if(isset($nome_do_filtro)){
                        echo "&nome_cliente=$nome_do_filtro";
                    }
                    if(isset($telefone_do_filtro)){
                        echo "&telefone_cliente=$telefone_do_filtro";
                    }
                    if(isset($email_do_filtro)){
                        echo "&email_cliente=$email_do_filtro";
                    }
                    if(isset($cpf_do_filtro)){
                        echo "&CPF_CLIENTE=$cpf_do_filtro";
                    }
                    if(isset($adm)){
                        echo "&tipo_usuario=$adm";
                    }
                    if(isset($busca_do_filtro)){
                        echo "&caixa_pesquisa_filtro_usuarios=$busca_do_filtro";
                    }
                    echo "''>$i</a> ";
                }
            
                // Botões próximo e último
                if($pagina_atual < $total_paginas){
                    //Botão proximo
                    echo "<a href='?pagina=".($pagina_atual + 1)."";
                        if(isset($id_do_filtro)){
                            echo "&identificador_cliente=$id_do_filtro";
                        }
                        if(isset($nome_do_filtro)){
                            echo "&nome_cliente=$nome_do_filtro";
                        }
                        if(isset($telefone_do_filtro)){
                            echo "&telefone_cliente=$telefone_do_filtro";
                        }
                        if(isset($email_do_filtro)){
                            echo "&email_cliente=$email_do_filtro";
                        }
                        if(isset($cpf_do_filtro)){
                            echo "&CPF_CLIENTE=$cpf_do_filtro";
                        }
                        if(isset($adm)){
                            echo "&tipo_usuario=$adm";
                        }
                        if(isset($busca_do_filtro)){
                            echo "&caixa_pesquisa_filtro_usuarios=$busca_do_filtro";
                        }
                    echo "'>Próximo</a> ";
                    //Botão ultimo
                    echo "<a href='?pagina=".$total_paginas."";
                        if(isset($id_do_filtro)){
                            echo "&identificador_cliente=$id_do_filtro";
                        }
                        if(isset($nome_do_filtro)){
                            echo "&nome_cliente=$nome_do_filtro";
                        }
                        if(isset($telefone_do_filtro)){
                            echo "&telefone_cliente=$telefone_do_filtro";
                        }
                        if(isset($email_do_filtro)){
                            echo "&email_cliente=$email_do_filtro";
                        }
                        if(isset($cpf_do_filtro)){
                            echo "&CPF_CLIENTE=$cpf_do_filtro";
                        }
                        if(isset($adm)){
                            echo "&tipo_usuario=$adm";
                        }
                        if(isset($busca_do_filtro)){
                            echo "&caixa_pesquisa_filtro_usuarios=$busca_do_filtro";
                        }
                    echo "'>Último</a> ";
                }
            
                echo "</div>";
            }
        }
    ?>
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