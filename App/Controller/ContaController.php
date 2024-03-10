<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Model\Entidades\Conta\Conta;
use App\Model\Entidades\Conta\Administrador;
use App\Model\Entidades\Conta\Cliente;
use App\Model\DAO\ProdutoDAO;
use App\Lib\Validador;
use Exception;

class ContaController extends BaseController
{

    public function encaminharCadastro()
    {
        $produtoDAO = new ProdutoDAO();
        $resultado = $produtoDAO->listarDepartamentos();
        
        if (is_array($resultado))
            $this->setDados('departamentos', $resultado);
        else
            Sessao::setMensagem($resultado->getMessage());

        if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
        {
            $this->setDados('formulario', Sessao::getFormulario());
            $this->setDados('validacao', Sessao::getValidacaoFormulario());
        }
        
        $this->renderizar('conta/cadastro');
        Sessao::setMensagem(null);
        Sessao::setFormulario(null);
        Sessao::setValidacaoFormulario(null);
    }
    
    public function cadastrar()
    {
        $nome_validado = Validador::validarNome($_POST['nome']);
        $email_validado = Validador::validarEmail($_POST['email']);
        $email_novo = Conta::localizarEmail($_POST['email']);
        $usuario_validado = Validador::validarNomeUsuario($_POST['nome_usuario']);
        $usuario_novo = Conta::localizarNomeUsuario($_POST['nome_usuario']);
        $senha_validada = Validador::validarSenha($_POST['senha']);
        $telefone_validado = (!empty($_POST['telefone']) ? Validador::validarTelefone($_POST['telefone']) : true);
        $confirmacao_senha = ($_POST['senha'] == $_POST['confirma_senha'] ? true : false);

        $validacao_formulario = [
            'nome_validado' => $nome_validado,
            'email_validado' => $email_validado,
            'email_novo' => $email_novo,
            'usuario_validado' => $usuario_validado,
            'usuario_novo' => $usuario_novo,
            'senha_validada' => $senha_validada,
            'telefone_validado' => $telefone_validado,
            'confirmacao_senha' => $confirmacao_senha
        ];

        if (in_array(false, $validacao_formulario))
        {
            Sessao::setFormulario($_POST);
            Sessao::setValidacaoFormulario($validacao_formulario);
            $this->redirecionar('/conta/encaminharCadastro');
            exit;
        }
        
        if ($_POST['tipo'] == "cliente")
        {
            $conta = new Cliente(
                0,
                $_POST['nome'],
                $_POST['email'],
                $_POST['nome_usuario'],
                $_POST['senha'],
                $_POST['tipo'],
                $_POST['telefone']
            );            
        }
        else if ($_POST['tipo'] == "administrador")
        {
            $conta = new Administrador(
                0,
                $_POST['nome'],
                $_POST['email'],
                $_POST['nome_usuario'],
                $_POST['senha'],
                $_POST['tipo'],
                0,
                $_POST['credencial']
            );

            $resultado_credencial = $conta->verificarCredencial();
            
            if (is_int($resultado_credencial))
            {
                $conta->getCredencial()->setCodigo($resultado_credencial);
            }
            else if ($resultado_credencial == "inválido")
            {
                Sessao::setMensagem("Credencial do administrador não confere!");
                $this->redirecionar('/conta/encaminharCadastro');
                exit;
            }
            else if ($resultado_credencial instanceof Exception)
            {
                Sessao::setMensagem($resultado_credencial->getMessage());
                $this->redirecionar('/conta/encaminharCadastro');
                exit;
            }
            else
            {
                Sessao::setMensagem("Erro ao verificar credencial!");
                $this->redirecionar('/conta/encaminharCadastro');
                exit;
            }
        }

        $resultado = $conta->cadastrar();

        if (is_bool($resultado) && $resultado)
            Sessao::setMensagem("Dados inseridos com sucesso!");
        else
            Sessao::setMensagem($resultado->getMessage());

        $this->redirecionar('/home');
    }

    public function encaminharAcesso()
    {
        $produtoDAO = new ProdutoDAO();
        $resultado = $produtoDAO->listarDepartamentos();
        
        if(is_array($resultado))
                $this->setDados('departamentos', $resultado);
        else
            Sessao::setMensagem($resultado->getMessage());
        
        $this->renderizar('conta/acesso');

        Sessao::setMensagem(null);
    }

    public function acessar()
    {
        $nome_usuario = $_POST['nome_usuario'];
        $senha = $_POST['senha'];
        $resultado = Conta::acessar($nome_usuario, $senha);

        if ($resultado instanceof Conta){
            Sessao::setCodigoConta($resultado->getCodigo());
            Sessao::setNomeUsuario($resultado->getNomeUsuario());
            Sessao::setTipoConta($resultado->getTipo());
            $this->redirecionar('/home');
        }
        else if ($resultado == false) {
            Sessao::setMensagem('Nome de usuário ou senha incorretos.');
            $this->redirecionar('/conta/encaminharAcesso');
        }
        else {
            Sessao::setMensagem($resultado->getMessage());
            $this->redirecionar('/conta/encaminharAcesso');
        }

    }

    public function logout()
    {
        Sessao::logout();

        $this->redirecionar('/home');
    }

    public function encaminharPerfil()
    {
        if (Sessao::verificarAcesso('administrador') || Sessao::verificarAcesso('cliente'))
        {
            $codigo = Sessao::getCodigoConta();
            $tipo = Sessao::getTipoConta();

            $resultado = Conta::localizar($codigo, $tipo);

            $produtoDAO = new ProdutoDAO();
            $resultado_departamento = $produtoDAO->listarDepartamentos();

            if ($resultado instanceof Conta && is_array($resultado_departamento))
            {
                $this->setDados('conta', $resultado);
                $this->setDados('departamentos', $resultado_departamento);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('conta/perfil');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharEdicao($parametros)
    {
        if (Sessao::verificarAcesso('administrador') || Sessao::verificarAcesso('cliente'))
        {
            $codigo = $parametros[0];
            $tipo = Sessao::getTipoConta();
            $resultado = Conta::localizar($codigo, $tipo);

            if ($resultado instanceof Conta)
            {
                $this->setDados('conta', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }
            
            $this->renderizar('conta/edicao');
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador') || Sessao::verificarAcesso('cliente'))
        {
            $nome_validado = Validador::validarNome($_POST['nome']);
            $email_validado = Validador::validarEmail($_POST['email']);
            $email_novo = Conta::localizarEmail($_POST['email'], Sessao::getCodigoConta());
            $usuario_validado = Validador::validarNomeUsuario($_POST['nome_usuario']);
            $usuario_novo = Conta::localizarNomeUsuario($_POST['nome_usuario'], Sessao::getCodigoConta());
            $telefone_validado = (!empty($_POST['telefone']) ? Validador::validarTelefone($_POST['telefone']) : true);

            $validacao_formulario = [
                'nome_validado' => $nome_validado,
                'email_validado' => $email_validado,
                'email_novo' => $email_novo,
                'usuario_validado' => $usuario_validado,
                'usuario_novo' => $usuario_novo,
                'telefone_validado' => $telefone_validado
            ];

            if (in_array(false, $validacao_formulario))
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario($validacao_formulario);
                $this->redirecionar('/conta/encaminharEdicao/' . $_POST['codigo']);
                exit;
            }
            
            if (Sessao::getTipoConta() == 'administrador')
            {
                $conta = new Administrador(
                    $_POST['codigo'],
                    $_POST['nome'],
                    $_POST['email'],
                    $_POST['nome_usuario']
                );
            }
            else if (Sessao::getTipoConta() == 'cliente')
            {
                $conta = new Cliente(
                    $_POST['codigo'],
                    $_POST['nome'],
                    $_POST['email'],
                    $_POST['nome_usuario'],
                    "",
                    "",
                    $_POST['telefone']
                );
            }

            $resultado = $conta->atualizar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados atualizados com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/conta/encaminharPerfil');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharExclusao($parametros)
    {
        if (Sessao::verificarAcesso('administrador') || Sessao::verificarAcesso('cliente'))
        {
            $codigo = $parametros[0];
            $tipo = Sessao::getTipoConta();

            $resultado = Conta::localizar($codigo, $tipo);

            if ($resultado instanceof Conta)
            {
                $this->setDados('conta', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('conta/exclusao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function excluir()
    {
        if (Sessao::verificarAcesso('administrador') || Sessao::verificarAcesso('cliente'))
        {
            $codigo = $_POST['codigo'];
            $resultado = Conta::excluir($codigo);

            if (is_bool($resultado) && $resultado)
            {
                Sessao::setMensagem("Dados excluídos com sucesso!");
                Sessao::logout();
            }
            else
                Sessao::setMensagem($resultado->getMessage());
        
            $this->redirecionar('/conta/encaminharCadastro');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
    
    public function encaminharTrocaSenha($parametros)
    {
        if (Sessao::verificarAcesso('administrador') || Sessao::verificarAcesso('cliente'))
        {
            $codigo = $parametros[0];
            $tipo = Sessao::getTipoConta();
            $resultado = Conta::localizar($codigo, $tipo);

            if ($resultado instanceof Conta)
            {
                $this->setDados('conta', $resultado);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }
        
            $this->renderizar('conta/trocaSenha');
            Sessao::setMensagem(null);
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function trocarSenha()
    {
        if (Sessao::verificarAcesso('administrador') || Sessao::verificarAcesso('cliente'))
        {
            $codigo = Sessao::getCodigoConta();
            $senha_validada = Validador::validarSenha($_POST['senha']);
            $confirmacao_senha = ($_POST['senha'] == $_POST['confirma_senha'] ? true : false);

            $validacao_formulario = [
                'senha_validada' => $senha_validada,
                'confirmacao_senha' => $confirmacao_senha
            ];

            if (in_array(false, $validacao_formulario))
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario($validacao_formulario);
                $this->redirecionar('/conta/encaminharTrocaSenha/' . $codigo);
                exit;
            }
            
            $senha = $_POST['senha'];
            
            $resultado = Conta::trocarSenha($codigo, $senha);

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Senha trocada com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/conta/encaminharPerfil');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}