<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Lib\Validador;
use App\Model\Entidades\Funcionario;

class FuncionarioController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $funcionario = new Funcionario();
            $resultado = $funcionario->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca);

            $totalRegistros = $funcionario->contarTotalRegistros("funcionario", "nome LIKE '%$busca%' OR setor LIKE '%$busca%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/funcionario', $paginaSelecionada, $totalPaginas, $busca);

            if(is_array($resultado))
            {
                $this->setDados('funcionarios', $resultado);
                $this->setDados('paginacao', $paginacao);
            }
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
            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }
            
            $this->renderizar('funcionario/cadastro');
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function cadastrar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $cpf_validado = Validador::validarCpf($_POST['cpf']);
            $nome_validado = Validador::validarNome($_POST['nome']);
            $salario_validado = Validador::validarMonetario($_POST['salario']);

            $validacao_formulario = [
                'cpf_validado' => $cpf_validado,
                'nome_validado' => $nome_validado,
                'salario_validado' => $salario_validado
            ];



            if (in_array(false, $validacao_formulario))
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario($validacao_formulario);
                $this->redirecionar('/funcionario/encaminharCadastro');
                exit;
            }
            
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

            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }
            
            $this->renderizar('funcionario/edicao');
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $cpf_validado = Validador::validarCpf($_POST['cpf']);
            $nome_validado = Validador::validarNome($_POST['nome']);
            $salario_validado = Validador::validarMonetario($_POST['salario']);

            $validacao_formulario = [
                'cpf_validado' => $cpf_validado,
                'nome_validado' => $nome_validado,
                'salario_validado' => $salario_validado
            ];



            if (in_array(false, $validacao_formulario))
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario($validacao_formulario);
                $this->redirecionar('/funcionario/encaminharEdicao/'. $_POST['codigo']);
                exit;
            }
            
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