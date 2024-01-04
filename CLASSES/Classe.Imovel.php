<?php

    /**
     * Falta:
     * Adicionar os paramentros corretos para os "bindValue's"
     * Retirar a flagvav dos insert, pois ela é algo do catalogo e não do imovel
    */

    Class Imovel{

        //Atributos da classe imovel
        public $pdo;//Variavel responsavel pela conexão com o banco
        public $ID_imovel;//Variavel que guarda o id do imovel
        public $busca;//Variavel que puxa as informações do formulário de pesquisa, através de sistema de aba
        public $MINIMO;//Atributo que recebe o valor minimo estipulado pelo usuário
        public $MAXIMO;//Atributo que recebe o valor máximo estipulado pelo usuário

        public $IDdaImagem;

        public $TituloDoImovel;
        public $DescricaoDoImovel;
        public $ENDERECO;//Atributo que recebe o endereco do imovel
        public $CEPDoImovel;
        public $OPERACAO;//Atributo que salva o tipo de operacao do filtro
        public $TIPO_IMOVEL;//Atributo que recebe o tipo do imovel para o método de filtro
        public $DORMITORIOS;//Atributo que recebe a quantidade de dormitorios no imovel
        public $GARAGEM;//Atributo que recebe a quantidade de garagem no imovel
        public $PrecoDoImovel;
        public $CozinhaDoImovel;
        public $LavanderiaDoImovel;
        public $BanheiroDoImovel;
        public $SalaDoImovel;
        public $latitudeDoImovel;
        public $longitudeDoImovel;
        public $identificadorUnicoDeUmImovel;//Atributo que recebe um identificador unico para um imovel além o ID

        //Criando conexão com o banco de dados
        public function __construct($dbname, $host, $user, $senha){
                
            try {
                $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
            }
            catch(PDOException $e){
                echo "Erro com o banco de dados: " . $e->getMessage();
                exit();
            }
            catch(Exception $e){
                echo "Erro generico: " . $e->getMessage();
                exit();
            }
        }

        //Método que é responsavel por devolver os dados
        public function exibir_imoveis_dados(){
            $resultado = array();//para retornar um vetor vazio, caso não haja produtos cadastrados, também para não dar erro
            $cmd = $this->pdo->prepare("SELECT * FROM Imoveis ORDER BY imID");//Comando sql que o método realizará
            $cmd->execute();//Executa o comando
            $resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);//Salva os dados em uma matriz 'resultado', onde 'resultado[Será as linhas da tabela][Os dados da linhas]'
            return $resultado;//Retorna a matriz.
        }

        //Metódo que puxa as imagens relacionadas ao id do imovel informado
        public function exibir_imoveis_imagem($ID_imovel){
            $this->ID_imovel = $ID_imovel;//Salvando as variaveis para a classe
            $cmd = $this->pdo->prepare("SELECT * FROM Imoveis_img WHERE imID = :i");//realiza atráves da classe o select no banco
            $cmd->bindValue(":i",$ID_imovel);//Puxa o parametro e salva nele
            $cmd->execute();//executa
            $resultado1 = $cmd->fetchAll(PDO::FETCH_ASSOC);//Salva o valor em uma matriz. o PDO::FETCH_ASSOC é para economizar código
            return $resultado1;//retorna como matriz, onde se não houver nenhuma linha, a matriz retornará vazia
        }

        public function ExibirImagemPeloID($IDdaImagem){
            $this->IDdaImagem = $IDdaImagem;//Salvando as variaveis para a classe
            $cmd = $this->pdo->prepare("SELECT * FROM Imoveis_img WHERE imgID = :i");//realiza atráves da classe o select no banco
            $cmd->bindValue(":i", $this->IDdaImagem);//Puxa o parametro e salva nele
            $cmd->execute();//executa
            $resultado1 = $cmd->fetch(PDO::FETCH_ASSOC);//Salva o valor em uma matriz. o PDO::FETCH_ASSOC é para economizar código
            return $resultado1;//retorna como matriz, onde se não houver nenhuma linha, a matriz retornará vazia
        }
        
        //Metodo que retorna o imovel do qual pertence ao "ID" fornecido.
        public function exibir_imovel_pelo_id($ID_imovel){
            $this->ID_imovel = $ID_imovel;//Salvando o ID recebido pela página
            $cmd = $this->pdo->prepare("SELECT * FROM Imoveis WHERE imID = :i");//Prepara a consulta sql
            $cmd->bindValue(":i",$ID_imovel);//Puxa o parametro e salva nele
            $cmd->execute();//executa
            $resultado = $cmd->fetch(PDO::FETCH_ASSOC);//Salva o valor em uma matriz. o PDO::FETCH_ASSOC é para economizar código
            return $resultado;//retorna como matriz, onde se não houver nenhuma linha, a matriz retornará vazia
        }

        //Método responsavel por Adicionar Imagems ao banco de dados, dos quais fazem parte de um imovel
        public function AdicionarImagemsParaImovel($IDuserUp, $diretorio, $identificadorUnicoDeUmImovel){
            $cmd = $this->pdo->prepare("SELECT imID FROM Imoveis WHERE identificadorUnico LIKE :IDE");
            $cmd->bindValue(":IDE", $identificadorUnicoDeUmImovel);
            $cmd->execute();
            $resultado = $cmd->fetch(PDO::FETCH_ASSOC);
            if (!empty($resultado['imID'])){
                $IDimovel = $resultado['imID'];
                $sql = $this->pdo->prepare("INSERT INTO Imoveis_img (imgRef, imID, IDuserUp) VALUES (:dir, :imovel , :user )");
                $sql->bindValue(":dir", $diretorio, PDO::PARAM_STR);
                $sql->bindValue(":imovel", $IDimovel);
                $sql->bindValue(":user", $IDuserUp, PDO::PARAM_INT);
                $sql->execute();
                // Verifique se a inserção foi bem-sucedida
                if ($sql->rowCount()) {
                    return true;
                } else {
                    return false;
                }
            }
            else{
                return false;
            }
        }

        //Método responsavel por adicionar os imoveis ao banco de dados
        public function AdicionarImovel($TituloDoImovel, $DescricaoDoImovel, $EnderecoDoImovel, $CEPDoImovel, $TipoDoImovel, $PrecoDoImovel, $DormitoriosDoImovel, $OperacaoDoImovel, $GaragemDoImovel, $CozinhaDoImovel, $LavanderiaDoImovel, $BanheiroDoImovel, $SalaDoImovel, $latitudeDoImovel, $longitudeDoImovel, $identificadorUnicoDeUmImovel){
            
            //Não se verifica se existe imoveis iguais pois, podemos ter mais de imovel dentro de imovel, como um apartamento, onde um pode estar alugando ou a venda

            $this->TituloDoImovel = $TituloDoImovel;
            $this->DescricaoDoImovel = $DescricaoDoImovel;
            $this->ENDERECO = $EnderecoDoImovel;//Atributo que recebe o endereco do imovel
            $this->CEPDoImovel = $CEPDoImovel;
            $this->OPERACAO = $OperacaoDoImovel;//Atributo que salva o tipo de operacao do filtro
            $this->TIPO_IMOVEL = $TipoDoImovel;//Atributo que recebe o tipo do imovel para o método de filtro
            $this->DORMITORIOS = $DormitoriosDoImovel;//Atributo que recebe a quantidade de dormitorios no imovel
            $this->GARAGEM = $GaragemDoImovel;//Atributo que recebe a quantidade de garagem no imovel
            $this->PrecoDoImovel = $PrecoDoImovel;
            $this->CozinhaDoImovel = $CozinhaDoImovel;
            $this->LavanderiaDoImovel = $LavanderiaDoImovel;
            $this->BanheiroDoImovel = $BanheiroDoImovel;
            $this->SalaDoImovel = $SalaDoImovel;
            $this->latitudeDoImovel = $latitudeDoImovel;
            $this->longitudeDoImovel = $longitudeDoImovel;

            $this->identificadorUnicoDeUmImovel = $identificadorUnicoDeUmImovel; //  Recebe o código gerado no adicionar

            $sql = $this->pdo->prepare("INSERT INTO Imoveis (imDesc, imLocation, imCEP, tipo, preco, qtdDormitorios, imOperacao, qtdGaragem, qtdCozinha, qtdLavanderia, qtdBanheiro, qtdSala, latitude, longitude, imTitulo, identificadorUnico) VALUES (:descricao, :endereco , :cep, :tipo, :preco, :dormitorios, :imOperacao, :qtdGaragem, :qtdCozinha, :qtdLavanderia, :qtdBanheiro, :qtdSala, :latitude, :longitude, :imTitulo, :identificadorUnico)");
            $sql->bindValue(":descricao", $this->DescricaoDoImovel);
            $sql->bindValue(":endereco", $this->ENDERECO);
            $sql->bindValue(":cep", $this->CEPDoImovel);
            $sql->bindValue(":tipo", $this->TIPO_IMOVEL);
            $sql->bindValue(":preco", $this->PrecoDoImovel);
            $sql->bindValue(":dormitorios", $this->DORMITORIOS);
            $sql->bindValue(":imOperacao", $this->OPERACAO);
            $sql->bindValue(":qtdGaragem", $this->GARAGEM);
            $sql->bindValue(":qtdCozinha", $this->CozinhaDoImovel);
            $sql->bindValue(":qtdLavanderia", $this->LavanderiaDoImovel);
            $sql->bindValue(":qtdBanheiro", $this->BanheiroDoImovel);
            $sql->bindValue(":qtdSala", $this->SalaDoImovel);
            $sql->bindValue(":latitude", $this->latitudeDoImovel);
            $sql->bindValue(":longitude", $this->longitudeDoImovel);
            $sql->bindValue(":imTitulo", $this->TituloDoImovel);
            $sql->bindValue(":identificadorUnico", $this->identificadorUnicoDeUmImovel);
            $sql->execute();

            return true;
        }

        //Método que exclui os arquivos e o imovel do banco referente ao imovel selecionado
        public function ExcluiTudoImovelSelecionado($IDdoImovelSelecionado) {
            try {
                $this->ID_imovel = $IDdoImovelSelecionado;
                $imagemsDoImovel = $this->exibir_imoveis_imagem($this->ID_imovel);
        
                foreach ($imagemsDoImovel as $indice => $Imagem) {
                    $diretorio = "../" . $Imagem['imgRef'];
                    if (file_exists($diretorio) && unlink($diretorio)) {
                        $sql = $this->pdo->prepare("DELETE FROM Imoveis_img WHERE imgID = :imagemID");
                        $sql->bindValue(":imagemID", $Imagem['imgID'], PDO::PARAM_INT);
                        $sql->execute();
                    } else {
                        return false; // Erro ao deletar arquivo
                    }
                }
        
                $sql = $this->pdo->prepare("DELETE FROM Imoveis WHERE imID = :imovelID");
                $sql->bindValue(":imovelID", $this->ID_imovel, PDO::PARAM_INT);
                $sql->execute();
                return true; // Exclusão bem-sucedida
            } catch (PDOException $e) {
                echo "Erro ao deletar imóvel: " . $e->getMessage();
                return false; // Erro ao deletar imóvel
            }
        }
        

        //Método que vai atualizar as informações de um imovel especifico
        public function AtualizarImovel($IDimovelForm, $TituloDoImovel, $DescricaoDoImovel, $EnderecoDoImovel, $CEPDoImovel, $TipoDoImovel, $PrecoDoImovel, $DormitoriosDoImovel, $OperacaoDoImovel, $GaragemDoImovel, $CozinhaDoImovel, $LavanderiaDoImovel, $BanheiroDoImovel, $SalaDoImovel, $latitudeDoImovel, $longitudeDoImovel) {

            $this->ID_imovel = $IDimovelForm;
            $this->TituloDoImovel = $TituloDoImovel;
            $this->DescricaoDoImovel = $DescricaoDoImovel;
            $this->ENDERECO = $EnderecoDoImovel;//Atributo que recebe o endereco do imovel
            $this->CEPDoImovel = $CEPDoImovel;
            $this->OPERACAO = $OperacaoDoImovel;//Atributo que salva o tipo de operacao do filtro
            $this->TIPO_IMOVEL = $TipoDoImovel;//Atributo que recebe o tipo do imovel para o método de filtro
            $this->DORMITORIOS = $DormitoriosDoImovel;//Atributo que recebe a quantidade de dormitorios no imovel
            $this->GARAGEM = $GaragemDoImovel;//Atributo que recebe a quantidade de garagem no imovel
            $this->PrecoDoImovel = $PrecoDoImovel;
            $this->CozinhaDoImovel = $CozinhaDoImovel;
            $this->LavanderiaDoImovel = $LavanderiaDoImovel;
            $this->BanheiroDoImovel = $BanheiroDoImovel;
            $this->SalaDoImovel = $SalaDoImovel;
            $this->latitudeDoImovel = $latitudeDoImovel;
            $this->longitudeDoImovel = $longitudeDoImovel;

            $sql = $this->pdo->prepare("UPDATE Imoveis SET imDesc = :descricao, imLocation = :endereco, imCEP = :cep, tipo = :tipo, preco = :preco, qtdDormitorios = :dormitorios, imOperacao = :imOperacao, qtdGaragem = :qtdGaragem, qtdCozinha = :qtdCozinha, qtdLavanderia = :qtdLavanderia, qtdBanheiro = :qtdBanheiro, qtdSala = :qtdSala, latitude = :latitude, longitude = :longitude, imTitulo = :imTitulo WHERE imID = :i");

            $sql->bindValue(":descricao", $this->DescricaoDoImovel);
            $sql->bindValue(":endereco", $this->ENDERECO);
            $sql->bindValue(":cep", $this->CEPDoImovel);
            $sql->bindValue(":tipo", $this->TIPO_IMOVEL);
            $sql->bindValue(":preco", $this->PrecoDoImovel);
            $sql->bindValue(":dormitorios", $this->DORMITORIOS);
            $sql->bindValue(":imOperacao", $this->OPERACAO);
            $sql->bindValue(":qtdGaragem", $this->GARAGEM);
            $sql->bindValue(":qtdCozinha", $this->CozinhaDoImovel);
            $sql->bindValue(":qtdLavanderia", $this->LavanderiaDoImovel);
            $sql->bindValue(":qtdBanheiro", $this->BanheiroDoImovel);
            $sql->bindValue(":qtdSala", $this->SalaDoImovel);
            $sql->bindValue(":latitude", $this->latitudeDoImovel);
            $sql->bindValue(":longitude", $this->longitudeDoImovel);
            $sql->bindValue(":imTitulo", $this->TituloDoImovel);
            $sql->bindValue(":i", $this->ID_imovel);
            
            try {
                // Executa a consulta SQL
                $sql->execute();
        
                // Verifica se alguma linha foi atualizada
                if($sql->rowCount() == 0){
                    echo "Nenhuma linha foi atualizada."; 
                    return true; 
                } else {
                    echo "Atualização bem-sucedida."; 
                    return true; 
                }
            } catch (PDOException $e) {
                // Exibe uma mensagem de erro se ocorrer um erro
                echo "Erro ao atualizar imóvel: " . $e->getMessage();
                return false;
            }
        }

        //Método responsavel por Adicionar Imagems ao banco de dados, dos quais fazem parte de um imovel sem a necessidade do IDENTIFICADOR UNICO
        public function AdicionarImagemsParaImovelComOid($IDuserUp, $diretorio, $identificadorUnicoDeUmImovel){
                $IDimovel = $identificadorUnicoDeUmImovel;
                $sql = $this->pdo->prepare("INSERT INTO Imoveis_img (imgRef, imID, IDuserUp) VALUES (:dir, :imovel , :user )");
                $sql->bindValue(":dir", $diretorio, PDO::PARAM_STR);
                $sql->bindValue(":imovel", $IDimovel, PDO::PARAM_INT);
                $sql->bindValue(":user", $IDuserUp, PDO::PARAM_INT);
                $sql->execute();
                // Verifique se a inserção foi bem-sucedida
                if ($sql->rowCount()) {
                    return true;
                } else {
                    return false;
                }
        }

        // Método responsável por excluir a imagem específica
        public function ExcluirImagemID($IDdaImagem) {
            $this->IDdaImagem = $IDdaImagem;
            $Imagem = $this->ExibirImagemPeloID($IDdaImagem);
            $diretorio = "../" . $Imagem['imgRef'];
            // Verifica se o arquivo existe e tenta excluí-lo
            if (file_exists($diretorio) && unlink($diretorio)){
                try {
                    // Prepara a consulta SQL para excluir a imagem do banco de dados
                    $sql = $this->pdo->prepare("DELETE FROM Imoveis_img WHERE imgID = :imagemID");
                    $sql->bindValue(":imagemID", $Imagem['imgID'], PDO::PARAM_INT);
                    // Executa a consulta SQL
                    $sql->execute();
                    // Retorna verdadeiro se a imagem foi excluída com sucesso
                    return true;
                } catch (PDOException $e) {
                    // Exibe uma mensagem de erro se ocorrer um erro ao excluir a imagem do banco de dados
                    echo "Erro ao deletar imagem: " . $e->getMessage();
                    return false;
                }
            } else {
                // Exibe uma mensagem de erro se ocorrer um erro ao excluir o arquivo
                echo "Erro ao deletar o arquivo: " . $diretorio;
                return false;
            }
        }

    }
?>