<?php

namespace App\Model\DAO;

use App\Model\Entidades\Departamento;
use Exception;
use PDO;

class DepartamentoDAO extends BaseDAO
{
    public function localizar($codigo)
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM departamento WHERE codigo = $codigo");
            $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "App\\Model\\Entidades\\Departamento");

            $departamento = $pdoStatement->fetch();

            return $departamento;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "")
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM departamento
                WHERE nome LIKE '%$busca%' LIMIT $indice, $limitePorPagina");

            $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "App\\Model\\Entidades\\Departamento");

            $departamentos = $pdoStatement->fetchAll();

            return $departamentos;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(Departamento $departamento)
    {
        try {
            $nome = $departamento->getNome();

            $resultado = $this->insert(
                'departamento',
                ':nome',
                [':nome' => $nome]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function atualizar(Departamento $departamento)
    {
        try {
            $codigo = $departamento->getCodigo();
            $nome = $departamento->getNome();

            $resultado = $this->update(
                'departamento',
                'nome = :nome',
                [':nome' => $nome],
                'codigo = ' . $codigo
            );
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na atualização dos dados");
            return $erro;
        }
    }

    public function excluir(Departamento $departamento)
    {
        try {
            $codigo = $departamento->getCodigo();
            $resultado = $this->delete('departamento', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            if ($excecao->getCode() == 23000)
                $erro = new Exception("Erro " . $excecao->getCode() .
            ". Departamento não foi excluído pois se relaciona a um fornecedor ou um produto");
            else
                $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}