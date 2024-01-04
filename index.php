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

    error_reporting(0); // Desativa a exibição de erros
    ini_set('display_errors', 0);

    session_start();

    require_once("BD/config.php");
    require_once("CLASSES/Classe.Imovel.php");
    require_once("CLASSES/Classe.filtro.php");
    require_once('CLASSES/Classe.Cliente.php');

    //Criando os objetos
    $imovelClasse = new Imovel("maison2","localhost","root","11153025192Fd@");//Objeto Imovel
    $imovelClasseFiltro = new Filtro("maison2","localhost","root","11153025192Fd@");//Objeto Filtro

    //verificação de login
    $requerindo_classe = new Cliente("maison2","localhost","root","11153025192Fd@");

    if((!isset($_SESSION['cliente_id'])) && (!isset($_SESSION['cliente_adm']))){//Se o usuário não estiver logado
        if(isset($_POST['button_entrar'])){//Se o usuário enviar o formulário.
            
            $usuario_senha = $_POST['cliente_senha'];
            $usuario_cpf = $_POST['cliente_cpf'];
    
            $linha_resultados = $requerindo_classe->verificarLogin($usuario_cpf, $usuario_senha);

            if (count($linha_resultados) > 0){//Se houver alguma linha na matriz resultado
                for ($i = 0; $i < count($linha_resultados) ; $i++) { 
                    foreach ($linha_resultados[$i] as $key => $value) {
                        if($key == 'clienteID'){
                            $_SESSION['cliente_id'] = $value;//Salvar o valor do vetor para a sessão, para que os outros arquivos usem a sessão
                        }
                        if($key == 'clienteNome'){
                            $_SESSION['clienteNome'] = $value;
                        }
                        if($key == 'adm'){
                            $_SESSION['cliente_adm'] = $value;
                        }
                    }
                }
            }
        }
    }
    //------------------------------------------------------------

    $_SESSION['INPUT_BUSCA'] = $busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);//Atribua-se na variavel busca um filtro para o campo preenchido no formulário de busca, onde este filtro protege o banco de dados de códigos mal intencionado no sistema de busca.
    $_SESSION['INPUT_OPERACAO_form'] = $OPERACAO_form = filter_input(INPUT_GET, 'tipo_operacao', FILTER_SANITIZE_STRING);//A variavel recebe o valor presente no campo 'operacao' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $_SESSION['INPUT_TIPO_IMOVEL_form'] = $TIPO_IMOVEL_form = filter_input(INPUT_GET, 'tipo_imovel', FILTER_SANITIZE_STRING);//A variavel recebe o valor presente no campo 'tipo_imovel' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $_SESSION['INPUT_DORMITORIOS_form'] = $DORMITORIOS_form = filter_input(INPUT_GET, 'dormitorios_select', FILTER_SANITIZE_NUMBER_INT);//A variavel recebe o valor presente no campo 'dormitorios' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $_SESSION['INPUT_GARAGEM_form'] = $GARAGEM_form = filter_input(INPUT_GET, 'garagem_select', FILTER_SANITIZE_NUMBER_INT);//A variavel recebe o valor presente no campo 'garagem_select' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $_SESSION['INPUT_MINIMO_form'] = $MINIMO_form = filter_input(INPUT_GET, 'minimo_valor', FILTER_SANITIZE_NUMBER_INT);//A variavel recebe o valor presente no campo 'minimo_valor' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $_SESSION['INPUT_MAXIMO_form'] = $MAXIMO_form = filter_input(INPUT_GET, 'maximo_valor', FILTER_SANITIZE_NUMBER_INT);//A variavel recebe o valor presente no campo 'maximo_valor' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL
    $_SESSION['INPUT_ORDENACAO_form'] = $ORDENACAO_form = filter_input(INPUT_GET, 'ordenacao', FILTER_SANITIZE_STRING);//A variavel recebe o valor presente no campo 'ordenacao' do formulário de maneira a filtrar as informaçoes recebidas, onde não se passa nenhum tipo de comando SQL

    $_SESSION['RESULTADO_FILTRO'] = $imovelClasseFiltro->BUSCAR($busca, $OPERACAO_form, $TIPO_IMOVEL_form, $DORMITORIOS_form, $GARAGEM_form, $MINIMO_form, $MAXIMO_form);
   
    //-------------------------------------------SISTEMA DA PAGINAÇÃO------------------------------------------------------------------
    if(!is_null($_SESSION['RESULTADO_FILTRO'])){//Se o resultado do filtro não for nulo, então prossiga

        // Ordena o array usando usort e a função de comparação
        if(isset($_SESSION['INPUT_ORDENACAO_form'])){
            if($_SESSION['INPUT_ORDENACAO_form'] == 'maior'){
                usort($_SESSION['RESULTADO_FILTRO'], function($a, $b){
                    return $b['preco'] <=> $a['preco'];//Está ordenando o array $_SESSION['RESULTADO_FILTRO'] em ordem decrescente com base nos valores da chave 'preco' de seus elementos.
                });
            }
            else if($_SESSION['INPUT_ORDENACAO_form'] == 'menor'){
                usort($_SESSION['RESULTADO_FILTRO'], function($a, $b){
                    return $a['preco'] <=> $b['preco'];//Está ordenando o array $_SESSION['RESULTADO_FILTRO'] em ordem crescente com base nos valores da chave 'preco' de seus elementos.
                });                
            }
        }

        // Defina o número de resultados por página
        $por_pagina = 6;

        // Obtenha o número da página atual ou defina como 1 se não estiver definido
        $pagina_atual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

        // Calcule o início do slice do array
        $inicio = ($pagina_atual - 1) * $por_pagina;

        // Calcule o número total de páginas
        $total_paginas = ceil(count($_SESSION['RESULTADO_FILTRO']) / $por_pagina);

        // Obtenha os dados para a página atual
        $resultados = array_slice($_SESSION['RESULTADO_FILTRO'], $inicio, $por_pagina);
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAISON - CATALAGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link REL="SHORTCUT ICON" HREF="IMG/nav-logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="CSS/nav.css" media="screen" />
</head>
<body>
<header>
    <div class="container-fluid">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <ul class="nav navbar-nav list-group list-group-horizontal">
                    <li><?php
                            if($_SESSION['cliente_adm'] == 1){
                                echo '<a id="len1" class="hoverable list-item" href="ADM/indexAdm.php">Administrador</a>';
                            }
                    ?></li>
                    <li><a id="len1" class="hoverable list-item" href="homePage.html">Home</a></li>
                    <li><a id="len2" class="hoverable list-item" href="registrar.php">Cadastro</a></li>
                    <li><a id="len3" class="hoverable list-item" href="login.php">Login</a></li>
                    <li><a id="len3" class="hoverable list-item" href="logout.php">Logout</a></li>
                    <li><a id="len4" class="hoverable list-item" href="index.php">Catálogo</a></li>
                    <li><a id="len4" class="hoverable list-item" href="listaFav.php">Favoritos</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
    <!-- 44 <-> 53 é aonde está alojado no código o formulário do de busca por texto -->
    <section>
        <div class="container my-4 align_items-center filtro">
            <div class="row">
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
                            <input type="submit" class="btn" value="BUSCAR" name="btn-buscar">
                        </div>
                        <div class="col-auto d-inline">
                            <a href="index.php" class="btn">RESETAR O FILTRO</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--Fim do formulário de busca-->
    <main class="container text-center">
        <div class="mx-auto">
        <!-- Catálogo de imoveis, onde começa os cards -->
        <?php
            if((!is_null($_SESSION['RESULTADO_FILTRO']))){//Se o método da classe filtro retornar o array e não NULL
                if(count($_SESSION['RESULTADO_FILTRO']) > 0){//Se existir alguma linha nas tabelas
                    $contador = 0;
                    foreach ($resultados as $resultado => $imovel) {//Para podermos acessar as colunas da matriz gerada na função anterior
                        if ($contador % 3 == 0) { // Se o contador é divisível por 3
                            if ($contador > 0) {
                                echo '</div>'; // Fecha a div row se não for a primeira
                            }
                            echo '<div class="row d-flex justify-content-center align-items-center">'; // Abre uma nova div row
                        }
                        
                        echo "<div class='col-sm-3 p-2 my-5'>";
                            echo "<div class='card my-2'>";
                                echo "<div class='card-body'>";
                                    $imagens = $imovelClasse->exibir_imoveis_imagem($imovel['imID']);//$imagem recebe a matriz resultante da função exibir_imoveis_imagem(), onde a função retorna uma matriz[linhas][colunas de cada linha]
                                    echo "<div id='".$imovel['imID']."' class='carousel slide'>";//Identificamos os cards de acordo com o id do imovel.
                                    echo "<div class='carousel-inner'>";
                                    if(count($imagens)>0){//Se existir linhas na tabela imagems, prossiga
                                        foreach ($imagens as $j => $imagem) {//Para podemos selecionar as informações necessárias.
                                            echo "<div class='carousel-item " . ($j === 0 ? 'active' : '') . "'>";//if para poder mudar a classe para ativado ou não
                                                echo "<img src='" . $imagem['imgRef'] . "' class='card-img-top img-fluid' alt='...'>";//Puxa o diretório da imagem salva no banco
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
                                    
                                    if(isset($_SESSION['cliente_id'])){
                                        $IDcliente = intval($_SESSION['cliente_id']);
                                        $IDimovel = intval($imovel['imID']);
                                        $listaDesejo = $requerindo_classe->ListarDesejoUnico($IDcliente, $IDimovel);
                                        if(!is_bool($listaDesejo)){
                                            if($listaDesejo["flagFav"] == 1){ //If para verificar o valor da flag
                                                echo 
                                                "<a href=\"#\" class=\"flagFav\" title=\"Favorito\" id='".$listaDesejo["CatalogoID"]."'>
                                                <i class=\"bi bi-star-fill\"></i>
                                                </a>";
                                            
                                            }else{
                                                echo 
                                                "<a href=\"#\" class=\"flagFav\" title=\"Não Favorito\" id='".$listaDesejo["CatalogoID"]."'>
                                                <i class=\"bi bi-star\"></i>
                                                </a>";
                                            }
                                        }
                                        else{
                                            echo "<a href='AdicionaFavoritos.php?imovel=".$IDimovel."' title='Não Favorito' id='{$IDimovel}'><i class='bi bi-star'></i></a>";
                                        }
                                    }
                                echo "</div>";
                                //input type hidden por causa das informações salvas
                                echo "<form action='paginaIMOVEL.php' method='GET'>";
                                    echo "<input type='hidden' value='" . $imovel['imID'] . "' name='Id_do_imovelSelecionado'>";
                                    echo "<input type='submit' value='Saiba Mais' class='btn' name='saiba_mais'>";
                                echo "</form>";
                                /*
                                echo "<pre>";
                                var_dump($imovel);
                                echo "</pre>";
                                */
                            echo "</div>";
                        echo "</div>";
                        $contador++;
                    }
                    if ($counter > 0) {
                        echo '</div>'; // Fecha a última div row
                    }
                }
            }
            else{
                echo "<p class='my-4' >Nenhum Imovel Encontrado</p>";//Mensagem na tela
            }
        ?>
        </div>
    </main>
    <!-- Paginação -->
    <section>
    <?php
        if(!is_null($_SESSION['RESULTADO_FILTRO'])){
            echo "<div class='container mt-5'>";
                echo "<nav aria-label='Page navigation'>";
                    echo "<ul class='pagination'>";
        
                        $max_links = 2; // Número máximo de links
                        $start = max(1, $pagina_atual - $max_links);
                        $end = min($total_paginas, $pagina_atual + $max_links);
                    
                        // Botões primeiro e anterior
                        if($pagina_atual > 1){
                            //Boãto primeiro
                            echo "<li class='page-item'>";
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
                            echo "</li>";
                            //Botão para anterior
                            echo "<li class='page-item'>";
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
                            echo "</li>";
                        }
                    
                        // Links de página
                        for ($i = $start; $i <= $end; $i++) {
                            echo "<li class='page-item'>";
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
                            echo "</li>";
                        }
                    
                        // Botões próximo e último
                        if($pagina_atual < $total_paginas){
                            //Botão proximo
                            echo "<li class='page-item'>";
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
                            echo "</li>";
                            //Botão ultimo
                            echo "<li class='page-item'>";
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
                            echo "</li>";
                        }
                    echo "</ul>";
                echo "</nav>";
            echo "</div>";
        }
    ?>
    </section>
    <script src="JS/jquery-3.7.1.js"></script>
    <script src="JS/flagFav.js"></script>
    <script src="JS/nav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <style>
        .filtro{
            background-color: rgba(0, 0, 0, 0.1); /* Cor de fundo do formulário */
            color: black;
            border-radius: 10px;
        }
        body{
            background-color: #F5F5F5; 
        }
        
        .card-container {
            display: flex;
            justify-content: space-between; 
            margin-bottom: 20px;
        }

        .card {
            margin-top: 30px;
            height: 500px;
        }

        .card-fix-height {
            height: 100%;
        }
        
        .card-body {
        height: 100%; /* Garante que o corpo do card preencha toda a altura do card */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Alinha os elementos internos */
        }
        
        .card-img-top{
            width: 100%; /* Ajusta a largura da imagem para ocupar 100% do card */
            height: auto;
        }
        
        .btn{
            width: 100%;
            margin-bottom: 2px;
            background-color: blue;
            color: #F5F5F5;
        }
    </style>
    <script>
        // Não é necessário require para conexão no contexto do navegador

        // EventListener para o clique nas flags

        document.addEventListener('DOMContentLoaded', function (e) {

            e.preventDefault();
            
            var flagsImoveis = document.getElementsByClassName('flagFav');

            for (var i = 0; i < flagsImoveis.length; i++) {
                flagsImoveis[i].addEventListener('click', function () {
                    var catalagoID = this.getAttribute('id');
                    var statusFavorito = this.getAttribute('name');
                    

                    console.log('catalogo ID:', catalagoID);
                    console.log('Status Favorito:', statusFavorito);

                    // AJAX para atualizar o banco de dados
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'atualizaFavoritos.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    
                    xhr.send(JSON.stringify({ catalagoID, statusFavorito }));

                    if (statusFavorito === 'Favorito') {
                        this.setAttribute('name', 'Não Favorito');
                        this.querySelector('i').setAttribute('class', 'bi bi-star');
                    } else {
                        this.setAttribute('name', 'Favorito');
                        this.querySelector('i').setAttribute('class', 'bi bi-star-fill');
                    }
                });
            };
        });
    </script>
</body>
</html>