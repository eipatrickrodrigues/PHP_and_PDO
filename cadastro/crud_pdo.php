<?php

// Para conectar o banco de dados ao PHP é adotada uma variável, isso porque PDO é orientado a objetos.

// new PDO("qual é o banco de dados : dbname = nome do banco de dados ; host = endereço do servidor", "user=usuário ; pass = senha)

//_____________________CONEXÃO_______________________
try
{
    $pdo = new PDO("mysql:dbname=CRUDPDO;host=127.0.0.1","root","");
}
catch (PDOException $e){
    echo "ERRO no Banco de Dados: ".$e->getMessage();
}
catch (Exception $e){
    echo "ERRO Genérico: ".$e->getMessage();
}

// ___________________INSERÇÃO DE DADOS______________________

// Há duas formas de inserir dados no banco, pelo $pdo->prepare(); quando há necessidade de modificicar os dados recebidos.

// As informações oara inserção ficam armazenadas na variável $resp.
$resp = $pdo->prepare("INSERT INTO pessoa(nome, telefone, email, endereco) VALUES (:nome, :telefone, :email, :endereco) ");

$resp->bindValue(":nome","Patrick");
$resp->bindValue(":telefone","0000000000");
$resp->bindValue(":email","teste@teste.com");
$resp->bindValue(":endereco","Rua teste, 2121");
$resp->execute();

// A segunda forma é através do $pdo->query() quando não é necessária a atualização dos dados recebidos. 

$pdo->query("INSERT INTO pessoa (nome, telefone, email, endereco) VALUES ('Wesley','000000000','teste@teste.com','Rua teste, 1212')");


//__________________________Atualização e Exclusão de dados________________________

// As manipulações do banco de dados seguem um padrão, adotando também prepare ou query nas edições e exclusões de dados.
$cmd = $pdo->prepare("DELETE FROM pessoa WHERE id = :id");
$id = 2;
$cmd->bindValue(":id",$id);
$cmd->execute();


$pdo->query("DELETE FROM pessoa WHERE id = '5'");

// Para atualizar os dados, IDEM.
$mud = $pdo->prepare("UPDATE pessoa SET email = :e WHERE id = :id");
$id = 10;
$mud->bindValue(":e","panela@teste.com");
$mud->bindValue(":id",$id);
$mud->execute();


$pdo->query("UPDATE pessoa SET nome = 'Iago' WHERE id = '12'");

//____________________________Seleção de Dados_________________________

$sel = $pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
$sel->bindValue(":id",8);
$sel->execute();

// Ao utilizar a seleção da dados, tais informações não seguem o formato adequado, logo é importante adotar uma função que faça a transformçao e assim possa ser mostrado na tela.

// $sel->fetch() quando busca 1 único registro e $sel->fetchAll() quando é mais de um.

/*
$resultado = $sel->fetch();
echo "<pre>";
print_r($resultado);
echo "</pre>";
*/

// Perceba no print_r que a função fetch()apresenta como resultado o nome e a posição da variável dentro do array, [id] e sua respectiva posição 0, isso ocupa mais memória e é mais interessante solicitar apenas uma destas informações por economia de espaço ADOTANDO = PDO::FETCH_ASSOC.

// Ou seja, 
$resultado = $sel->fetch(PDO::FETCH_ASSOC);

/*
echo "<pre>";
print_r($resultado);
echo "</pre>";
*/

// Para mostrar na tela as informações necessárias não deve-se utilizar o print_r, isso é apenas para o programador testar, para apresnetar as informações usa-se o foreach().

foreach ($resultado as $key => $value)
{
    echo $key.": ".$value."<br>";
}

?>