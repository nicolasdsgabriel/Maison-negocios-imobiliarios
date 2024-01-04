<?php

    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Imovel.php');

    //$IDdoUsuario = $_SESSION['cliente_ID'];//Salva o id do usuário para passar ao banco de dados
    $IDdoUsuario = 1;
    $imovelClasse = new Imovel("maison2","localhost","root","11153025192Fd@");//Objeto Imovel''

    $idimovel = $_GET['IDdoImovel'];

    // Verifica se o ID foi definido
    if (isset($_GET['ID'])){
        // Define as opções para o filtro
        $options = array(
            'options' => array(
                'min_range' => 0  // O valor mínimo permitido é 0
            )
        );
        // Filtra o ID para garantir que seja um número inteiro maior ou igual a zero
        $id = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT, $options);
        // Verifica se o ID é válido
        if ($id !== false) {
            // Se o ID for válido, exclui a imagem com o ID correspondente
            $ExcluirImagem = $imovelClasse->ExcluirImagemID($id);
            if ($ExcluirImagem){
                header("Location: EditarImovel.php?IDdoImovel={$idimovel}");
            }
        }
        else {
            // Se o ID não for válido, exibe uma mensagem de erro
            die("Valor do ID inválido, deve ser um valor igual ou maior que 0");
        }
    }

?>