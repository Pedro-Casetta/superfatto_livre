<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Lib\Validador;
use App\Model\Entidades\Departamento;

class DepartamentoController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $departamento = new Departamento();
            $resultado = $departamento->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca);

            $totalRegistros = $departamento->contarTotalRegistros("departamento", "nome LIKE '%$busca%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/departamento', $paginaSelecionada, $totalPaginas, $busca);

            if(is_array($resultado))
            {
                $this->setDados('departamentos', $resultado);
                $this->setDados('paginacao', $paginacao);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
            
            $this->renderizar('departamento/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function cadastrar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $departamento = new Departamento(0, $_POST['nome']);

            $resultado = $departamento->cadastrar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados inseridos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/departamento');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharEdicao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];
            $departamento = new Departamento($codigo);
            $resultado = $departamento->localizar();

            if ($resultado instanceof Departamento)
            {
                $this->setDados('departamento', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
            
            $this->renderizar('departamento/edicao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $departamento = new Departamento($_POST['codigo'], $_POST['nome']);

            $resultado = $departamento->atualizar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados atualizados com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/departamento');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharExclusao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];

            $departamento = new Departamento($codigo);
            $resultado = $departamento->localizar();

            if ($resultado instanceof Departamento)
            {
                $this->setDados('departamento', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('departamento/exclusao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function excluir()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $_POST['codigo'];
            $departamento = new Departamento($codigo);
            $resultado = $departamento->excluir();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados excluídos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/departamento');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}