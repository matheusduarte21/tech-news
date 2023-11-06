<?php


// Criando conexao com o Banco de dados 

$host = "localhost";
$user = "root";
$password = "";
$database = "inscricao";

$conexao = new mysqli($host, $user, $password, $database);

// verificando conexao
//if ($conexao->connect_error) {
//die("Conexao falhou:" . $conexao->connect_error); 
//}

//echo "Conectado ao banco de dados"; 


// Criando o banco de dados

$sql = "CREATE DATABASE IF NOT EXISTS inscricao";

// Verificando se o banco de dados foi criado corretamente
//if ($conexao->query($sql) === TRUE ) {
   //echo "<br> Banco de dados 'Inscritos' criado com sucesso";
//}
//else {
   //echo "Erro ao criar o banco de dados" .$conexao->error;
//}


// Criando tabela 'inscritos' no banco de dados 

$sql = " CREATE TABLE  IF NOT EXISTS inscricao.inscritos(
            nome                VARCHAR(250) NOT NULL, 
            email               VARCHAR(240) NOT NULL, 
            telefone            VARCHAR(11)  NOT NULL, 
            genero              VARCHAR(250) NOT NULL, 
            data_nascimento     DATE NOT NULL, 
            cidade              VARCHAR(250) NOT NULL, 
            estado              VARCHAR(250) NOT NULL, 
            endereco            VARCHAR(250) NOT NULL, 
            recomendacoes       VARCHAR(250) NOT NULL 
)"; 

//if ($conexao->query($sql) === TRUE ) {
 // echo "<br> Tabela inscritos criada com sucesso";
//}
//else {
  ////echo "Erro ao criar tabela" .$conexao->error;
//}