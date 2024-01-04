<?php

    //Primeiro ele pega o ID do imovel e depois exclui o imovel com base no id passado
    //Verifica se deletou, então apresente uma mensagem na tela
    //

    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Imovel.php');

    //Criando os objetos
    $imovelClasse = new Imovel("maison2","localhost","root","11153025192Fd@");//Objeto Imovel
    
    //Puxando o ID da url
    $IDdoImovelSelecionado = $_GET['IDdoImovel'];

    $ImovelSelecionado = $imovelClasse->exibir_imovel_pelo_id($IDdoImovelSelecionado);
    $ImovelSelecionadoImagems = $imovelClasse->exibir_imoveis_imagem($IDdoImovelSelecionado);

    if (isset($_POST['excluir'])){
        //Retorna um true caso tudo seja excluido
        if ($imovelClasse->ExcluiTudoImovelSelecionado($IDdoImovelSelecionado)){
            $mensagem = "Imovel Deletado";
        }
        else{
            $mensagem = "Falha ao deletar Imovel";
        }
    }

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Imovel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f5f9; /* Cor de fundo do corpo */
            color: #333; /* Cor do texto */
        }

        pre{
            margin-top: 100px;
        }

        h1 {
            color: #1f487e; /* Cor do cabeçalho principal */
            text-align: center;
            margin-top: 30px;
        }

        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #1f487e; /* Cor de fundo do botão */
            color: #fff; /* Cor do texto do botão */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #15325a; /* Cor de fundo do botão ao passar o mouse */
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
    <?php
        echo "<pre>";
        var_dump($ImovelSelecionado, $ImovelSelecionadoImagems);
        echo "</pre>";

        if (isset($mensagem)) {
            echo $mensagem;
            header("Location: GerenciadorImovel.php");
        }
    ?>
    <form action="" method="POST">
        <input type="hidden" name="ID" value="<?=$IDdoImovelSelecionado?>">
        <input type="submit" name="excluir" value="EXCLUIR IMOVEL SELECIONADO">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</body>
</html>