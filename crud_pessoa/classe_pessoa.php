<?php 

class Pessoa{

    // Atributos
    const HOST = '127.0.0.1';
    const NAME = 'crudpdo';
    const USER = 'root';
    const PASS = '';
    private $pdo;

    // Método costrutor
    // O método costrutor irá realizar a conexão com o banco de dados.
    public function __construct()
    {
        try{
            $this->pdo = new PDO('mysql:dbname='.self::NAME.';host='.self::HOST,self::USER,self::PASS);
        }
        catch (PDOException $e){
            echo "Erro no Banco de Dados: ".$e->getMessage();
            exit();
        }
        catch (Exception $e){
            echo "Erro Genérico: ".$e->getMessage();
            exit();
        }
        
    }

    public function buscarDados()
    {
        $resultado = array();
        $dados = $this->pdo->query("SELECT * FROM pessoa");
        $resultado = $dados->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;



    }

    public function cadastrarPessoa($nome, $telefone, $email, $endereco){

        //Antes de cadastrar uma nova pessoa, é necessário verificar se já existe no banco de dados.
        $verificador = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $verificador->bindValue(":e",$email);
        $verificador->execute();

        if ($verificador->rowCount() > 0){ // Se maior que zero, retornou como verdade para e-mail já cadastrado.
            return false;
        }else{
            $cadastro = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email, endereco) VALUES (:n, :t, :e, :ed)");
            $cadastro->bindValue(":n",$nome);
            $cadastro->bindValue(":t",$telefone);
            $cadastro->bindValue(":e",$email);
            $cadastro->bindValue(":ed",$endereco);
            $cadastro->execute();
            return true;
        }
    }


    public function excluirDado($id){

        $dado_excluir = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $dado_excluir->bindValue(":id",$id);
        $dado_excluir->execute();
    }

    public function buscarDadosUnitarios($id){

        $resultado = array();
        $dado = $this->pdo->prepare(("SELECT * FROM pessoa WHERE id = :id"));
        $dado->bindValue(":id",$id);
        $dado->execute();
        $resultado = $dado->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function atualizarDadosUnitarios($id, $nome, $telefone, $email, $endereco){

        $dado_atualizar = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e, endereco = :ed WHERE id = :id");
        $dado_atualizar->bindValue(":n",$nome);
        $dado_atualizar->bindValue(":t",$telefone);
        $dado_atualizar->bindValue(":e",$email);
        $dado_atualizar->bindValue(":ed",$endereco);
        $dado_atualizar->execute();
        

    }








}
