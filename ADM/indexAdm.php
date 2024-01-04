<?php
require_once("../BD/config.php");
require_once('../CLASSES/Classe.Cliente.php');

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.15.1/devicon.min.css">
  <style>

    #boasVINDA:hover {
      transition: transform 0.7s ease-in-out;
      transform: scale(1.05);
    }

    /* Adicione esta regra CSS para criar a animação */
    @keyframes colorchange {
        0%   {background-color: #29b6f6;}
        25%  {background-color: #4fc3f7;}
        50%  {background-color: #81d4fa;}
        75%  {background-color: #4fc3f7;}
        100% {background-color: #29b6f6;}
    }

    /* Aplique a animação ao seu card */
    #boasVINDA {
      animation: colorchange 7s infinite;
      transition: transform 0.7s ease-in-out;
      transform: scale(1);
    }

    .nav-link {
      transition: color 0.5s ease;
    }
    
    .nav-link:hover {
      color: white;
      font-style: italic;
      font-weight: bold;
      background-color: #29b6f6;
    }

    nav {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 100;
    }

    main {
      padding-top: 100px; /* Altura da navbar */
      min-height: calc(100vh - 70px - 80px); /* Altura total menos altura da navbar e do footer */
      flex: 1 0 auto;
    }
  </style>

  <title>Página Principal do Administrador</title>
  <link REL="SHORTCUT ICON" HREF="IMG/nav-logo.png">
  <link rel="stylesheet" type="text/css" href="../CSS/footer.css" media="screen" />
</head>
<body>
  <header>
      <nav class="navbar navbar-expand-lg fixed-top" style="background-color: white;">
          <div class="container-fluid">
              <a class="navbar-brand" href="indexAdm.php">MAISON</a>
              <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class='nav-link' href='../logout.php'>Deslogar</a>
                    </li>
                    <li class="nav-item">
                        <a class='nav-link' href='ListaCliente.php'>Listar Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class='nav-link' href='GerenciadorImovel.php'>Gerenciador de Imoveis</a>
                    </li>
                    <li class="nav-item">
                        <a class='nav-link' href='interessados.php'>Interessados</a>
                    </li>
                    <li class="nav-item">
                      <a class='nav-link' href='../index.php'>Catálogo</a>
                  </li>
                  </ul>
              </div>
              <a class="nav-link" href="index.html"><img src="../IMG/logo_maison.PNG" style="width: 32px; height: 32px;"></a>
          </div>
      </nav>
  </header>

  <main class="container p-2">
    <!--Mensagem de boas vindas-->
    <div class="p-4 p-md-5 mb-4 rounded" id="boasVINDA">
        <div class="col-md-6 px-0">
            <h1 class="display-4 fst-italic">Bem Vindo à página do Administrador</h1>
            <p class="lead my-3">Você tem a capacidade de gerenciar todos os aspectos relacionados aos imóveis e clientes. Suas responsabilidades são vitais para o funcionamento suave e eficiente do nosso site.</p>
        </div>
    </div>
    <div class="row g-5">
      <div class="col-md-8">
        <h3 class="pb-4 mb-4 fst-italic border-bottom">
          Painel do Administrador(a)
        </h3>
  
        <article class="blog-post">
          <p>Como administrador(a) deste site, você tem a capacidade de gerenciar todos os aspectos relacionados aos imóveis e clientes. Suas responsabilidades são vitais para o funcionamento suave e eficiente do nosso site.</p>
          <hr>
          <h3>Gerenciamento de Imóveis e Clientes</h3>
          <p>Você tem a autoridade para adicionar, editar ou excluir imóveis e clientes. Isso permite que você mantenha nosso catálogo de imóveis atualizado e garanta que as informações dos clientes estejam sempre corretas. Lembre-se, cada alteração que você fizer terá um impacto direto em nossos usuários, portanto, é crucial garantir a precisão em todos os momentos.</p>
          <h3>Visualização de Interessados</h3>
          <p>Além disso, você pode visualizar a lista de interessados em imóveis. Isso permite que você entenda melhor as preferências dos nossos usuários e ajude-os a encontrar o imóvel perfeito.</p>
          <h3>Catálogo Completo de Imóveis</h3>
          <p>Por último, mas não menos importante, você tem acesso ao catálogo completo de imóveis. Isso oferece uma visão completa de todos os imóveis disponíveis em nosso site, permitindo que você gerencie efetivamente nossa oferta de imóveis.</p>
          <p>Lembre-se, seu papel como administrador(a) é fundamental para o sucesso do nosso site. Agradecemos seu compromisso em manter a qualidade e a integridade do nosso site.</p>
        </article>
        </div>
        <div class="col-md-4">
          <div class="position-sticky" style="top: 2rem;">
            <div class="p-4 mb-3 bg-body-tertiary rounded">
              <h4 class="fst-italic">Sobre</h4>
              <p class="text-md-justify">Uma página de administração é crucial para gerenciar um site. Ela oferece controle centralizado, facilita o gerenciamento de conteúdo e usuários, fornece análises de dados importantes e auxilia na manutenção do site. É uma ferramenta essencial para manter um site funcionando de maneira eficiente.</p>
            </div>
            <div class="p-4">
              <h4 class="fst-italic">Ferramentas</h4>
              <ol class="list-unstyled mb-0">
                <li><a href="#">Editar/Excluir Cliente</a></li>
                <li><a href="#">Editar/Excluir Imovel</a></li>
                <li><a href="#">Interessados</a></li>
              </ol>
            </div>
    
            <div class="p-4">
              <h4 class="fst-italic">Contatos</h4>
              <ol class="list-unstyled">
                <li><a href="#">GitHub</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Facebook</a></li>
              </ol>
            </div>
          </div>
        </div>
    </div>
  </main>

  <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="../IMG/nav-logo.png" alt="Logo Imobiliária">
                <p>Seu parceiro confiável em imóveis.</p>
            </div>
            <div class="footer-info">
                <h3>Entre em Contato</h3>
                <p>Endereço: Rua dos Imóveis, nº 123</p>
                <p>Telefone: (16) 3344-2000</p>
                <p>Email: maison@maisonimobiliaria.com</p>
            </div>
            <div class="footer-social">
                <h3>Tecnologias</h3>
                <ul class="social-icons">
                    <li><a href="#" target="_blank"><i class="devicon-php-plain"></i></a></li>
                    <li><a href="#" target="_blank"><i class="devicon-mysql-plain"></i></a></li>
                    <li><a href="#" target="_blank"><i class="devicon-html5-plain"></i></a></li>
                    <li><a href="#" target="_blank"><i class="devicon-css3-plain"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 Maison Imobiliária. Todos os direitos reservados.</p>
        </div>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>
