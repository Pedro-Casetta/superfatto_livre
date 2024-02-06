<?php

namespace App\Model\DAO;

use App\Model\Entidades\Cupom;
use Exception;
use PDO;

class CupomDAO extends BaseDAO
{
    public function localizar($codigo)
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM cupom WHERE codigo = $codigo");
            $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "App\\Model\\Entidades\\Cupom");

            $cupom = $pdoStatement->fetch();

            return $cupom;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "")
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM cupom
                WHERE nome LIKE '%$busca%' OR descricao LIKE '%$busca%' OR desconto LIKE '%$busca%' LIMIT $indice, $limitePorPagina");

            $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "App\\Model\\Entidades\\Cupom");

            $cupons = $pdoStatement->fetchAll();

            return $cupons;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(Cupom $cupom)
    {
        try {
            $nome = $cupom->getNome();
            $descricao = $cupom->getDescricao();
            $desconto = $cupom->getDesconto();

            $resultado = $this->insert(
                'cupom',
                ':nome, :descricao, :desconto',
                [
                    ':nome' => $nome,
                    ':descricao' => $descricao,
                    ':desconto' => $desconto
            ]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function atualizar(Cupom $cupom)
    {
        try {
            $codigo = $cupom->getCodigo();
            $nome = $cupom->getNome();
            $descricao = $cupom->getDescricao();
            $desconto = $cupom->getDesconto();

            $resultado = $this->update(
                'cupom',
                'nome = :nome, descricao = :descricao, desconto = :desconto',
                [
                 ':nome' => $nome,
                 ':descricao' => $descricao,
                 ':desconto' => $desconto
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

    public function excluir(Cupom $cupom)
    {
        try {
            $codigo = $cupom->getCodigo();
            $resultado = $this->delete('cupom', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}