<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Model\Entidades\Conta\Administrador;
use App\Model\Entidades\Conta\Cliente;
use Exception;

class ContaController extends BaseController
{

    public function encaminharCadastro()
    {
        $this->renderizar('conta/cadastro');
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
}