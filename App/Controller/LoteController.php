<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Model\Entidades\Lote;
use App\Model\Entidades\Fornecedor;
use Exception;

class LoteController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $lote = new Lote();
            $resultado_lote = $lote->listar();
            
            $fornecedor = new Fornecedor();
            $resultado_fornecedor = $fornecedor->listar();

            if (is_array($resultado_lote) && is_array($resultado_fornecedor))
            {
                    $this->setDados('lotes', $resultado_lote);
                    $this->setDados('fornecedores', $resultado_fornecedor);
            }
            else if ($resultado_lote instanceof Exception)
                Sessao::setMensagem($resultado_lote->getMessage());
            else
                Sessao::setMensagem($resultado_fornecedor->getMessage());
    
            $this->renderizar('lote/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function cadastrar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $lote = new Lote(
                0 ,
                $_POST['data'],
                0.0,
                $_POST['fornecedor'],
            );

            $resultado = $lote->cadastrar();

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