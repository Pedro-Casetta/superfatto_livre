<?php

namespace App\Model\DAO;

use App\Model\Entidades\Lote;
use Exception;
use PDO;

class LoteDAO extends BaseDAO
{
    public function localizar($codigo)
    {
        try {
            $pdoStatement = $this->select("SELECT l.*, f.nome nome_fornecedor, f.cod_departamento, d.nome nome_departamento
                FROM lote l, fornecedor f, departamento d
            WHERE l.codigo = $codigo AND f.codigo = l.cod_fornecedor AND d.codigo = f.cod_departamento");
            
            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $lote = new Lote(
                $arrayResultado['codigo'],
                $arrayResultado['data'],
                $arrayResultado['total'],
                $arrayResultado['cod_fornecedor'],
                "",
                $arrayResultado['nome_fornecedor'],
                $arrayResultado['cod_departamento'],
                $arrayResultado['nome_departamento']
            );
            
            return $lote;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }
    
    public function listar()
    {
        try {
            $pdoStatement = $this->select("SELECT l.*, f.cnpj, f.nome, f.cod_departamento, d.nome nome_departamento
                FROM lote l, fornecedor f, departamento d
                WHERE l.cod_fornecedor = f.codigo AND f.cod_departamento = d.codigo");

            $arrayLotes = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $lotes = [];

            foreach($arrayLotes as $loteEncontrado)
            {
                $lote = new Lote(
                    $loteEncontrado['codigo'],
                    $loteEncontrado['data'],
                    $loteEncontrado['total'],
                    $loteEncontrado['cod_fornecedor'],
                    $loteEncontrado['cnpj'],
                    $loteEncontrado['nome'],
                    $loteEncontrado['cod_departamento'],
                    $loteEncontrado['nome_departamento']
                );

                $lotes[] = $lote;
            }

            return $lotes;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(Lote $lote)
    {
        try {
            $data = $lote->getData();
            $cod_fornecedor = $lote->getFornecedor()->getCodigo();

            $resultado = $this->insert(
                'lote',
                ':data, :cod_fornecedor',
                [
                    ':data' => $data,
                    ':cod_fornecedor' => $cod_fornecedor
            ]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function atualizar(Lote $lote)
    {
        try {
            $codigo = $lote->getCodigo();
            $data = $lote->getData();
            $cod_fornecedor = $lote->getFornecedor()->getCodigo();

            $resultado = $this->update(
                'lote',
                'data = :data, cod_fornecedor = :cod_fornecedor',
                [
                 ':data' => $data,
                 ':cod_fornecedor' => $cod_fornecedor
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

    public function excluir(Lote $lote)
    {
        try {
            $codigo = $lote->getCodigo();
            $resultado = $this->delete('lote', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            if ($excecao->getCode() == 23000)
                $erro = new Exception("Erro " . $excecao->getCode() . ". Lote não foi excluído pois contém produtos.");
            else
                $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}