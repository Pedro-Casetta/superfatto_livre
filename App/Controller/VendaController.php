<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Model\Entidades\Venda;
use App\Model\Entidades\ProdutoVenda;
use App\Model\Entidades\Fornecedor;
use App\Model\DAO\FornecedorDAO;
use Exception;

class LoteController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $departamento = (isset($_GET['departamento'])) ? $_GET['departamento'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $lote = new Lote();
            $resultado_lote = $lote->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca, $departamento);
            
            $fornecedor = new Fornecedor();
            $resultado_fornecedor = $fornecedor->listar();

            $fornecedorDAO = new FornecedorDAO();
            $resultado_departamento = $fornecedorDAO->listarDepartamentos();

            $totalRegistros = $lote->contarTotalRegistros(
                "lote l, fornecedor f, departamento d",
                "l.cod_fornecedor = f.codigo AND f.cod_departamento = d.codigo
            AND l.data LIKE '%$busca%' AND d.nome LIKE '%$departamento%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/lote', $paginaSelecionada, $totalPaginas, $busca, $departamento);

            if (is_array($resultado_lote) && is_array($resultado_fornecedor) && is_array($resultado_departamento))
            {
                    $this->setDados('lotes', $resultado_lote);
                    $this->setDados('fornecedores', $resultado_fornecedor);
                    $this->setDados('paginacao', $paginacao);
                    $this->setDados('departamentos', $resultado_departamento);
            }
            else if ($resultado_lote instanceof Exception)
                Sessao::setMensagem($resultado_lote->getMessage());
            else if ($resultado_fornecedor instanceof Exception)
                Sessao::setMensagem($resultado_fornecedor->getMessage());
            else
                Sessao::setMensagem($resultado_departamento->getMessage());
    
            $this->renderizar('lote/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function iniciarVenda()
    {
        if (!Sessao::verificarAcesso('administrador'))
        {
            $venda = new Venda(
                0 ,
                "",
                0.0,
                $_POST['cliente'],
            );

            $resultado = $venda->cadastrar();

            if (is_bool($resultado['resultado']) && $resultado['resultado'])
            {                
                $produtoVenda = new ProdutoVenda(
                    $_POST['produto'],
                    $resultado['cod_venda'],
                    $_POST['quantidade']
                );

                $resultado_produto_venda = $produtoVenda->cadastrar();

                if (is_bool($resultado_produto_venda) && $resultado_produto_venda)
                {
                    $resultado_produtos = $produtoVenda->listar($resultado['cod_venda']);
                    $venda->setCodigo($resultado['cod_venda']);
                    $resultado_venda = $venda->localizar();

                    if (is_array($resultado_produtos) && $resultado_venda instanceof Venda)
                    {
                        $this->setDados('venda', $resultado_venda);
                        $this->setDados('produtos', $resultado_produtos);
                        Sessao::setMensagem(null);
                    }
                    else if ($resultado_venda instanceof Exception)
                        Sessao::setMensagem($resultado_venda->getMessage());
                    else
                        Sessao::setMensagem($resultado_produtos->getMessage());
                
                    $this->renderizar('venda/endereco');
                }
                else
                {
                    Sessao::setMensagem($resultado_produto_venda->getMessage());
                    $this->redirecionar('/');
                }
            }
            else
            {
                Sessao::setMensagem($resultado['resultado']->getMessage());
                $this->redirecionar('/');
            }

        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function salvarEndereco()
    {
        if (!Sessao::verificarAcesso('administrador'))
        {
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharEdicao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];
            $lote = new Lote($codigo);
            $resultado_lote = $lote->localizar();

            $fornecedor = new Fornecedor();
            $resultado_fornecedor = $fornecedor->listar();

            if ($resultado_lote instanceof Lote && is_array($resultado_fornecedor))
            {
                $this->setDados('lote', $resultado_lote);
                $this->setDados('fornecedores', $resultado_fornecedor);
                Sessao::setMensagem(null);
            }
            else if ($resultado_lote instanceof Exception)
                Sessao::setMensagem($resultado_lote->getMessage());
            else
                Sessao::setMensagem($resultado_fornecedor->getMessage());

            $this->renderizar('lote/edicao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $lote = new Lote(
                $_POST['codigo'],
                $_POST['data'],
                0.0,
                $_POST['fornecedor']
            );

            $resultado = $lote->atualizar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados atualizados com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/lote');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharExclusao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];

            $lote = new Lote($codigo);
            $resultado = $lote->localizar();

            if ($resultado instanceof Lote)
            {
                $this->setDados('lote', $resultado);
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
            $codigo = $_POST['codigo'];
            $lote = new Lote($codigo);
            $resultado = $lote->excluir();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados excluídos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/lote');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}