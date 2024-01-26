<?php

namespace App\Model\DAO;

use App\Model\Entidades\ProdutoVenda;
use Exception;
use PDO;

class ProdutoVendaDAO extends BaseDAO
{
    public function localizar($cod_produto, $cod_venda)
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

    public function listar($cod_venda)
    {
        try {
            $pdoStatement = $this->select("SELECT pv.*, p.nome, p.preco, p.imagem
                FROM produto_venda pv, produto p
                WHERE pv.cod_produto = p.codigo AND pv.cod_venda = $cod_venda");

            $arrayProdutosVenda = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $produtosVenda = [];

            foreach($arrayProdutosVenda as $produtoVendaEncontrado)
            {
                $produtoVenda = new ProdutoVenda(
                    $produtoVendaEncontrado['cod_produto'],
                    $produtoVendaEncontrado['cod_venda'],
                    $produtoVendaEncontrado['quantidade'],
                    $produtoVendaEncontrado['subtotal'],
                    $produtoVendaEncontrado['nome'],
                    $produtoVendaEncontrado['preco'],
                    $produtoVendaEncontrado['imagem']
                );

                $produtosVenda[] = $produtoVenda;
            }

            return $produtosVenda;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "", $cod_lote)
    {
        try {
            $pdoStatement = $this->select("SELECT pl.*, p.nome, p.preco, p.imagem
                FROM produto_lote pl, produto p
                WHERE pl.cod_produto = p.codigo AND pl.cod_lote = $cod_lote
            AND p.nome LIKE '%$busca%' LIMIT $indice, $limitePorPagina");

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

    public function cadastrar(ProdutoVenda $produtoVenda)
    {
        try {
            $cod_produto = $produtoVenda->getCodigo();
            $cod_venda = $produtoVenda->getVenda()->getCodigo();
            $quantidade = $produtoVenda->getQuantidade();

            $resultado = $this->insert(
                'produto_venda',
                ':cod_produto, :cod_venda, :quantidade',
                [
                    ':cod_produto' => $cod_produto,
                    ':cod_venda' => $cod_venda,
                    ':quantidade' => $quantidade
            ]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na inserção dos dados");
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
                'cod_produto = ' . $velho_cod_produto . ' AND cod_lote = ' . $cod_lote
            );
            
            return $resultado;
        }
        catch (Exception $excecao) {
            if ($excecao->getCode() == 23000)
                $erro = new Exception("Erro " . $excecao->getCode() . ". Esse produto já existe nesse lote.");
            else
                $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na atualização dos dados");
            return $erro;
        }
    }

    public function excluir(ProdutoLote $produtoLote)
    {
        try {
            $cod_produto = $produtoLote->getCodigo();
            $cod_lote = $produtoLote->getLote()->getCodigo();
            $resultado = $this->delete('produto_lote', 'cod_produto = ' . $cod_produto . ' AND cod_lote = ' . $cod_lote);

            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}