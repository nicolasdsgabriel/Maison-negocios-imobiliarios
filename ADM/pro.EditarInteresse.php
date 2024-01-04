<?php
    require_once('../BD/config.php');
    require_once('../CLASSES/Classe.Cliente.php');

    $requerindo_classe = new Cliente("maison2","localhost","root","11153025192Fd@");

    $DesejaContato = isset($_GET['deseja_contato']) ? $_GET['deseja_contato'] : null;
    $FeitoContato = isset($_GET['feito_contato']) ? $_GET['feito_contato'] : null;
    $IDcliente = isset($_GET['idc']) ? $_GET['idc'] : null;
    $IDimovel = isset($_GET['idm']) ? $_GET['idm'] : null;

    if ($DesejaContato && $FeitoContato && $IDcliente && $IDimovel) {
        //Faz um update na tabela catalogo para o id do cliente e imovel
        $Alterar = $requerindo_classe->AlterarDesejo($IDimovel, $IDcliente, $DesejaContato, $FeitoContato);
        if ($Alterar){
            header("Location: ManipularInteresse.php?IDcliente={$IDcliente}}&IDimovel={$IDimovel}");
        } else {
            die("Falha ao atualizar o registro");
        }
    } else {
        die("Valores de entrada inválidos");
    }
?>