<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Model\Entidades\Conta\Conta;
use App\Model\Entidades\Conta\Administrador;
use App\Model\Entidades\Conta\Cliente;

class ContaController extends BaseController
{

    public function encaminharCadastro()
    {
        $this->renderizar('conta/cadastro');

        Sessao::setMensagem(null);
    }
    
    public function cadastrar()
    {
        if ($_POST['tipo'] == "cliente")
        {
            $conta = new Cliente(
                0,
                $_POST['nome'],
                $_POST['email'],
                $_POST['nome_usuario'],
                $_POST['senha'],
                $_POST['tipo'],
                $_POST['telefone'],
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
                $_POST['credencial'],
            );
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

            if ($resultado instanceof Conta)
                $this->setDados('conta', $resultado);
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

            $this->renderizar('conta/edicao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador') || Sessao::verificarAcesso('cliente'))
        {
            if (Sessao::getTipoConta() == 'administrador')
            {
                $conta = new Administrador(
                    $_POST['codigo'],
                    $_POST['nome'],
                    $_POST['email'],
                    $_POST['nome_usuario'],
                    "",
                    "",
                    $_POST['credencial']
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
        
        $this->renderizar('conta/trocaSenha');
        Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function trocarSenha()
    {
        if (Sessao::verificarAcesso('administrador') || Sessao::verificarAcesso('cliente'))
        {
            $codigo = Sessao::getCodigoConta();
            $senha = $_POST['senha'];
            $confirma_senha = $_POST['confirma_senha'];
            
            if ($senha == $confirma_senha)
            {
                $resultado = Conta::trocarSenha($codigo, $senha);

                if (is_bool($resultado) && $resultado)
                    Sessao::setMensagem("Senha trocada com sucesso!");
                else
                    Sessao::setMensagem($resultado->getMessage());

                $this->redirecionar('/conta/encaminharPerfil');
            }
            else
            {
                Sessao::setMensagem("Senha e confirmação de senha não conferem");
                $this->redirecionar('/conta/encaminharTrocaSenha/' . $codigo);
            }
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}