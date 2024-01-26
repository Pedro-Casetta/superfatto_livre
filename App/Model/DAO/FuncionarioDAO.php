<?php

namespace App\Model\DAO;

use App\Model\Entidades\Funcionario;
use Exception;
use PDO;

class FuncionarioDAO extends BaseDAO
{
    public function localizar($codigo)
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM funcionario WHERE codigo = $codigo");
            $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "App\\Model\\Entidades\\Funcionario");

            $funcionario = $pdoStatement->fetch();

            return $funcionario;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "")
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM funcionario
                WHERE nome LIKE '%$busca%' OR setor LIKE '%$busca%' LIMIT $indice, $limitePorPagina");

            $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "App\\Model\\Entidades\\Funcionario");

            $funcionarios = $pdoStatement->fetchAll();

            return $funcionarios;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(Funcionario $funcionario)
    {
        try {
            $cpf = $funcionario->getCpf();
            $nome = $funcionario->getNome();
            $setor = $funcionario->getSetor();
            $salario = $funcionario->getSalario();

            $resultado = $this->insert(
                'funcionario',
                ':cpf, :nome, :setor, :salario',
                [
                    ':cpf' => $cpf,
                    ':nome' => $nome,
                    ':setor' => $setor,
                    ':salario' => $salario
            ]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function atualizar(Funcionario $funcionario)
    {
        try {
            $codigo = $funcionario->getCodigo();
            $cpf = $funcionario->getCpf();
            $nome = $funcionario->getNome();
            $setor = $funcionario->getSetor();
            $salario = $funcionario->getSalario();

            $resultado = $this->update(
                'funcionario',
                'cpf = :cpf, nome = :nome, setor = :setor, salario = :salario',
                [
                 ':cpf' => $cpf,
                 ':nome' => $nome,
                 ':setor' => $setor,
                 ':salario' => $salario
                ],
                'codigo = ' . $codigo
            );
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na atualização dos dados");
            return $erro;
        }
    }

    public function excluir(Funcionario $funcionario)
    {
        try {
            $codigo = $funcionario->getCodigo();
            $resultado = $this->delete('funcionario', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}