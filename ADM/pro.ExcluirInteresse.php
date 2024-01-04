<?php
    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Cliente.php');

    $requerindo_classe = new Cliente("maison2","localhost","root","11153025192Fd@");

    $IDcatalogo = isset($_GET['IDcatalogo']) ? $_GET['IDcatalogo'] : null;
    
    if ($IDcatalogo) {
        //Faz um update na tabela catalogo para o id do cliente e imovel
        $Excluir = $requerindo_classe->DeletarDesejo($IDcatalogo);
        if ($Excluir){
            echo "Interesse ecxluido";
            header("Location: interessados.php");
        } else {
            die("Falha ao excluir o registro");
        }
    } else {
        die("Valores de entrada inválidos");
    }
?>