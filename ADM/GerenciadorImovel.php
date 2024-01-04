<?php

    /*O que falta nesta página:
    - Verificação de login
    - Melhorar o css e javascript
    - Adicionar uma navbar melhor
    - Adicionar um footer melhor
    - Adicionar o sistema de contatos
    - A lista de desejo completa do usuário, uma baseada no session, e outra baseada no usuário logado
    - Melhorar o banco.
    - No ADM, adicionar sistema de armazenamento de fotos por pastas.
    */

    session_start();

    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.filtro.php');
    require_once('../CLASSES/Classe.Imovel.php');

    //Criando os objetos
    $imovelClasse = new Imovel("maison2","localhost","root","11153025192Fd@");//Objeto Imovel
    $imovelClasseFiltro = new Filtro("maison2","localhost","root","11153025192Fd@");//Objeto Filtro

    $busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);//Atribua-se na variavel busca um filtro para o campo preenchido no formulário de busca, onde este filtro protege o banco de dados de códigos mal intencionado no sistema de busca.
    $OPERACAO_form = filter_input(INPUT_GET, 'tipo_operacao', FILTER_SANITIZE_STRING);//A variavel recebe o valor presente no campo 'operacao' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $TIPO_IMOVEL_form = filter_input(INPUT_GET, 'tipo_imovel', FILTER_SANITIZE_STRING);//A variavel recebe o valor presente no campo 'tipo_imovel' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $DORMITORIOS_form = filter_input(INPUT_GET, 'dormitorios_select', FILTER_SANITIZE_NUMBER_INT);//A variavel recebe o valor presente no campo 'dormitorios' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $GARAGEM_form = filter_input(INPUT_GET, 'garagem_select', FILTER_SANITIZE_NUMBER_INT);//A variavel recebe o valor presente no campo 'garagem_select' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $MINIMO_form = filter_input(INPUT_GET, 'minimo_valor', FILTER_SANITIZE_NUMBER_INT);//A variavel recebe o valor presente no campo 'minimo_valor' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $MAXIMO_form = filter_input(INPUT_GET, 'maximo_valor', FILTER_SANITIZE_NUMBER_INT);//A variavel recebe o valor presente no campo 'maximo_valor' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $_SESSION['INPUT_ORDENACAO'] = $ORDENACAO_form = filter_input(INPUT_GET, 'ordenacao', FILTER_SANITIZE_STRING);//A variavel recebe o valor presente no campo 'ordenacao' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL

    $_SESSION['RESULTADO_FILTRO_ADM'] = $imovelClasseFiltro->BUSCAR($busca, $OPERACAO_form, $TIPO_IMOVEL_form, $DORMITORIOS_form, $GARAGEM_form, $MINIMO_form, $MAXIMO_form);
   
    //-------------------------------------------SISTEMA DA PAGINAÇÃO------------------------------------------------------------------
    if(!is_null($_SESSION['RESULTADO_FILTRO_ADM'])){//Se o resultado do filtro não for nulo, então prossiga

        // Ordena o array usando usort e a função de comparação
        if(isset($_SESSION['INPUT_ORDENACAO'])){
            if($_SESSION['INPUT_ORDENACAO'] == 'maior'){
                usort($_SESSION['RESULTADO_FILTRO_ADM'], function($a, $b){
                    return $b['preco'] <=> $a['preco'];//Está ordenando o array $_SESSION['RESULTADO_FILTRO'] em ordem decrescente com base nos valores da chave 'preco' de seus elementos.
                });
            }
            else if($_SESSION['INPUT_ORDENACAO'] == 'menor'){
                usort($_SESSION['RESULTADO_FILTRO_ADM'], function($a, $b){
                    return $a['preco'] <=> $b['preco'];//Está ordenando o array $_SESSION['RESULTADO_FILTRO'] em ordem crescente com base nos valores da chave 'preco' de seus elementos.
                });                
            }
        }

        // Defina o número de resultados por página
        $por_pagina = 3;

        // Obtenha o número da página atual ou defina como 1 se não estiver definido
        $pagina_atual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

        // Calcule o início do slice do array
        $inicio = ($pagina_atual - 1) * $por_pagina;

        // Calcule o número total de páginas
        $total_paginas = ceil(count($_SESSION['RESULTADO_FILTRO_ADM']) / $por_pagina);

        // Obtenha os dados para a página atual
        $resultados = array_slice($_SESSION['RESULTADO_FILTRO_ADM'], $inicio, $por_pagina);
    }
    //------------------------------------FIM DO SISTEMA DA PAGINAÇÃO------------------------------------------------------------------
    /*
        echo "<pre>";
        var_dump($_SESSION['RESULTADO_FILTRO']);
        echo "</pre>";
    */
?>   
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>ADM | Gerenciador de Imoveis</title>
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
            padding-top: 70px; /* Altura da navbar */
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
                          <a class='nav-link' href='ListaCliente.php'>Listar Cliente</a>
                      </li>
                      <li class="nav-item">
                        <a class='nav-link' href='GerenciadorImovel.php'>Gerenciador de Imoveis</a>
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
    
    <main class="container-fluid">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">MAISON</a></li>
              <li class="breadcrumb-item active" aria-current="page">Gerenciador de Imoveis</li>
            </ol>
        </div>
        <div class="container my-4 align_items-center">
            <div class="row" style="border: 1px solid black;">
                <form method="get">
                    <div class="row my-2 align-items-center" >
                        <div class="col-auto">
                            <label for="tipo_operacao" class="col-form-label">Escolha a operação:</label>
                        </div>
                        <div class="col-auto">
                            <select name="tipo_operacao" class="form-select">
                                <option value="todos" <?php echo $OPERACAO_form == 'todos' ? 'selected' : ''; ?>>Todos</option>
                                <option value="aluguel" <?php echo $OPERACAO_form == 'aluguel' ? 'selected' : ''; ?>>Alugar</option>
                                <option value="compra" <?php echo $OPERACAO_form == 'compra' ? 'selected' : ''; ?>>Comprar</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="busca" class="col-form-label">Buscar:</label>
                        </div>
                        <div class="col g3">
                            <input type="text" name="busca" class="form-control" value="<?=$busca//imprima a ultima pesquisa feita pelo usuário?>">
                        </div>
                    </div>
                    <div class="row my-2 align-items-center d-flex justify-content-center">
                        <div class="col-auto d-inline">
                            <label class="col-form-label" for="tipo_imovel">Tipo do imovel</label>
                        </div>
                        <div class="col-auto d-inline">
                            <select name="tipo_imovel" id="tipo_imovel" class="form-select">
                                <option value="todos" <?php echo $TIPO_IMOVEL_form == 'todos' ? 'selected' : ''; ?>>Todos</option>
                                <option value="casa" <?php echo $TIPO_IMOVEL_form == 'casa' ? 'selected' : ''; ?>>Casa</option>
                                <option value="apartamento" <?php echo $TIPO_IMOVEL_form == 'apartamento' ? 'selected' : ''; ?>>Apartamento</option>
                                <option value="kitnet" <?php echo $TIPO_IMOVEL_form == 'kitnet' ? 'selected' : ''; ?>>Kitnet</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-2 align-items-center d-flex justify-content-center">
                        <div class="col-auto d-inline">
                            <label class="col-form-label" for="dormitorios_select">Quantidade de Dormitórios</label>
                        </div>
                        <div class="col d-inline">
                            <input type="number" class="form-control" min="0" id="dormitorios_select" name="dormitorios_select" <?php if(isset($DORMITORIOS_form)){echo "value='$DORMITORIOS_form'";}?>>
                        </div>
                        <div class="col-auto d-inline">
                            <label class="col-form-label" for="garagem_select">Espaço na Garagem</label>
                        </div>
                        <div class="col d-inline">
                            <input type="number" class="form-control" min="0" id="garagem_select" name="garagem_select"  <?php if(isset($GARAGEM_form)){echo "value='$GARAGEM_form'";}?>>
                        </div>
                    </div>
                    <div class="row my-2 align-items-center d-flex justify-content-center">
                        <div class="col-auto d-inline">
                            <label class="col-form-label" for="minimo_valor">Valor Minimo R$</label>
                        </div>
                        <div class="col d-inline">
                            <input type="number" name="minimo_valor" id="minimo_valor" class="form-control" min="0" <?php if(isset($MINIMO_form)){echo "value='$MINIMO_form'";}?>>
                        </div>
                        <div class="col-auto d-inline">
                            <label class="col-form-label" for="maximo_valor">Valor Maximo R$</label>
                        </div>
                        <div class="col d-inline">
                            <input type="number" name="maximo_valor" id="maximo_valor" class="form-control" min="0" <?php if(isset($MAXIMO_form)){echo "value='$MAXIMO_form'";}?>>
                        </div>
                    </div>
                    <div class="row my-2 align-items-center d-flex justify-content-center">
                        <div class="col-auto d-inline">
                            <label class="col-form-label" for="ordenacao">Ordenar por:</label>
                        </div>
                        <div class="col-auto d-inline">
                            <select name="ordenacao" id="ordenacao" class="form-select">
                                <option value="padrao" <?php echo $ORDENACAO_form == 'padrao' ? 'selected' : ''; ?>>Padrão</option>
                                <option value="menor" <?php echo $ORDENACAO_form == 'menor' ? 'selected' : ''; ?>>Preço menor para o maior</option>
                                <option value="maior" <?php echo $ORDENACAO_form == 'maior' ? 'selected' : ''; ?>>Preço maior para o menor</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-2 align-items-center d-flex justify-content-center">
                        <div class="col-auto d-inline">
                            <input type="submit" class="btn btn-primary" value="BUSCAR" name="btn-buscar">
                        </div>
                        <div class="col-auto d-inline">
                            <a href="GerenciadorImovel.php" class="btn btn-primary">RESETAR O FILTRO</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="conatiner my-5 d-flex justify-content-center align-items-center">
            <a class="btn btn-primary" href="AdicionarImovel.php">ADICIONAR IMOVEL</a>
        </div>

        <!-- Catálogo de imoveis, onde começa os cards -->
        <div class="container my-4 justify-content-center align-items-center">
        <?php
            if((!is_null($_SESSION['RESULTADO_FILTRO_ADM']))){//Se o método da classe filtro retornar o array e não NULL
                if(count($_SESSION['RESULTADO_FILTRO_ADM']) > 0){//Se existir alguma linha nas tabelas
                    foreach ($resultados as $resultado => $imovel) {//Para podermos acessar as colunas da matriz gerada na função anterior
                    echo "<div class='row my-4 justify-content-center align-items-center'>";
                            echo "<div class='card' style='width: 36rem;'>";
                                echo "<div class='card-body'>";
                                    $imagens = $imovelClasse->exibir_imoveis_imagem($imovel['imID']);//$imagem recebe a matriz resultante da função exibir_imoveis_imagem(), onde a função retorna uma matriz[linhas][colunas de cada linha]
                                    echo "<div id='".$imovel['imID']."' class='carousel slide'>";//Identificamos os cards de acordo com o id do imovel.
                                    echo "<div class='carousel-inner'>";
                                    if(count($imagens)>0){//Se existir linhas na tabela imagems, prossiga
                                        foreach ($imagens as $j => $imagem) {//Para podemos selecionar as informações necessárias.
                                            echo "<div class='carousel-item " . ($j === 0 ? 'active' : '') . "'>";//if para poder mudar a classe para ativado ou não
                                            echo "<img src='../" . $imagem['imgRef'] . "' class='d-block w-100' alt='...'>";//Puxa o diretório da imagem salva no banco
                                            echo "</div>";
                                        }
                                    }
                                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#".$imovel['imID']."' data-bs-slide='prev'>";//salva o id especifico do card
                                                    echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                                                    echo "<span class='visually-hidden'>Previous</span>";
                                                echo "</button>";
                                                echo "<button class='carousel-control-next' type='button' data-bs-target='#".$imovel['imID']."' data-bs-slide='next'>";//salva o id especifico do card
                                                    echo "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                                                    echo "<span class='visually-hidden'>Next</span>";
                                                echo "</button>";
                                                echo "</div>";
                                    echo "</div>";
                                    echo "<h4 class='card-title'>" . $imovel['imDesc'] . "</h4>";//Mostra a descrição do imovel no card
                                    echo "<h5 class='card-text'>" . $imovel['imLocation'] . "</h5>";//Mostra a localização do imovel
                                    echo "<p class='card-text'>R$ " . $imovel['preco'] . ",00</p>";//Preco do imovel
                                    echo "<a href='ExcluirImovel.php?IDdoImovel=" . $imovel['imID'] ."' class='btn btn-primary'>Excluir</a>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    }
                }
            }
            else{
                echo "<p class='my-4' >Nenhum Imovel Encontrado</p>";//Mensagem na tela
            }
        ?> 
    </main>
    
    <!--Páginação-->
    
    <?php
        if(!is_null($_SESSION['RESULTADO_FILTRO'])){
            echo "<div class='container my-4 text-center' style='border: 1px solid black;'>";
        
            $max_links = 2; // Número máximo de links
            $start = max(1, $pagina_atual - $max_links);
            $end = min($total_paginas, $pagina_atual + $max_links);
        
            // Botões primeiro e anterior
            if($pagina_atual > 1){
                //Boãto primeiro
                echo "<a href='?pagina=1";
                echo "&tipo_operacao=$OPERACAO_form";
                if(isset($busca)){
                    echo "&busca=$busca";
                }
                echo "&tipo_imovel=$TIPO_IMOVEL_form";
                if(isset($DORMITORIOS_form)){
                    echo "&dormitorios_select=$DORMITORIOS_form";
                }
                if(isset($GARAGEM_form)){
                    echo "&garagem_select=$GARAGEM_form";
                }
                if(isset($MINIMO_form)){
                    echo "&minimo_valor=$MINIMO_form";
                }
                if(isset($MAXIMO_form)){
                    echo "&maximo_valor=$MAXIMO_form";
                }
                echo "&ordenacao=$ORDENACAO_form";
                echo "'>Primeiro</a> ";
                //Botão para anterior
                echo "<a href='?pagina=".($pagina_atual - 1)."";
                echo "&tipo_operacao=$OPERACAO_form";
                if(isset($busca)){
                    echo "&busca=$busca";
                }
                echo "&tipo_imovel=$TIPO_IMOVEL_form";
                if(isset($DORMITORIOS_form)){
                    echo "&dormitorios_select=$DORMITORIOS_form";
                }
                if(isset($GARAGEM_form)){
                    echo "&garagem_select=$GARAGEM_form";
                }
                if(isset($MINIMO_form)){
                    echo "&minimo_valor=$MINIMO_form";
                }
                if(isset($MAXIMO_form)){
                    echo "&maximo_valor=$MAXIMO_form";
                }
                echo "&ordenacao=$ORDENACAO_form";
                echo "'>Anterior</a> ";
            }
        
            // Links de página
            for ($i = $start; $i <= $end; $i++) {
                echo "<a href='?pagina=$i";
                echo "&tipo_operacao=$OPERACAO_form";
                if(isset($busca)){
                    echo "&busca=$busca";
                }
                echo "&tipo_imovel=$TIPO_IMOVEL_form";
                if(isset($DORMITORIOS_form)){
                    echo "&dormitorios_select=$DORMITORIOS_form";
                }
                if(isset($GARAGEM_form)){
                    echo "&garagem_select=$GARAGEM_form";
                }
                if(isset($MINIMO_form)){
                    echo "&minimo_valor=$MINIMO_form";
                }
                if(isset($MAXIMO_form)){
                    echo "&maximo_valor=$MAXIMO_form";
                }
                echo "&ordenacao=$ORDENACAO_form";
                echo "''>$i</a> ";
            }
        
            // Botões próximo e último
            if($pagina_atual < $total_paginas){
                //Botão proximo
                echo "<a href='?pagina=".($pagina_atual + 1)."";
                echo "&tipo_operacao=$OPERACAO_form";
                    if(isset($busca)){
                        echo "&busca=$busca";
                    }
                    echo "&tipo_imovel=$TIPO_IMOVEL_form";
                    if(isset($DORMITORIOS_form)){
                        echo "&dormitorios_select=$DORMITORIOS_form";
                    }
                    if(isset($GARAGEM_form)){
                        echo "&garagem_select=$GARAGEM_form";
                    }
                    if(isset($MINIMO_form)){
                        echo "&minimo_valor=$MINIMO_form";
                    }
                    if(isset($MAXIMO_form)){
                        echo "&maximo_valor=$MAXIMO_form";
                    }
                    echo "&ordenacao=$ORDENACAO_form";
                echo "'>Próximo</a> ";
                //Botão ultimo
                echo "<a href='?pagina=".$total_paginas."";
                echo "&tipo_operacao=$OPERACAO_form";
                if(isset($busca)){
                    echo "&busca=$busca";
                }
                echo "&tipo_imovel=$TIPO_IMOVEL_form";
                if(isset($DORMITORIOS_form)){
                    echo "&dormitorios_select=$DORMITORIOS_form";
                }
                if(isset($GARAGEM_form)){
                    echo "&garagem_select=$GARAGEM_form";
                }
                if(isset($MINIMO_form)){
                    echo "&minimo_valor=$MINIMO_form";
                }
                if(isset($MAXIMO_form)){
                    echo "&maximo_valor=$MAXIMO_form";
                }
                echo "&ordenacao=$ORDENACAO_form";
                echo "'>Último</a> ";
            }
        
            echo "</div>";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    
</body>
</html>