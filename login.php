<?php
    /*O que falta nesta página:
    - CSS e Javascript
    - filtrar os inputs, alem de validação de formulário
    - Otimizar o código
    */
    session_start();

    require_once("CLASSES/Classe.Cliente.php");

    $requerindo = new Cliente("maison2","localhost","root","11153025192Fd@");

    if(isset($_SESSION['mensagem_registro_novo_usuario'])) {//Mostre a mensagem caso o usuário acabou de registrar um novo usuário.
        echo $_SESSION['mensagem_registro_novo_usuario'];
    }

    if((!isset($_SESSION['cliente_id'])) && (!isset($_SESSION['cliente_adm']))){//Se o usuário não estiver logado
        if(isset($_POST['button_entrar'])){//Se o usuário enviar o formulário.
            
            $usuario_senha = $_POST['cliente_senha'];
            $usuario_cpf = $_POST['cliente_cpf'];

            $linha_resultados = $requerindo->verificarLogin($usuario_cpf, $usuario_senha);//Linha recebe a matriz da sql

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
    
    else{
        //Usuário já está logado
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAISON - CATALAGO</title>
    <link REL="SHORTCUT ICON" HREF="IMG/nav-logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="CSS/nav.css" media="screen" />
</head>
<body>
<header>
    <div class="container-fluid">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <ul class="nav navbar-nav list-group list-group-horizontal">
                    <li><a id="len1" class="hoverable list-item" href="homePage.html">Home</a></li>
                    <li><a id="len2" class="hoverable list-item" href="registrar.php">Cadastro</a></li>
                    <li><a id="len3" class="hoverable list-item" href="login.php">Login</a></li>
                    <li><a id="len4" class="hoverable list-item" href="index.php">Catálogo</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<div class="container md-4">

    <form action="" method="POST">

        <label for="cliente_cpf">CPF</label>
        <input type="text" id="cliente_cpf" name="cliente_cpf">

        <label for="cliente_senha">Senha</label>
        <input type="text" id="cliente_senha" name="cliente_senha">
        
        <input type="submit" name="button_entrar" value="ENTRAR">
    </form>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<style>
    /* Estilo para o body */
body {
    background-color: #F5F5F5; /* Cor de fundo */
    font-family: Arial, sans-serif; /* Fonte do texto */
    color: #333; /* Cor do texto */
    background-image: url('IMG/bkform.jpg');
    background-size: cover; /* Ajusta a imagem para cobrir toda a página */
    background-repeat: no-repeat; /* Evita que a imagem se repita */
}

/* Estilo para o header (navbar) */
header {
    background-color: #F5F5F5; /* Cor de fundo do cabeçalho */
    padding: 15px 0; /* Espaçamento interno */
    background: rgba(0, 0, 0, 0);
}

.navbar-expand-lg .navbar-nav .nav-link {
    color: #FFF; /* Cor do texto dos links */
    font-weight: bold; /* Texto em negrito */
}

/* Estilo para o formulário */
.container.md-4 {
    width: 50%; /* Ajuste a largura do formulário */
    margin: 0 auto; /* Centraliza o formulário na página */
    display: flex; /* Alinha os campos do formulário verticalmente */
    flex-direction: column; /* Organiza os campos do formulário em uma coluna */
    margin-top: 50px; /* Espaço acima do formulário */
    padding: 20px; /* Espaçamento interno */
    background-color: rgba(0, 0, 0, 0.3); /* Cor de fundo do formulário */
    border-radius: 10px; /* Borda arredondada */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra */
}

/* Estilo para os labels */
label {
    margin-bottom: 5px; /* Espaçamento inferior */
    display: block; /* Display em bloco para ocupar a largura total */
    font-weight: bold; /* Texto em negrito */
}

/* Estilo para os inputs */
input[type="text"],
input[type="submit"] {
    width: 100%; /* Largura total */
    padding: 8px; /* Espaçamento interno */
    margin-bottom: 10px; /* Espaçamento inferior */
    border: 1px solid #ccc; /* Borda */
    border-radius: 5px; /* Borda arredondada */
}

/* Estilo para o botão de submit */
input[type="submit"] {
    background-color: #007BFF; /* Cor de fundo */
    color: #FFF; /* Cor do texto */
    cursor: pointer; /* Cursor ao passar por cima */
    transition: background-color 0.3s; /* Transição suave */
}

input[type="submit"]:hover {
    background-color: #0056b3; /* Cor de fundo ao passar por cima */
}
</style>
</body>
</html>