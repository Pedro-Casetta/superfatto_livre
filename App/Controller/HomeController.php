<?php


namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Model\Entidades\Produto;
use App\Model\DAO\ProdutoDAO;

class HomeController extends BaseController
{
    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $this->renderizar('home/index_administrador');
        }
        else
        {
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $departamento = (isset($_GET['departamento'])) ? $_GET['departamento'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $produto = new Produto();
            $resultado = $produto->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca, $departamento);

            $produtoDAO = new ProdutoDAO();
            $resultado_departamento = $produtoDAO->listarDepartamentos();

            $totalRegistros = $produto->contarTotalRegistros(
                "produto p, departamento d",
                "d.codigo = p.cod_departamento
            AND p.nome LIKE '%$busca%' AND d.nome LIKE '%$departamento%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/', $paginaSelecionada, $totalPaginas, $busca, $departamento);

            if(is_array($resultado) && is_array($resultado_departamento))
            {
                $this->setDados('produtos', $resultado);
                $this->setDados('paginacao', $paginacao);
                $this->setDados('departamentos', $resultado_departamento);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
            
            $this->renderizar('home/index');
        }
        Sessao::setMensagem(null);
    }
}