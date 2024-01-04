<?php
    //Este documento é responsavel pela conexão com o banco de dados! a senha do banco de dados na sala de aula é "aluno", deve-se mudar depois que entramos no nosso pessoal
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=maison2", "root", '11153025192Fd@'); //19/09 - Coloquei o nome do banco de "maison2" por causa do banco existente no wordpress.
        //echo "Conexão com banco de dados foi realizada com sucesso" . "<br>"; // mensagem para aparecer na tela
    }
    catch(PDOException $e){
        echo "Falha: " . $e->getMessage();
        exit();
    }
?>