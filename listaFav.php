<?php
session_start();
require_once('BD/config.php');
require_once('CLASSES/Classe.Cliente.php');

$flagFav = 1;

// Consulta SQL com JOIN para obter os dados dos imóveis favoritos
$stmt = $pdo->prepare("SELECT C.CatalogoID AS imID, I.imlocation AS imLocation, I.preco 
                        FROM Catalogo C
                        INNER JOIN Imoveis I ON C.imID = I.imID
                        WHERE C.flagFav = ?");
$stmt->execute([$flagFav]);

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obter os resultados da consulta

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

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Favoritos</title>
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
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Localização</th>
                <th scope="col">Preço</th>
                <!-- Adicione mais colunas conforme necessário -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $linha): ?>
                <tr>
                    <td><?php echo $linha['imID']; ?></td>
                    <td><?php echo $linha['imLocation']; ?></td>
                    <td><?php echo $linha['preco']; ?></td>
                    <!-- Adicione mais colunas conforme necessário -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</body>
</html>
