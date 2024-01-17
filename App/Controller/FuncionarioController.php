<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Model\Entidades\Funcionario;
use Exception;

class FuncionarioController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $funcionario = new Funcionario();
            $resultado = $funcionario->listar();

            if(is_array($resultado))
                $this->setDados('funcionarios', $resultado);
            else
                Sessao::setMensagem($resultado->getMessage());
            
            $this->renderizar('funcionario/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharCadastro()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $this->renderizar('funcionario/cadastro');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function cadastrar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $funcionario = new Funcionario(
                0,
                $_POST['cpf'],
                $_POST['nome'],
                $_POST['setor'],
                $_POST['salario']
            );

            $resultado = $funcionario->cadastrar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados inseridos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/funcionario');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharEdicao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];
            $funcionario = new Funcionario($codigo);
            $resultado = $funcionario->localizar();


            if ($resultado instanceof Funcionario)
            {
                $this->setDados('funcionario', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('funcionario/edicao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $funcionario = new Funcionario(
                $_POST['codigo'],
                $_POST['cpf'],
                $_POST['nome'],
                $_POST['setor'],
                $_POST['salario']
            );

            $resultado = $funcionario->atualizar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados atualizados com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/funcionario');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharExclusao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];

            $funcionario = new Funcionario($codigo);
            $resultado = $funcionario->localizar();

            if ($resultado instanceof Funcionario)
            {
                $this->setDados('funcionario', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('funcionario/exclusao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function excluir()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $_POST['codigo'];
            $funcionario = new Funcionario($codigo);
            $resultado = $funcionario->excluir();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados excluídos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/funcionario');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}