<?php

function conexao()
{

    $string_connection = "pgsql:dbname=php-crud;host=localhost;port=5432;";

    try {
        return $conn = new PDO(
            $string_connection,
            "vitor",
            "postdba"
        );
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function main()
{
    echo "1-Inserir\n2-Listar\n3-Editar\n4-Excluir\n0-Parar\n";
    do {
        (int) $operacao = readline("INSIRA UM VALOR PARA A OPERAÇÃO QUE DESEJA REALIZAR:");
        switch ($operacao) {
            case 1:
                inserir();
                break;
            case 2:
                listar();
                break;

            case 3:
                editar();
                break;
            case 4:
                excluir();
                break;
            default:
                $operacao = 0;
                break;
        }
    } while ($operacao !== 0);
}
main();

function inserir()
{
    $conn = conexao();
    echo "Processo de cadastro.\n";
    $nome = readline("Insira seu nome:");
    $email = readline("Insira seu email:");
    $senha = readline("Insira sua senha:");
    try {

        $sql = "INSERT INTO USUARIOS(NOME,EMAIL,SENHA) VALUES(?,?,?);";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome,$email,password_hash($senha, PASSWORD_BCRYPT)]);
        echo "Inserido com sucesso!\n";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function editar()
{
    try {

        listar();
        $conn = conexao();
        (int) $id = readline("Insira o ID do usuário que deseja editar:\n");
        echo "Processo de edição de cadastro.\n";

        $nome = readline("Insira seu 'novo' nome:");
        $email = readline("Insira seu novo email:");
        $senha = readline("Insira sua nova senha:");
        $sql = "UPDATE USUARIOS SET NOME = ?, EMAIL = ?, SENHA = ? WHERE ID =?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome,$email,password_hash($senha, PASSWORD_BCRYPT),$id]);

    } catch (Exception $e) {
        echo $e->getMessage();
    }

}
function listar()
{
    $conn = conexao();

    try {
        $sql = "SELECT * FROM USUARIOS";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        echo "\n|id|nome|email|senha|\n";
        while ($row = $stmt->fetch()) {
            echo "|".$row['id'] . "|" . $row['nome'] . "|" . $row['email'] . "|" . $row['senha']."|\n";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function excluir()
{
    try {

        listar();
        $conn = conexao();
        (int) $id = readline("Insira o ID do usuário que deseja excluir: ");
        $sql = "DELETE FROM USUARIOS WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        echo "Usuário excluído com sucesso!\n";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
