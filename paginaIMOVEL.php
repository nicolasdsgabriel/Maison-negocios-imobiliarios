<?php

    error_reporting(0); // Desativa a exibição de erros
    ini_set('display_errors', 0);
    session_start();

    require_once("CLASSES/Classe.Imovel.php");
    require_once('CLASSES/Classe.Cliente.php');

    $imovelClasse = new Imovel("maison2","localhost","root","11153025192Fd@");//Objeto Imovel

    $id_do_imovel_selecionado_no_form = $_GET['Id_do_imovelSelecionado'];//Puxa o id do imovel selecionado no saiba mais.

    $imovelSelecionado = $imovelClasse->exibir_imovel_pelo_id($id_do_imovel_selecionado_no_form);//Salva o resultado do metodo 
    $imagemImovelSelecionado = $imovelClasse->exibir_imoveis_imagem($id_do_imovel_selecionado_no_form);

    $latitude = floatval($imovelSelecionado['latitude']);
    $longitude = floatval($imovelSelecionado['longitude']);

    /*
    *ESTÁ FALTANDO NESTÁ PÁGINA:
    - Adicionar os marcadores baseado no localização do imovel;
    - Adicionar o sistema da lista de desejo
    - Adicionar o formulário de pergunta ao usuário, caso o mesmo procure o imovel ou tenha interesse.
    - CSS e funcionalidades de contato
    - Adicionar a verificação de usuário
    */
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.1.0/ol.css">
    <script src="https://cdn.jsdelivr.net/npm/ol@v8.1.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <title>MAISON | Página do Imovel | <?=$imovelSelecionado['imDesc']?></title>
    <link rel="stylesheet" type="text/css" href="CSS/nav.css" media="screen" />
</head>
<body>
    <!--Inicio Cabeçalho-->
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: transparent;">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="homePage.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registrar.php">Cadastro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listaFav.php">Favoritos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

    <!--Fim Cabeçalho-->
    <!--Inicio do corpo do card do imovel-->
    <section class="carousel-section">
        <div class="carousel slide">
            <div class="img-carrosel img-fluid justify-content-center align-items-center">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="<?=$imagemImovelSelecionado[0]['imgRef']?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="<?=$imagemImovelSelecionado[1]['imgRef']?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="<?=$imagemImovelSelecionado[2]['imgRef']//Está mostrando a string que contem o diretorio da imagem?>" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
            </div>
        </div>
    </div>
        <!--Inicio da descrição do imovel-->
        <div class="card text-center">
            <div class="card-header">
                <h1 class="h1"><?=$imovelSelecionado['imTitulo']?></h1>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <p>Endereço do Imovel</p>
                    <p>Localização: <?= $imovelSelecionado['imLocation']?></p>
                    <p>CEP: <?= $imovelSelecionado['imCEP']?></p>
                </div>
                <div class="row text-center">
                    <p>Tipo do imovel: <?= $imovelSelecionado['tipo']?></p>
                </div>
            </div>
            <div class="card-footer text-body-secondary">
                <div class="row text-center">
                    <form action="ADM/EditarImovel.php" method="get">
                        <?php
                            if($_SESSION['cliente_adm'] == 1){
                                echo '

                                <a href="ADM/EditarImovel.php?id=' . $imovelSelecionado['imID'] . '">Editar Imóvel</a>
                                
                                ';
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
        
        <!--Fim da descrição do imovel-->
        <!--Inicio do mapa do imovel-->
        <div id="map" class="row" style="width: 100%; height: 500px;"></div>
        <!--Fim do mapa do imovel-->
    <!--Fim do corpo do card do imovel-->
    <script>
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([0, 0]),
                zoom: 2
            })
        });

        // Função para adicionar um marcador
        function addMarker(longitude, latitude) {
            var marker = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([longitude, latitude]))
            });

            var markerStyle = new ol.style.Style({
                image: new ol.style.Icon({
                    src: 'data:image/svg+xml,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="32" height="48" viewBox="0 0 32 48"><path fill="blue" d="M16 0c-8.837 0-16 7.163-16 16 0 8.335 11.704 28.799 15.607 31.785 0.394 0.295 0.902 0.439 1.402 0.439s1.008-0.144 1.402-0.439c3.903-2.986 15.607-23.45 15.607-31.785 0-8.837-7.163-16-16-16zm0 22c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"/></svg>'),
                    scale: 0.3 // Ajuste o tamanho do ícone conforme necessário
                })
            });

            marker.setStyle(markerStyle);

            var vectorLayer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [marker]
                })
            });

            map.addLayer(vectorLayer);
        }

        // Adicionar marcadores para endereços
        addMarker(-48.209037, -21.782651);
    </script>
    <style>
/* Estilo do título do imóvel */
.h1 {
  color: #3498db; /* Azul para o título */
  text-align: center;
}

/* Estilo para o header (navbar) */
header {
    padding: 15px 0; /* Espaçamento interno */
    background: rgba(0, 0, 0, 0);
}

.navbar-expand-lg .navbar-nav .nav-link {
    color: black; /* Cor do texto dos links */
    font-size: medium;
}
.navbar {
    background-color: transparent !important; /* Certifique-se de que a cor de fundo é transparente */
    backdrop-filter: blur(10px); /* Adicione um desfoque no fundo para maior transparência (opcional) */
    -webkit-backdrop-filter: blur(10px); /* Suporte para navegadores com base no WebKit */
    box-shadow: none !important; /* Remova qualquer sombra (opcional) */
}

/* Estilo do corpo do card do imóvel */
.imovel-pag {
  background-color: #fff; /* Fundo branco para o card */
  padding: 20px;
  margin-top: 20px;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Sombra */
}

/* Estilo dos botões */
.btn {
  background-color: #3498db; /* Azul */
  border-color: #3498db; /* Cor da borda igual ao fundo */
  color: #fff; /* Texto branco */
  padding: 8px 20px;
  border-radius: 5px;
  transition: all 0.3s ease; /* Efeito de transição */
}

.btn:hover {
  background-color: #2980b9; /* Azul mais escuro no hover */
  border-color: #2980b9; /* Cor da borda no hover */
}

/* Estilo dos links */
a {
  color: #3498db; /* Azul para links */
  text-decoration: none;
  transition: color 0.3s ease; /* Efeito de transição */
}

a:hover {
  color: #2980b9; /* Azul mais escuro no hover */
}

/* Estilo do mapa */
#map {
  margin-top: 20px;
  border-radius: 10px;
  overflow: hidden; /* Esconder partes do mapa que ultrapassam o contêiner */
}

/* Estilo para descrições e informações do imóvel */
.row p {
  color: #333; /* Cor do texto padrão */
}

.img-carrosel {
    height: 100%;
    width: 100%;
}

.card{
    font-size: large;
}
    </style>
</body>
</html>