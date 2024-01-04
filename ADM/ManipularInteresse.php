<?php
    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Cliente.php');
    
    $requerindo_classe = new Cliente("maison2","localhost","root","11153025192Fd@");

    $IDcliente = $_GET['IDcliente'];
    $IDimovel = $_GET['IDimovel'];

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

        .custom-table {
            border-collapse: collapse;
            width: 100%;
        }

        .custom-table th, .custom-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .custom-table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }

        .custom-btn-submit {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .custom-btn-delete {
            background-color: #f44336;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
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
                          <a class='nav-link' href='GerenciadorImovel.php'>Adicionar/Editar/Excluir Imovel</a>
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

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard [Grafico de qualquer coisa, podemos colocar a quantidade de usuário, imovel e numeros de pedidos]</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Compartilhar</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Essa Semana
                </button>
                </div>
            </div>
            
            <div class="container md-2 mt-2 p-2">
                <h2>Gráfico de Barras</h2>
                <div class="progress mb-3" style="height: 30px;">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
                <div class="progress mb-3" style="height: 30px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                </div>
                <div class="progress mb-3" style="height: 30px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
                <div class="progress" style="height: 30px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                </div>
            </div>
            
            <hr>
            <!--Sistema de filtro-->
            <div class="container md-2 mt-2 p-2 d-flex flex-column justify-content-center align-items-center">
                <h2>Filtros</h2>
                <form action="" method="GET" class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="tipo_de_notificacao" class="col-form-label">Deseja receber notificações:</label>
                    </div>
                    <div class="col-auto">
                        <select name="tipo_de_notificacao" id="tipo_de_notificacao" class="form-select">
                            <option value="">Selecione uma opção</option>
                            <option value="SIM">SIM</option>
                            <option value="NAO">NÃO</option>
                            <option value="TODOS">TODOS</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="caixa_pesquisa_filtro_interessado" name="caixa_pesquisa_filtro_interessado" class="form-control" placeholder="Digite sua pesquisa aqui">
                    </div>
                    <div class="col-auto">
                        <input type="submit" name="botton_pesquisa_filtro_interessado" value="PESQUISAR" class="btn btn-primary">
                    </div>
                </form>
            </div>
                       
            <hr>
            <!--Area responsavel por apresentar os interessados-->
            <h2>INTERESSADOS</h2>
            <hr>
            <?php
                $Lista = $requerindo_classe->ListarDesejoUnico($IDcliente, $IDimovel);                
                if (isset($Lista) && !empty($Lista) && !is_null($Lista)) {
                    echo "<form action='pro.EditarInteresse.php' method='GET' class='form-control'>";
                    echo "<input type='hidden' name='idc' value='{$Lista['clienteID']}'>";
                    echo "<input type='hidden' name='idm' value='{$Lista['imID']}'>";
                    echo '<div class="table-responsive">';
                    echo '    <table class="table table-striped table-sm custom-table">';
                    echo '        <thead>';
                    echo '            <tr role="row">';
                    echo '                <th scope="col" role="columnheader">IDENTIFICADOR DO CLIENTE</th>';
                    echo '                <th scope="col" role="columnheader">IDENTIFICADOR DO IMOVEL</th>';
                    echo '                <th scope="col" role="columnheader">NOME DO CLIENTE</th>';
                    echo '                <th scope="col" role="columnheader">DESEJA RECEBER NOTIFICAÇÕES</th>';
                    echo '                <th scope="col" role="columnheader">TELEFONE</th>';
                    echo '                <th scope="col" role="columnheader">E-MAIL</th>';
                    echo '                <th scope="col" role="columnheader">FEITO CONTATO</th>';
                    echo '            </tr>';
                    echo '        </thead>';
                    $infoCliente = $requerindo_classe->listarUsuarioPeloId($Lista['clienteID']);
                    echo '        <tbody>';
                    echo '            <tr role="row">';
                    echo "                <td role='cell'>{$Lista['clienteID']}</td>";
                    echo "                <td role='cell'>{$Lista['imID']}</td>";
                    echo "                <td role='cell'>{$infoCliente['clienteNome']}</td>";
                    echo "                <td role='cell'>";
                    echo "                <select name='deseja_contato' id='deseja_contato'>";
                    echo "                      <option value='SIM' ". ($Lista['deseja_contato'] == 'SIM' ? 'selected' : '') . ">Sim</option>";
                    echo "                      <option value='NAO' ". ($Lista['deseja_contato'] == 'NAO' ? 'selected' : '') . ">Não</option>";
                    echo "                </select>";
                    echo "                </td>";
                    echo "                <td role='cell'>{$infoCliente['clienteTel']}</td>";
                    echo "                <td role='cell'>{$infoCliente['clienteEmail']}</td>";
                    echo "                <td role='cell'>";
                    echo "                <select name='feito_contato' id='feito_contato'>";
                    echo "                      <option value='SIM' ". ($Lista['feito_contato'] == 'SIM' ? 'selected' : '') . ">Sim</option>";
                    echo "                      <option value='NAO' ". ($Lista['feito_contato'] == 'NAO' ? 'selected' : '') . ">Não</option>";
                    echo "                </select>";
                    echo "                </td>";
                    echo '            </tr>';
                    echo '        </tbody>';
                    echo '    </table>';                
                    echo '</div>';
                    echo "<a href='pro.ExcluirInteresse.php?IDcatalogo={$Lista['CatalogoID']}' class='btn btn-primary custom-btn-delete'>Excluir</a>";
                    echo "<input type='submit' value='SALVAR ALTERAÇÕES' class='btn btn-primary custom-btn-submit'>";
                    echo "</form>";
                }
                else {
                    echo '<p class="text-center mb-5 mt-2 p-2">Nenhum Interessado</p>';
                }
            ?>
            <a href="interessados.php">Voltar</a>
        </main>
    </div>

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
