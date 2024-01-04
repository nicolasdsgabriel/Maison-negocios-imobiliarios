<?php
    //Neste código, deve salvar as novas informações alem de verificar se foi adicionado uma ou mais imagem, caso foi adicionado,
    //então salve no diretorio, caso de algum erro, então pare o código, alem de adicionar no banco as novas imagem
    
    //Fazer o update primeiro no imovel depois na imagem

    //Pega o id do usuário e salva quem adicionou a imagem

   

    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Imovel.php');

    //$IDdoUsuario = $_SESSION['cliente_ID'];//Salva o id do usuário para passar ao banco de dados
    $IDdoUsuario = 1;
    $imovelClasse = new Imovel("maison2","localhost","root","11153025192Fd@");//Objeto Imovel

    $IDimovelForm = $_POST['idImovel'];
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

    $AtualizarImovel = $imovelClasse->AtualizarImovel($IDimovelForm, $TituloDoImovel, $DescricaoDoImovel, $EnderecoDoImovel, $CEPDoImovel, $TipoDoImovel, $PrecoDoImovel, $DormitoriosDoImovel, $OperacaoDoImovel, $GaragemDoImovel, $CozinhaDoImovel, $LavanderiaDoImovel, $BanheiroDoImovel, $SalaDoImovel, $latitudeDoImovel, $longitudeDoImovel);

    if($AtualizarImovel){//Se o Update deu certo, então prossiga    
        if (isset($_FILES['arquivos']) && !is_null($_FILES['arquivos']) && !empty($_FILES['arquivos']) && !empty($_FILES['arquivos']['tmp_name'][0])){
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
                        $salvarNoBanco = $imovelClasse->AdicionarImagemsParaImovelComOid($IDdoUsuario, $diretorio, $IDimovelForm);
                        if ($salvarNoBanco){
                            header("Location: EditarImovel.php?IDdoImovel={$IDimovelForm}");//Adicionado a Nova imagem e os campos
                        }
                        else {
                            die("Falha ao salvar diretório no banco de dados.");
                        }
                    }
                    else{
                        die("Falha ao enviar arquivo no diretorio.");
                    }
                }
            }
        }
        else {
            header("Location: EditarImovel.php?IDdoImovel={$IDimovelForm}");
        }
    }
    else {
        die("Erro ao atualizar os campos do formulário do Imovel");
    }
    echo "<a href='EditarImovel.php?IDdoImovel={$IDimovelForm}'>Voltar</a>";
?>