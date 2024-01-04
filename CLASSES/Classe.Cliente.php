<?php

    /*Classe que contém os metodos responsáveis por adcionar, editar e excluir clientes do banco de dados
        - Falta adicionar o metodo de editar e excluir
        - Apos tudo mudar as restrições do cliente
    */

    require_once("Classe.Imovel.php");

    class Cliente extends Imovel{//A classe Cliente herda de Imovel o Construct

        private $filtro_condicoes;//será usada para armazenar as condições da cláusula WHERE da consulta SQL
        private $parametros;//será usada para armazenar os valores dos parâmetros que serão usados na consulta
        private $query;//Atributo que vai receber todas as variaveis

        private $cliente_id_classe;//Atributo que salva o valor do id do cliente
        private $cliente_nome_classe;//Atributo que salva o valor do nome
        private $cliente_cpf_classe;//Atributo que salva o cpf do cliente
        private $cliente_email_classe;//Atributi que salva o email do cliente
        private $cliente_senha_classe;//Atributo que salva a senha do cliente
        private $cliente_tel_classe;//Atributo que salva o telefone do cliente
        private $cliente_adm_classe;//atributo que salva o tipo do cliente. Se é adm ou usuario
        private $cliente_busca_classe;//Atributo que salva uma busca avançada 

        //Método que retorna as informações de um desejo através do id do imovel e do cliente
        public function ListarDesejoUnico($cliente_id, $imovel_id){
            $this->cliente_id_classe = $cliente_id;
            $this->ID_imovel = $imovel_id;
            $cmd = $this->pdo->prepare("SELECT * FROM Catalogo WHERE clienteID = :id AND imID = :imovel");
            $cmd->bindValue(":id", $this->cliente_id_classe, PDO::PARAM_INT);
            $cmd->bindValue(":imovel", $this->ID_imovel, PDO::PARAM_INT);
            $cmd->execute();
            $resultado = $cmd->fetch(PDO::FETCH_ASSOC);
            return $resultado;
            if(!$cmd->execute()) {
                print_r($cmd->errorInfo());
            }
        }

        //Método que retorna uma matriz com os imoveis de desejo de um usuário especifico
        public function listarDesejosUnicoUsuario($cliente_id){
            // Define a propriedade cliente_id_classe do objeto para o valor de $cliente_id
            $this->cliente_id_classe = $cliente_id;
        
            // Prepara uma consulta SQL para selecionar todas as linhas da tabela Catalogo onde clienteID é igual ao valor de cliente_id_classe
            $cmd = $this->pdo->prepare("SELECT * FROM Catalogo WHERE clienteID = :id");
        
            // Vincula o valor de cliente_id_classe ao parâmetro :id na consulta SQL
            $cmd->bindValue(":id", $this->cliente_id_classe);
        
            // Executa a consulta
            $cmd->execute();
        
            // Busca todas as linhas retornadas pela consulta e as armazena na variável $resultado
            $resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);
        
            // Retorna $resultado
            return $resultado;
        }
        

        //Método responsavel por listar todos os imoveis da lista de desejos de todos os usuários
        public function listarDesejos(){

            $cmd = $this->pdo->prepare("SELECT * FROM Catalogo");//Prepara um select geral
            $cmd->execute();
            $listagem = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $listagem;//Retorna todos os imoveis desejados de todos os usuárrios

        }

        //Método responsavel por listar todos os usuário cadastrados, sem filtros
        public function listarUsuarios(){

            $cmd = $this->pdo->prepare("SELECT * FROM Cliente");//Prepara um select geral
            $cmd->execute();
            $listagem = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $listagem;//Retorna todos os cadastros

        }

        //Método responsavel por apresentar um Usuário pelo ID
        public function listarUsuarioPeloId($id){

            $this->cliente_id_classe = $id;
            $cmd = $this->pdo->prepare("SELECT * FROM Cliente WHERE clienteID = :id");//Prepara um select geral
            $cmd->bindValue(":id", $this->cliente_id_classe);//Puxa o parametro e salva nele
            $cmd->execute();
            $resultado = $cmd->fetch(PDO::FETCH_ASSOC);
            return $resultado;//Retorna todos os cadastros

        }

        //Método responsavel por verificar o login do usuário
        public function verificarLogin($cpf, $senha){

            $this->cliente_cpf_classe = $cpf;
            $this->cliente_senha_classe = $senha;

            $cmd = $this->pdo->prepare("SELECT * FROM Cliente WHERE clienteCPF = :c AND clienteSenha = :s");
            $cmd->bindValue(":c", $this->cliente_cpf_classe);//Puxa o parametro e salva nele
            $cmd->bindValue(":s", $this->cliente_senha_classe);//Puxa o parametro e salva nele
            $cmd->execute();//Executa o comando
            $resultado_verificacao_login = $cmd->fetchAll(PDO::FETCH_ASSOC);//Salva o valor em uma matriz. o PDO::FETCH_ASSOC é para economizar código
            return $resultado_verificacao_login;
        }

        public function registrar_novo_usuario($nome, $cpf, $email, $senha, $tel){

            $this->cliente_nome_classe = $nome;
            $this->cliente_cpf_classe = $cpf;
            $this->cliente_email_classe = $email;
            $this->cliente_senha_classe = $senha;
            $this->cliente_tel_classe = $tel;

            //Antes de cadastrar, verificar se já existe um igual?
            $cmd = $this->pdo->prepare("SELECT clienteID FROM Cliente WHERE clienteCPF = :c");//realiza atráves da classe o select no banco
            $cmd->bindValue(":c", $this->cliente_cpf_classe);//Puxa o parametro e salva nele
            $cmd->execute();//executa

            if($cmd->rowCount() > 0){//CPF já existe
                return false;//retorna falso
            }
            else { // Se o CPF não existir no banco de dados
                // Prepara a consulta SQL para inserir um novo cliente no banco de dados
                $cmd = $this->pdo->prepare("INSERT INTO Cliente (clienteNome, clienteCPF, clienteEmail, clienteSenha, clienteTel) VALUES (:nome, :cpf, :email, :senha, :tel)");
                
                // Associa o valor do nome do cliente ao marcador de posição :nome na consulta SQL
                $cmd->bindValue(":nome", $this->cliente_nome_classe);
                
                // Associa o valor do CPF do cliente ao marcador de posição :cpf na consulta SQL
                $cmd->bindValue(":cpf", $this->cliente_cpf_classe);
                
                // Associa o valor do email do cliente ao marcador de posição :email na consulta SQL
                $cmd->bindValue(":email", $this->cliente_email_classe);
                
                // Associa o valor da senha do cliente ao marcador de posição :senha na consulta SQL
                $cmd->bindValue(":senha", $this->cliente_senha_classe);
                
                // Associa o valor do telefone do cliente ao marcador de posição :tel na consulta SQL
                $cmd->bindValue(":tel", $this->cliente_tel_classe);
                
                // Executa a consulta SQL
                $cmd->execute();
                
                // Retorna true para indicar que a inserção foi realizada com sucesso
                return true;
            }            
        }
        
        //Método responsavel por retornar uma busca dinamica
        public function BUSCAR($id_do_filtro, $nome_do_filtro, $telefone_do_filtro, $email_do_filtro, $busca_do_filtro, $cpf_do_filtro, $adm){

            $this->cliente_id_classe = $id_do_filtro;//Atributo que salva o valor do id do cliente
            $this->cliente_nome_classe = $nome_do_filtro;//Atributo que salva o valor do nome
            $this->cliente_cpf_classe = $cpf_do_filtro;//Atributo que salva o cpf do cliente
            $this->cliente_email_classe = $email_do_filtro;//Atributi que salva o email do cliente
            $this->cliente_tel_classe = $telefone_do_filtro;//Atributo que salva o telefone do cliente
            $this->cliente_adm_classe = $adm;//atributo que salva o tipo do cliente. Se é adm ou usuario
            $this->cliente_busca_classe = $busca_do_filtro;

            $this->filtro_condicoes = [];// O atributo se torna um array
            $this->parametros = [];// O atributo se torna um array
            
            if (!empty($this->cliente_busca_classe)) {
                $this->filtro_condicoes[] = "(clienteNome LIKE :busca OR clienteCPF LIKE :busca OR clienteEmail LIKE :busca OR clienteTel LIKE :busca)";
                $this->parametros[':busca'] = "%".$this->cliente_busca_classe."%";
            }

            if (($this->cliente_adm_classe != 2) && (!is_null($this->cliente_adm_classe))) {//Se o tipo de operação não foi escolhido todos
                $this->filtro_condicoes[] = "(adm = :adm)";//Adiciona a sintaxe da condição no array
                $this->parametros[':adm'] = $this->cliente_adm_classe;//Adiciona o parametro;
            }

            if (!empty($this->cliente_tel_classe)) {
                $this->filtro_condicoes[] = "(clienteTel LIKE :tel)";
                $this->parametros[':tel'] = "%".$this->cliente_tel_classe."%";
            }

            if (!empty($this->cliente_email_classe)) {
                $this->filtro_condicoes[] = "(clienteEmail LIKE :email)";
                $this->parametros[':email'] = "%".$this->cliente_email_classe."%";
            }

            if (!empty($this->cliente_cpf_classe)) {
                $this->filtro_condicoes[] = "(clienteCPF LIKE :cpf)";
                $this->parametros[':cpf'] = "%".$this->cliente_cpf_classe."%";
            }

            if (!empty($this->cliente_nome_classe)) {
                $this->filtro_condicoes[] = "(clienteNome LIKE :nome)";
                $this->parametros[':nome'] = "%".$this->cliente_nome_classe."%";
            }

            if (!empty($this->cliente_id_classe)) {
                $this->filtro_condicoes[] = "(clienteID = :id)";
                $this->parametros[':id'] = $this->cliente_id_classe;
            }

            $this->query = "SELECT * FROM Cliente";//Aqui estamos definindo a consulta SQL base que será usada se não houver filtros.

            if (!empty($this->filtro_condicoes)) {//Se a lista de filtros não estiver vazia, adicionamos uma cláusula WHERE à consulta SQL. Usamos a função implode para combinar todas as condições na lista de filtros com ’AND ’ entre elas
                $this->query .= " WHERE " . implode(' AND ', $this->filtro_condicoes);
            }

            //Aqui estamos preparando a consulta SQL usando o método prepare do objeto PDO.
            $cmd = $this->pdo->prepare($this->query);
            
            //Nesse loop, estamos vinculando cada valor na lista de parâmetros à consulta SQL preparada. Verificamos o tipo de cada valor para determinar o tipo de parâmetro correto.
            foreach ($this->parametros as $key => &$val) {
                if (is_int($val)) {
                    $paramType = PDO::PARAM_INT;
                } 
                else{
                // Supondo que todos os outros tipos sejam strings
                    $paramType = PDO::PARAM_STR;
                }
                $cmd->bindValue($key, $val, $paramType);
            }

            //Finalmente, executamos a consulta SQL com o método execute, buscamos todos os resultados como um array associativo com fetchAll(PDO::FETCH_ASSOC), e retornamos os resultados.
            $cmd->execute();
            $resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);
            
            if(empty($resultado)){//Se não houver nenhum tipo de resultado, então faça retorne nada
                return null;
            }

            else{//Se tiver alguma casa, então retorne o array
                return $resultado;
            }
        }

        //Método responsavel por alterar os dados de um usuário especifico
        public function AlterarUsuario($id, $nome, $cpf, $email, $senha, $telefone, $adm){

            $this->cliente_id_classe = $id;
            $this->cliente_nome_classe = $nome;
            $this->cliente_cpf_classe = $cpf;
            $this->cliente_email_classe = $email;
            $this->cliente_senha_classe = $senha;
            $this->cliente_tel_classe = $telefone;
            $this->cliente_adm_classe = $adm;

            $cmd = $this->pdo->prepare("UPDATE Cliente SET clienteNome = :nome, clienteCPF = :cpf, clienteEmail = :email, clienteSenha = :senha, clienteTel = :tel, adm = :adm WHERE clienteID = :i");
            $cmd->bindValue(":nome", $this->cliente_nome_classe);
            $cmd->bindValue(":cpf", $this->cliente_cpf_classe);
            $cmd->bindValue(":email", $this->cliente_email_classe);
            $cmd->bindValue(":senha", $this->cliente_senha_classe);
            $cmd->bindValue(":tel", $this->cliente_tel_classe);
            $cmd->bindValue(":adm", $this->cliente_adm_classe);
            $cmd->bindValue(":i", $this->cliente_id_classe);
            $cmd->execute();
             
            if($cmd->execute()){
            
                return true;
            
            }
            
            else {
                // Você pode querer fazer algo mais sofisticado com o erro aqui
                error_log('Falha ao atualizar o usuário: ' . print_r($cmd->errorInfo(), true));

                return false;
            }
        }

        //Método responsavel por deletar o usuário
        public function ExcluirUsuario($id){
            $this->cliente_id_classe = $id;//O id não se altera.
            $cmd = $this->pdo->prepare("DELETE FROM Cliente WHERE clienteID = :i");            
            $cmd->bindValue(":i", $this->cliente_id_classe);//Puxa o parametro e salva nele
            $cmd->execute();
            
            if($cmd->execute()){
                return true;
            } 
            else {
                error_log('Falha ao excluir o usuário: ' . print_r($cmd->errorInfo(), true));
                return false;
            }
        }
        
        //Método que vai Alterar um desejo
        public function AlterarDesejo($IDm, $IDc, $Contato, $Feito){
            $cmd = $this->pdo->prepare("UPDATE Catalogo SET deseja_contato = :contato, feito_contato = :feito WHERE imID = :im AND clienteID = :ic");
            $cmd->bindValue(":contato", $Contato);
            $cmd->bindValue(":feito", $Feito);
            $cmd->bindValue(":ic", $IDc);
            $cmd->bindValue(":im", $IDm);
            try {
                $cmd->execute();
                if($cmd->rowCount() == 0){
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

        //Método responsavel por deletar um desejo especifico
        public function DeletarDesejo($IDc){
            $cmd = $this->pdo->prepare("DELETE FROM Catalogo WHERE CatalogoID = :ic");
            $cmd->bindValue(":ic", $IDc, PDO::PARAM_INT);
            try {
                $cmd->execute();
                return true;
            } catch (PDOException $e) {
                error_log("Erro ao deletar desejo: " . $e->getMessage());
                return false;
            }
        }
    }
?>