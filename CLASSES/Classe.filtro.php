<?php

    //require_once ("../BD/config.php");
    require_once ("Classe.Imovel.php");

    //Classe responsável pelo metodos relacionados aos filtros
    Class Filtro extends Imovel {// A classe filtro herda os atributos da classe imovel

        //Atributos
        private $filtro_condicoes;//será usada para armazenar as condições da cláusula WHERE da consulta SQL
        private $parametros;//será usada para armazenar os valores dos parâmetros que serão usados na consulta
        private $query;//Atributo que vai receber todas as variaveis

        //Método de busca no catalago
        public function BUSCAR($busca, $OPERACAO, $TIPO_IMOVEL, $DORMITORIOS, $GARAGEM, $MINIMO, $MAXIMO){

            $this->busca = $busca;//Salvando a variavel na classe de maneira a pegar qualquer texto digitado em qualquer campo e posição
            $this->OPERACAO = $OPERACAO;//Salvando a variavel na classe de maneira a pegar o tipo de operação que o usuário busca
            $this->TIPO_IMOVEL = $TIPO_IMOVEL;//Salvando a variavel recebida pelo objeto e salva no stributo da classe.
            $this->DORMITORIOS = $DORMITORIOS;//Salvando a variavel recebida pelo objeto e salva no stributo da classe.
            $this->GARAGEM = $GARAGEM;//Salvando a variavel recebida pelo objeto e salva no stributo da classe.
            $this->MINIMO = $MINIMO;//Salvando a variavel recebida pelo objeto e salva no stributo da classe.
            $this->MAXIMO = $MAXIMO;//Salvando a variavel recebida pelo objeto e salva no stributo da classe.

            $this->filtro_condicoes = [];// O atributo se torna um array
            $this->parametros = [];// O atributo se torna um array

            if ($this->OPERACAO != 'todos') {//Se o tipo de operação não foi escolhido todos
                $this->filtro_condicoes[] = "(imOperacao LIKE :operacao OR imOperacao LIKE 'todos')";//Adiciona a sintaxe da condição no array
                $this->parametros[':operacao'] = "%".$this->OPERACAO."%";//Adiciona o parametro;
            }
            //Essa parte do código verifica se a operação não é ‘todos’. Se não for, adiciona uma nova condição à lista de filtros e um novo parâmetro à lista de parâmetros.
            
            if (!empty($this->busca)) {
                $this->filtro_condicoes[] = "(imDesc LIKE :busca OR imLocation LIKE :busca OR imCEP LIKE :busca)";
                $this->parametros[':busca'] = "%".$this->busca."%";
            }
            if ($this->TIPO_IMOVEL != 'todos') {
                $this->filtro_condicoes[] = "(tipo LIKE :tipo OR tipo LIKE 'todos')";
                $this->parametros[':tipo'] = "%".$this->TIPO_IMOVEL."%";
            }
            if(!empty($this->DORMITORIOS)){
                $this->filtro_condicoes[] = "(qtdDormitorios = :dormitorios)";
                $this->parametros[':dormitorios'] = $this->DORMITORIOS;
            }
            if(!empty($this->GARAGEM)){
                $this->filtro_condicoes[] = "(qtdGaragem = :garagem)";
                $this->parametros[':garagem'] = $this->GARAGEM;
            }
            if(!empty($this->MINIMO)){
                $this->filtro_condicoes[] = "(preco >= :minimo)";
                $this->parametros[':minimo'] = $this->MINIMO;
            }
            if(!empty($this->MAXIMO)){
                $this->filtro_condicoes[] = "(preco <= :maximo)";
                $this->parametros[':maximo'] = $this->MAXIMO;
            }
            

            $this->query = "SELECT * FROM Imoveis";//Aqui estamos definindo a consulta SQL base que será usada se não houver filtros.

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
    }
?>