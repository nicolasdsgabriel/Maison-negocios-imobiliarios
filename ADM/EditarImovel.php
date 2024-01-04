<?php

    error_reporting(0); // Desativa a exibição de erros
    ini_set('display_errors', 0);
    session_start();

    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Imovel.php');
    require_once('../CLASSES/Classe.Cliente.php');
    
    $IDdoImovelSelecionado = $_GET['id'];

    //Criando os objetos
    $imovelClasse = new Imovel("maison2","localhost","root","11153025192Fd@");//Objeto Imovel

    $InfoImovel = $imovelClasse->exibir_imovel_pelo_id($IDdoImovelSelecionado);
    $InfoImagemsImovel = $imovelClasse->exibir_imoveis_imagem($IDdoImovelSelecionado);

    if(isset($_POST['Alterar'])){
        //Primeiro altera a tabela imovel e depois a imagems, quando o usuário apertar em exlcuir, ele será direcionado para uma outra página php que exclui as imagem e 
        //Salva as informações
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Editar Imovel</title>
    <link rel="stylesheet" type="text/css" href="../CSS/nav.css" media="screen" />
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: transparent;">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../homePage.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../registrar.php">Cadastro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listaFav.php">Favoritos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
    <div class="container mb-5 mt-5 p-5" style="border: 1px solid black; background-color: whitesmoke; overflow-y: auto; max-height: 500px;">
    <?php
        foreach($InfoImagemsImovel as $indice => $imagem){
            echo "<div class='row mb-5 mt-5 p-3 align-items-center'>";
                echo "<div class='col-6'>";
                    echo "<img class='img-fluid rounded' src='../{$imagem['imgRef']}'>";
                echo "</div>";
                echo "<div class='col-6 text-center'>";
                    echo "<a href='processaExcluirImagem.php?ID={$imagem['imgID']}&IDdoImovel={$IDdoImovelSelecionado}' class='btn btn-primary'>Excluir</a>";
                echo "</div>";
            echo "</div>";
        }
    ?>
    </div>
        
    <!--Formulário que puxa as nova informações-->
    
    <div class="container mb-5">
    <form action="processaEditarCampos.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="idImovel" value="<?=$IDdoImovelSelecionado?>">

        <div class="mb-3">
            <label for="arquivos" class="form-label">Adicionar uma ou mais imagens:</label>
            <input type="file" class="form-control" name="arquivos[]" multiple>
        </div>

        <div class="mb-3">
            <label for="titulo_imovel" class="form-label">Titulo do Imóvel:</label>
            <input type="text" class="form-control" id="titulo_imovel" name="titulo_imovel" value="<?=$InfoImovel['imTitulo']?>">
        </div>

        <div class="mb-3">
            <label for="descricao_imovel" class="form-label">Descrição do Imóvel:</label>
            <input type="text" class="form-control" id="descricao_imovel" name="descricao_imovel" value="<?=$InfoImovel['imDesc']?>">
        </div>

        <div class="mb-3">
            <label for="localizacao_imovel" class="form-label">Endereço do Imóvel:</label>
            <input type="text" class="form-control" id="localizacao_imovel" name="localizacao_imovel" value="<?=$InfoImovel['imLocation']?>">
        </div>

        <div class="mb-3">
            <label for="cep_imovel" class="form-label">CEP do Imóvel:</label>
            <input type="text" class="form-control" id="cep_imovel" name="cep_imovel" value="<?=$InfoImovel['imCEP']?>">
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label><!--Selec do tipo de Imovel: Casa, Apartamento, Kitnet-->
            <input type="text" class="form-control" id="tipo" name="tipo" value="<?=$InfoImovel
            ['tipo']?>">
        </div>

        <div class="mb-3">
            <label for="preco" class="form-label">Preço:</label>
            <input type="text" class="form-control" id="preco" name="preco" value="<?=$InfoImovel
            ['preco']?>">
        </div>

        <div class="mb-3">
            <label for="numero_dormitorio" class="form-label">Número de Dormitórios:</label>
            <input type="text" class="form-control" id="numero_dormitorio" name="numero_dormitorio" value="<?=$InfoImovel
            ['qtdDormitorios']?>">
        </div>

        <div class="mb-3">
            <label for="operacao_imovel" class="form-label">Operação do Imóvel:</label><!--Select da operação: Venda, aluguel ou os dois-->
            <input type="text" class="form-control" id="operacao_imovel" name="operacao_imovel" value="<?=$InfoImovel
            ['imOperacao']?>">
        </div>

        <div class="mb-3">
            <label for="numero_garagem" class="form-label">Número de Garagens:</label>
            <input type="text" class="form-control" id="numero_garagem" name="numero_garagem" value="<?=$InfoImovel
            ['qtdGaragem']?>">
        </div>

        <div class="mb-3">
            <label for="numero_cozinha" class="form-label">Número de Cozinhas:</label>
            <input type="text" class="form-control" id="numero_cozinha" name="numero_cozinha" value="<?=$InfoImovel
            ['qtdCozinha']?>">
        </div>

        <div class="mb-3">
            <label for="numero_lavanderia" class="form-label">Número de Lavanderias:</label>
            <input type="text" class="form-control" id="numero_lavanderia" name="numero_lavanderia" value="<?=$InfoImovel
            ['qtdLavanderia']?>">
        </div>

        <div class="mb-3">
            <label for="numero_banheiro" class="form-label">Número de Banheiros:</label>
            <input type="text" class="form-control" id="numero_banheiro" name="numero_banheiro" value="<?=$InfoImovel
            ['qtdBanheiro']?>">
        </div>

        <div class="mb-3">
            <label for="numero_sala" class="form-label">Número de Salas:</label>
            <input type="text" class="form-control" id="numero_sala" name="numero_sala" value="<?=$InfoImovel
            ['qtdSala']?>">
        </div>

        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude:</label>
            <input type="text" class="form-control" id="latitude" name="latitude" value="<?=$InfoImovel
            ['latitude']?>">
        </div>

        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude:</label>
            <input type="text" class="form-control" id="longitude" name="longitude" value="<?=$InfoImovel
            ['longitude']?>">
        </div>

        <button type="submit" name="Alterar" class="btn btn-primary">Salvar Alterações</button>
    </form>
    </div>
    
</body>
</html>