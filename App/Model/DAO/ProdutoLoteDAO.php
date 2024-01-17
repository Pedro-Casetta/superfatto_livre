<?php

namespace App\Model\DAO;

use App\Model\Entidades\ProdutoLote;
use Exception;
use PDO;

class ProdutoLoteDAO extends BaseDAO
{
    public function localizar($cod_produto, $cod_lote)
    {
        try {
            $pdoStatement = $this->select(
                "SELECT pl.*, p.nome nome_produto, p.preco, p.imagem
                FROM produto_lote pl, produto p
                WHERE pl.cod_produto = $cod_produto AND pl.cod_lote = $cod_lote
                AND p.codigo = pl.cod_produto");
            
            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $produtoLote = new ProdutoLote(
                $arrayResultado['cod_produto'],
                $arrayResultado['cod_lote'],
                $arrayResultado['quantidade'],
                $arrayResultado['subtotal'],
                $arrayResultado['nome_produto'],
                $arrayResultado['preco'],
                $arrayResultado['imagem']
            );
            
            return $produtoLote;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }
    
    public function listar($cod_lote)
    {
        try {
            $pdoStatement = $this->select("SELECT pl.*, p.nome, p.preco, p.imagem
                FROM produto_lote pl, produto p
                WHERE pl.cod_produto = p.codigo AND pl.cod_lote = $cod_lote");

            $arrayProdutosLote = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $produtosLote = [];

            foreach($arrayProdutosLote as $produtoLoteEncontrado)
            {
                $produtoLote = new ProdutoLote(
                    $produtoLoteEncontrado['cod_produto'],
                    $produtoLoteEncontrado['cod_lote'],
                    $produtoLoteEncontrado['quantidade'],
                    $produtoLoteEncontrado['subtotal'],
                    $produtoLoteEncontrado['nome'],
                    $produtoLoteEncontrado['preco'],
                    $produtoLoteEncontrado['imagem']
                );

                $produtosLote[] = $produtoLote;
            }

            return $produtosLote;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(ProdutoLote $produtoLote)
    {
        try {
            $cod_produto = $produtoLote->getCodigo();
            $cod_lote = $produtoLote->getLote()->getCodigo();
            $quantidade = $produtoLote->getQuantidade();

            $resultado = $this->insert(
                'produto_lote',
                ':cod_produto, :cod_lote, :quantidade',
                [
                    ':cod_produto' => $cod_produto,
                    ':cod_lote' => $cod_lote,
                    ':quantidade' => $quantidade
            ]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function atualizar(ProdutoLote $produtoLote, $velho_cod_produto)
    {
        try {
            $novo_cod_produto = $produtoLote->getCodigo();
            $cod_lote = $produtoLote->getLote()->getCodigo();
            $quantidade = $produtoLote->getQuantidade();

            $resultado = $this->update(
                'produto_lote',
                'cod_produto = :cod_produto, quantidade = :quantidade',
                [
                 ':cod_produto' => $novo_cod_produto,
                 ':quantidade' => $quantidade
                ],
                'cod_produto = ' . $velho_cod_produto . 'AND cod_lote =' . $cod_lote
            );
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na atualização dos dados");
            return $erro;
        }
    }

    public function excluir(ProdutoLote $produtoLote)
    {
        try {
            $codigo = $produtoLote->getCodigo();
            $resultado = $this->delete('produto_lote', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}