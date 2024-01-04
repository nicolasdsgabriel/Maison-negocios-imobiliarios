<?php
    /**
     * Falta:
     * Validação de login, ou seja, o usuário so pode enviar se estiver logado
     *CSS
        * Validação de formulário
        * Fazer os inserts no banco de dados
        * Filtros no post's
    */

    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Imovel.php');

    //$IDdoUsuario = $_SESSION['cliente_ID'];//Salva o id do usuário para passar ao banco de dados
    $IDdoUsuario = 1;
    $imovelClasse = new Imovel("maison2","localhost","root","11153025192Fd@");//Objeto Imovel

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Primeiro os inserts na tabela e depois os inserts no banco de dados
        //Adicionar os atributos do imovel primeiro e depois o id do "usuário adiministrador que está logado" na tabela onde está as imagems
        //Primeiro adiciona-se os itens em uma tabela 

        $TituloDoImovel = $_POST['titulo_imovel'];
        $DescricaoDoImovel = $_POST['descricao_imovel'];
        $EnderecoDoImovel = $_POST['localizacao_imovel'];
        $CEPDoImovel = $_POST['cep_imovel'];
        $TipoDoImovel = $_POST['tipo'];//Casa, Kitnet, Apartamento
        $PrecoDoImovel = $_POST['preco'];
        $DormitoriosDoImovel = $_POST['numero_dormitorio'];
        $OperacaoDoImovel = $_POST['operacao_imovel'];//Aluguel, comprar ou os dois.
        $GaragemDoImovel = $_POST['numero_garagem'];
        $CozinhaDoImovel = $_POST['numero_cozinha'];
        $LavanderiaDoImovel = $_POST['numero_lavanderia'];
        $BanheiroDoImovel = $_POST['numero_banheiro'];
        $SalaDoImovel = $_POST['numero_sala'];
        $latitudeDoImovel = $_POST['latitude'];
        $longitudeDoImovel = $_POST['longitude'];

        $unique_id = uniqid();
        $random_int = random_int(100, 999);

        // Concatenando o ID único e o número aleatório
        $identificadorUnicoDeUmImovel = $unique_id . $random_int;

        $AdicionaImovelNovo = $imovelClasse->AdicionarImovel($TituloDoImovel, $DescricaoDoImovel, $EnderecoDoImovel, $CEPDoImovel, $TipoDoImovel, $PrecoDoImovel, $DormitoriosDoImovel, $OperacaoDoImovel, $GaragemDoImovel, $CozinhaDoImovel, $LavanderiaDoImovel, $BanheiroDoImovel, $SalaDoImovel, $latitudeDoImovel, $longitudeDoImovel, $identificadorUnicoDeUmImovel);

        if($AdicionaImovelNovo){//Se adicionar os itens na tabela imovel, então verifique os arquivos e adicione as imagems do imovel adicionado
            if (isset($_FILES['arquivos'])){
                $arquivos = $_FILES['arquivos'];
                $nomeDoArquivos = $arquivos['name'];
                $nomeTemp = $arquivos['tmp_name'];
                $pasta = "../IMG/";
                foreach($nomeDoArquivos as $indice => $nomeDoArquivo){
                    $extensao =  strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
                    if ($arquivos['error'][$indice]) {
                        die("Falha ao enviar arquivo");
                    }
                    if($arquivos['size'][$indice] > 2097152){//Se o arquivo for maior que 2 Mega, não aceite
                        die("Arquivo Muito Grande: MAX 2MB");
                    }
                    if ($extensao != "jpeg" && $extensao != "jpg" && $extensao != "png") {
                        die("Tipo de arquivo não aceito, somente .jpeg, .jpg e .png");
                    }
                    else{
                        $novoNomeDoArquivo = uniqid();
                        $envio = move_uploaded_file($nomeTemp[$indice], $pasta . $novoNomeDoArquivo . "." . $extensao);
                        if ($envio){
                            //echo "<p>Arquivo enviado com sucesso: </p><a target=\"_blank\" href=\"../IMG/$novoNomeDoArquivo.$extensao\">Clique Aqui</a>";
                            $diretorio = "IMG/" . $novoNomeDoArquivo . "." . $extensao;
                            $salvarNoBanco = $imovelClasse->AdicionarImagemsParaImovel($IDdoUsuario, $diretorio, $identificadorUnicoDeUmImovel);
                            if ($salvarNoBanco){
                                echo "<p>Imagem do imovel salva no banco de dados.</p>";
                            }
                            else {
                                die("Falha ao salvar diretório no banco de dados.");
                            }
                        }
                        else{
                            die("Falha ao enviar arquivo no servidor.");
                        }
                    }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM | Adicionar Imovel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f5f9; /* Cor de fundo do corpo */
            color: #333; /* Cor do texto */
        }

        h1 {
            color: #1f487e; /* Cor do cabeçalho principal */
            text-align: center;
            margin-top: 100px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        input[type="text"],
        input[type="file"],
        input[type="submit"] {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
        }

        input[type="file"] {
            width: auto;
            padding: 0;
        }

        input[type="submit"] {
            background-color: #1f487e; /* Cor de fundo do botão */
            color: #fff; /* Cor do texto do botão */
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: auto;
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
    <h1>Adicionar Imagems</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="arquivos[]" multiple required>

        <label for="titulo_imovel">Titulo do Imóvel:</label>
        <input type="text" id="titulo_imovel" name="titulo_imovel">

        <label for="descricao_imovel">Descrição do Imóvel:</label>
        <input type="text" id="descricao_imovel" name="descricao_imovel">

        <label for="localizacao_imovel">Endereço do Imóvel:</label>
        <input type="text" id="localizacao_imovel" name="localizacao_imovel">

        <label for="cep_imovel">CEP do Imóvel:</label>
        <input type="text" id="cep_imovel" name="cep_imovel">

        <label for="tipo">Tipo:</label>
        <input type="text" id="tipo" name="tipo">

        <label for="preco">Preço:</label>
        <input type="text" id="preco" name="preco">

        <label for="numero_dormitorio">Número de Dormitórios:</label>
        <input type="text" id="numero_dormitorio" name="numero_dormitorio">

        <label for="operacao_imovel">Operação do Imóvel:</label>
        <input type="text" id="operacao_imovel" name="operacao_imovel">

        <label for="numero_garagem">Número de Garagens:</label>
        <input type="text" id="numero_garagem" name="numero_garagem">

        <label for="numero_cozinha">Número de Cozinhas:</label>
        <input type="text" id="numero_cozinha" name="numero_cozinha">

        <label for="numero_lavanderia">Número de Lavanderias:</label>
        <input type="text" id="numero_lavanderia" name="numero_lavanderia">

        <label for="numero_banheiro">Número de Banheiros:</label>
        <input type="text" id="numero_banheiro" name="numero_banheiro">

        <label for="numero_sala">Número de Salas:</label>
        <input type="text" id="numero_sala" name="numero_sala">

        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude">

        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude">

        <input type="submit" value="Adicionar">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</body>
</html>