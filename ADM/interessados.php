<?php
    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Cliente.php');
    
    $requerindo_classe = new Cliente("maison2","localhost","root","11153025192Fd@");

    $_SESSION['Lista'] = $requerindo_classe->listarDesejos();

    //-------------------------------------------SISTEMA DA PAGINAÇÃO------------------------------------------------------------------
    if(!is_null($_SESSION['Lista'])){//Se o resultado do filtro não for nulo, então prossiga

        // Defina o número de resultados por página
        $por_pagina = 5;

        // Obtenha o número da página atual ou defina como 1 se não estiver definido
        $pagina_atual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

        // Calcule o início do slice do array
        $inicio = ($pagina_atual - 1) * $por_pagina;

        // Calcule o número total de páginas
        $total_paginas = ceil(count($_SESSION['Lista']) / $por_pagina);

        // Obtenha os dados para a página atual
        $Lista = array_slice($_SESSION['Lista'], $inicio, $por_pagina);
    }
    //------------------------------------FIM DO SISTEMA DA PAGINAÇÃO------------------------------------------------------------------
    

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/logo_maison.PNG">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Página ADM | Interessados</title>
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
    
    

    <!-- Conteúdo do corpo vai aqui -->
    <div class="container-fluid mb-5 mt-5">
        <main class=" ms-sm-auto px-md-4">

            <div aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">MAISON</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Interessados</li>
                </ol>
            </div>
                       
            <hr>
            <!--Area responsavel por apresentar os interessados-->
            <h2>INTERESSADOS</h2>
            <hr>
            <?php
                /*
                echo "<pre>";
                var_dump($Lista);
                echo "</pre>";
                */
                if (isset($Lista) && !empty($Lista) && !is_null($Lista)) {
                    echo '<div class="table-responsive">';
                    echo '    <table class="table table-striped table-sm">';
                    echo '        <thead>';
                    echo '            <tr role="row">';
                    echo '                <th scope="col" role="columnheader">IDENTIFICADOR DO CLIENTE</th>';
                    echo '                <th scope="col" role="columnheader">IDENTIFICADOR DO IMOVEL</th>';
                    echo '                <th scope="col" role="columnheader">NOME DO CLIENTE</th>';
                    echo '                <th scope="col" role="columnheader">DESEJA RECEBER NOTIFICAÇÕES</th>';
                    echo '                <th scope="col" role="columnheader">TELEFONE</th>';
                    echo '                <th scope="col" role="columnheader">E-MAIL</th>';
                    echo '                <th scope="col" role="columnheader">FEITO CONTATO</th>';
                    echo '                <th scope="col" role="columnheader">AÇÃO</th>';
                    echo '            </tr>';
                    echo '        </thead>';
                    foreach($Lista as $indice => $interessado){
                        $infoCliente = $requerindo_classe->listarUsuarioPeloId($interessado['clienteID']);
                        /*
                        echo "<pre>";
                        var_dump($infoCliente);
                        echo "</pre>";
                        */
                        echo '        <tbody>';
                        echo '            <tr role="row">';
                        echo "                <td role='cell'>{$interessado['clienteID']}</td>";
                        echo "                <td role='cell'>{$interessado['imID']}</td>";
                        echo "                <td role='cell'>{$infoCliente['clienteNome']}</td>";
                        echo "                <td role='cell'>{$interessado['deseja_contato']}</td>";
                        echo "                <td role='cell'>{$infoCliente['clienteTel']}</td>";
                        echo "                <td role='cell'>{$infoCliente['clienteEmail']}</td>";
                        echo "                <td role='cell'>{$interessado['feito_contato']}</td>";
                        echo "                <td role='cell'><a href='ManipularInteresse.php?IDcliente={$interessado['clienteID']}&IDimovel={$interessado['imID']}' class='btn btn-primary'>ALTERAR</a></td>";
                        echo '            </tr>';
                        echo '        </tbody>';
                    }
                    echo '    </table>';                
                    echo '</div>';
                }
                else {
                    echo '<p class="text-center mb-5 mt-2 p-2">Nenhum Interessado</p>';
                }
            ?>
            <hr>
        </main>
    </div>
    <!--Páginação-->

    <?php
        if(!is_null($_SESSION['Lista'])){
            if(count($_SESSION['Lista']) > 5){
                echo "<div class='container my-4 text-center' style='border: 1px solid black;'>";
            
                $max_links = 2; // Número máximo de links
                $start = max(1, $pagina_atual - $max_links);
                $end = min($total_paginas, $pagina_atual + $max_links);

                // Botões primeiro e anterior
                if($pagina_atual > 1){
                    //Boãto primeiro
                    echo "<a href='?pagina=1'>Primeiro</a> ";
                    //Botão para anterior
                    echo "<a href='?pagina=".($pagina_atual - 1)."'>Anterior</a> ";
                }
            
                // Links de página
                for ($i = $start; $i <= $end; $i++) {
                    echo "<a href='?pagina=$i'>$i</a> ";
                }
            
                // Botões próximo e último
                if($pagina_atual < $total_paginas){
                    //Botão proximo
                    echo "<a href='?pagina=".($pagina_atual + 1)."'>Próximo</a> ";
                    //Botão ultimo
                    echo "<a href='?pagina=".$total_paginas."'>Último</a> ";
                }
            
                echo "</div>";
            }
        }
    ?>

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
