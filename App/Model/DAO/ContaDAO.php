<?php

namespace App\Model\DAO;

use App\Model\Entidades\Conta\Administrador;
use App\Model\Entidades\Conta\Conta;
use App\Model\Entidades\Conta\Administraor;
use App\Model\Entidades\Conta\Cliente;
use Exception;
use PDO;

class ContaDAO extends BaseDAO
{
    public function cadastrar(Conta $conta)
    {
        try {
            $nome = $conta->getNome();
            $email = $conta->getEmail();
            $nomeUsuario = $conta->getNomeUsuario();
            $senha = $conta->getSenha();

            $resultado = $this->insert(
                'conta',
                ':email, :nome, :nome_usuario, :senha',
                [
                    ':nome' => $nome,
                    ':email' => $email,
                    ':nome_usuario' => $nomeUsuario,
                    ':senha' => $senha
            ]);

            if ($conta instanceof Administrador)
            {
                $credencial = $conta->getCredencial();

                $resultado = $this->insert(
                    'administrador',
                    ':codigo, :credencial',
                    [
                        ':credencial' => $credencial
                        ':credencial' => $credencial
                    ]);
            }
            else if ($conta instanceof Cliente)
            {
                $telefone = $conta->getTelefone();

                $resultado = $this->insert(
                    'cliente',
                    ':telefone',
                    [':telefone' => $telefone]
                );
            }
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }
}