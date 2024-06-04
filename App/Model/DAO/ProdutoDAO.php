<?php

namespace App\Model\DAO;

use App\Model\Entidades\Produto;
use Exception;
use PDO;

class ProdutoDAO extends BaseDAO
{
    public function localizar($codigo)
    {
        try {
            $pdoStatement = $this->select("SELECT p.*, d.nome nome_departamento FROM produto p, departamento d
                WHERE p.codigo = $codigo AND d.codigo = p.cod_departamento");

            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $produto = new Produto(
                $arrayResultado['codigo'],
                $arrayResultado['nome'],
                $arrayResultado['preco'],
                $arrayResultado['estoque'],
                $arrayResultado['imagem'],
                $arrayResultado['cod_departamento'],
                $arrayResultado['nome_departamento']
            );
            
            return $produto;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listar()
    {
        try {
            $pdoStatement = $this->select("SELECT p.*, d.nome nome_departamento FROM produto p, departamento d
                WHERE d.codigo = p.cod_departamento");

            $arrayProdutos = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $produtos = [];

            foreach($arrayProdutos as $produtoEncontrado)
            {
                $produto = new Produto(
                    $produtoEncontrado['codigo'],
                    $produtoEncontrado['nome'],
                    $produtoEncontrado['preco'],
                    $produtoEncontrado['estoque'],
                    $produtoEncontrado['imagem'],
                    $produtoEncontrado['cod_departamento'],
                    $produtoEncontrado['nome_departamento']
                );

                $produtos[] = $produto;
            }

            return $produtos;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "", $departamento = "")
    {
        try {
            $pdoStatement = $this->select("SELECT p.*, d.nome nome_departamento FROM produto p
            INNER JOIN departamento d ON d.codigo = p.cod_departamento
            WHERE p.nome LIKE '%$busca%' AND d.nome LIKE '%$departamento%' LIMIT $indice, $limitePorPagina");

            $arrayProdutos = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $produtos = [];

            foreach($arrayProdutos as $produtoEncontrado)
            {
                $produto = new Produto(
                    $produtoEncontrado['codigo'],
                    $produtoEncontrado['nome'],
                    $produtoEncontrado['preco'],
                    $produtoEncontrado['estoque'],
                    $produtoEncontrado['imagem'],
                    $produtoEncontrado['cod_departamento'],
                    $produtoEncontrado['nome_departamento']
                );

                $produtos[] = $produto;
            }

            return $produtos;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(Produto $produto)
    {
        try {
            $nome = $produto->getNome();
            $preco = $produto->getPreco();
            $estoque = $produto->getEstoque();
            $imagem = $produto->getImagem();
            $cod_departamento = $produto->getDepartamento()->getCodigo();

            $resultado = $this->insert(
                'produto',
                ':nome, :preco, :estoque, :imagem, :cod_departamento',
                [
                    ':nome' => $nome,
                    ':preco' => $preco,
                    ':estoque' => $estoque,
                    ':imagem' => $imagem,
                    ':cod_departamento' => $cod_departamento
            ]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function atualizar(Produto $produto)
    {
        try {
            $codigo = $produto->getCodigo();
            $nome = $produto->getNome();
            $preco = $produto->getPreco();
            $estoque = $produto->getEstoque();
            $imagem = $produto->getImagem();
            $cod_departamento = $produto->getDepartamento()->getCodigo();

            $resultado = $this->update(
                'produto',
                'nome = :nome, preco = :preco, estoque = :estoque, imagem = :imagem, cod_departamento = :cod_departamento',
                [
                    ':nome' => $nome,
                    ':preco' => $preco,
                    ':estoque' => $estoque,
                    ':imagem' => $imagem,
                    ':cod_departamento' => $cod_departamento
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

    public function excluir(Produto $produto)
    {
        try {
            $codigo = $produto->getCodigo();
            $resultado = $this->delete('produto', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            if ($excecao->getCode() == 23000)
                $erro = new Exception("Erro " . $excecao->getCode() .
            ". Produto não foi excluído pois está em um lote, em uma venda ou em um carrinho");
            else
                $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}