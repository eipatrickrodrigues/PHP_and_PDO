<?php

require_once 'classe_pessoa.php';
$entrada = new Pessoa();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PHP com MySQL</title>
</head>
<body>
    
    <?php

    // Colhendo as informações digitadas no formulário.
    if(isset($_POST['nome'])){ // Verificar se o botão foi clicado e adquirida informação via nome.

        //_______________EDITAR OS DADOS____________________
        if (isset($id_update) && !empty($_GET['id_update'])){

            $id_to_update = $_GET['id_update'];
            $nome = ($_POST['nome']);
            $telefone = ($_POST['telefone']);
            $email = ($_POST['email']);
            $endereco = ($_POST['endereco']);
    
            // Verificação se os dados estão preenchidos
            if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($endereco)){
               
               if ($entrada->atualizarDadosUnitarios($id_to_update, $nome, $telefone, $email, $endereco));
                header("location: index.php");    

            }else{
                echo "Preencha todos os dados.";
            }

        }else{ //_________CADASTRAR__________________________

            $nome = ($_POST['nome']);
            $telefone = ($_POST['telefone']);
            $email = ($_POST['email']);
            $endereco = ($_POST['endereco']);
    
            // Verificação se os dados estão preenchidos
            if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($endereco)){
               
               if (!$entrada->cadastrarPessoa($nome, $telefone, $email, $endereco)){
                   echo "E-mail já cadastrado.";
               }
    
            }else{
                echo "Preencha todos os dados.";
            }

        }

    }

    ?>

    <?php

    if (isset($_GET['id_update'])){

        $id_update = $_GET['id_update'];
        $resultado = $entrada->buscarDadosUnitarios($id_update);

    }

    ?>

    <section id="esquerda">
        <form method="POST">
            <h2>Cadastro de Pessoas</h2>

            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($resultado)){echo$resultado['nome'];}?>">

            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php if(isset($resultado)){echo$resultado['telefone'];} ?>">

            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?php if(isset($resultado)){echo$resultado['email'];}?> ">

            <label for="endereco">Endereço</label>
            <input type="text" name="endereco" id="endereco" value="<?php if(isset($resultado)){echo$resultado['endereco'];} ?>">

            <input type="submit" value="<?php if(isset($resultado)){echo "Atualizar";}else{echo"Cadastrar";}?> " id="idbtn">
        </form>
    </section>

    <section id="direita">

        <table>

            <tr id="titulo"> <!-- Uma linha <tr> com 4 colunas <td> -->
                <td>Nome</td>
                <td>Telefone</td>
                <td>E-mail</td>
                <td colspan="2">Endereço</td>
            </tr>

        <?php
            $dados =  $entrada->buscarDados();
            if (count($dados) > 0){

                // Sendo uma matriz, um array dentro do outro, é necessário separar para utilizar o foreach adequadamente.
                for ($i=0; $i < count($dados); $i++){

                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v) {

                        // A coluna ID não aparece para o usuário.
                        if($k != 'id'){

                            echo "<td>".$v."</td>";
                        }
                    }

                    // Outra forma de escrever HTML é fechando e abrindo PHP desta forma:
                    ?>

                    <td><a href="index.php?id_update= <?php echo $dados[$i]['id']; ?>">Editar</a> <a href="index.php?id= <?php echo $dados[$i]['id']; ?>">Excluir</a></td>

                    <?php

                    echo "</tr>";
                }

            }else{
                echo "Sem dados cadastrados.";
            }
        ?>

        </table>
    </section>

</body>
</html>


<?php

if (isset($_GET['id'])){
    $id_excluir = $_GET['id'];
    $entrada->excluirDado($id_excluir);
    header("location: index.php");
}

?>