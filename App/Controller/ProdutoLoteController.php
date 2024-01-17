<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Model\Entidades\ProdutoLote;
use App\Model\Entidades\Produto;
use App\Model\Entidades\Lote;
use Exception;

class LoteController extends BaseController
{

    public function index($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $cod_lote = $parametros[0];
            $produtoLote = new ProdutoLote(0, $cod_lote);
            $resultado_produto_lote = $produtoLote->listar();
            
            $produto = new Produto();
            $resultado_produto = $produto->listar();

            $lote = new Lote($cod_lote);
            $resultado_lote = $lote->localizar();

            if (is_array($resultado_produto_lote) && is_array($resultado_produto) && $resultado_lote instanceof Lote)
            {
                    $this->setDados('produtos_lote', $resultado_produto_lote);
                    $this->setDados('produtos', $resultado_produto);
                    $this->setDados('lote', $resultado_lote);
            }
            else if ($resultado_produto_lote instanceof Exception)
                Sessao::setMensagem($resultado_produto_lote->getMessage());
            else if ($resultado_lote instanceof Exception)
                Sessao::setMensagem($resultado_lote->getMessage());
            else
                Sessao::setMensagem($resultado_produto->getMessage());
    
            $this->renderizar('produto_lote/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function cadastrar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $produtoLote = new ProdutoLote(
                $_POST['produto'],
                $_POST['lote'],
                $_POST['quantidade']
            );

            $resultado = $produtoLote->cadastrar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados inseridos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/lote');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharEdicao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $cod_lote = $parametros[0];
            $cod_produto = $parametros[1];
            $produtoLote = new ProdutoLote($cod_produto, $cod_lote);
            $resultado_produto_lote = $produtoLote->localizar();

            $produto = new Produto();
            $resultado_produto = $produto->listar();

            $lote = new Lote($cod_lote);
            $resultado_lote = $lote->localizar();

            if ($resultado_produto_lote instanceof ProdutoLote && is_array($resultado_produto) && $lote instanceof Lote)
            {
                $this->setDados('produto_lote', $resultado_produto_lote);
                $this->setDados('produtos', $resultado_produto);
                $this->setDados('lote', $resultado_lote);
                Sessao::setMensagem(null);
            }
            else if ($resultado_produto_lote instanceof Exception)
                Sessao::setMensagem($resultado_produto_lote->getMessage());
            else if ($resultado_lote instanceof Exception)
                Sessao::setMensagem($resultado_lote->getMessage());
            else
                Sessao::setMensagem($resultado_produto->getMessage());

            $this->renderizar('produto_lote/edicao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $produtoLote = new ProdutoLote(
                $_POST['produto'],
                $_POST['lote'],
                $_POST['quantidade'],
            );

            $resultado = $produtoLote->atualizar($_POST['velho_cod_produto']);

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados atualizados com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/produto_lote');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharExclusao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $cod_lote = $parametros[0];
            $cod_produto = $parametros[1];

            $produtoLote = new ProdutoLote($cod_produto, $cod_lote);
            $resultado = $produtoLote->localizar();

            if ($resultado instanceof ProdutoLote)
            {
                $this->setDados('produto_lote', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('lote/exclusao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function excluir()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $cod_produto = $_POST['produto'];
            $cod_lote = $_POST['lote'];
            $produtoLote = new ProdutoLote($cod_produto, $cod_lote);
            $resultado = $produtoLote->excluir();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados excluídos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/produto_lote');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}