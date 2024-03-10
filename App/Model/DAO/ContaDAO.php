<?php

namespace App\Model\DAO;

use App\Model\Entidades\Conta\Administrador;
use App\Model\Entidades\Conta\Cliente;
use App\Model\Entidades\Conta\Conta;
use Exception;
use PDO;
use PDOStatement;

class ContaDAO extends BaseDAO
{
    public function cadastrar(Conta $conta)
    {
        try {
            $nome = $conta->getNome();
            $email = $conta->getEmail();
            $nomeUsuario = $conta->getNomeUsuario();
            $senha = password_hash($conta->getSenha(), PASSWORD_DEFAULT);
            $tipo = $conta->getTipo();

            $resultado = $this->insert(
                'conta',
                ':email, :nome, :nome_usuario, :senha, :tipo',
                [
                    ':nome' => $nome,
                    ':email' => $email,
                    ':nome_usuario' => $nomeUsuario,
                    ':senha' => $senha,
                    ':tipo' => $tipo
            ]);

            $codigo = $this->getConexao()->lastInsertId();

            if ($conta instanceof Administrador)
            {
                $credencial = $conta->getCredencial()->getCodigo();

                $resultado = $this->insert(
                    'administrador',
                    ':codigo, :cod_credencial',
                    [
                        ':codigo' => $codigo,
                        ':cod_credencial' => $credencial
                    ]);
            }
            else if ($conta instanceof Cliente)
            {
                $telefone = $conta->getTelefone();

                $resultado = $this->insert(
                    'cliente',
                    ':codigo, :telefone',
                    [
                        ':codigo' => $codigo,
                        ':telefone' => $telefone
                    ]);
            }
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function verificarCredencial(Administrador $administrador)
    {
        $credencialInformada = $administrador->getCredencial()->getNome();
        
        $pdoStatement = $this->select("SELECT * FROM credencial");
        $arrayResultado = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        if (is_array($arrayResultado))
        {
            foreach($arrayResultado as $credencial)
            {
                if($credencial['nome'] == $credencialInformada)
                    return $credencial['codigo'];
            }
            return "inválido";
        }
        else
            return $arrayResultado;
    }

    public function acessar($nome_usuario, $senha)
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM conta WHERE nome_usuario = '$nome_usuario'");
            $resultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                if (password_verify($senha, $resultado['senha'])) {
                    if ($resultado['tipo'] == 'administrador') {
                        $conta = new Administrador(
                            $resultado['codigo'],
                            $resultado['nome'],
                            $resultado['email'],
                            $resultado['nome_usuario'],
                            $resultado['senha'],
                            $resultado['tipo']
                        );
                    }
                    else if ($resultado['tipo'] == 'cliente') {
                        $conta = new Cliente(
                            $resultado['codigo'],
                            $resultado['nome'],
                            $resultado['email'],
                            $resultado['nome_usuario'],
                            $resultado['senha'],
                            $resultado['tipo']
                        );
                    }

                    return $conta;
                }
                else
                    return false;
            } else {
                return $resultado;
            }

        } catch(Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function localizar($codigo, $tipo)
    {
        try {
            if ($tipo == 'administrador') {
                $pdoStatement = $this->select("SELECT c.*, a.cod_credencial, cr.nome nome_credencial
                FROM conta c, administrador a, credencial cr
                WHERE c.codigo = $codigo AND a.codigo = $codigo AND cr.codigo = a.cod_credencial");
                
                $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

                $conta = new Administrador(
                    $arrayResultado['codigo'],
                    $arrayResultado['nome'],
                    $arrayResultado['email'],
                    $arrayResultado['nome_usuario'],
                    $arrayResultado['senha'],
                    $arrayResultado['tipo'],
                    $arrayResultado['cod_credencial'],
                    $arrayResultado['nome_credencial']
                );
            }
            else if ($tipo == 'cliente') {
                $pdoStatement = $this->select("SELECT c.*, cl.telefone FROM conta c, cliente cl
                    WHERE c.codigo = $codigo AND cl.codigo = $codigo");
                
                $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

                $conta = new Cliente(
                    $arrayResultado['codigo'],
                    $arrayResultado['nome'],
                    $arrayResultado['email'],
                    $arrayResultado['nome_usuario'],
                    $arrayResultado['senha'],
                    $arrayResultado['tipo'],
                    $arrayResultado['telefone']
                );
            }
            
            return $conta;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function localizarNomeUsuario($nome_usuario, $codigoConta = null)
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM conta WHERE nome_usuario = '$nome_usuario'");
            $resultado = $pdoStatement->fetch();

            if ($resultado)
            {
                if (isset($codigoConta) && $codigoConta == $resultado['codigo'])
                    return true;
                return false;
            }
            else
                return true;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function localizarEmail($email, $codigoConta = null)
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM conta WHERE email = '$email'");
            $resultado = $pdoStatement->fetch();
            
            if ($resultado)
            {
                if (isset($codigoConta) && $codigoConta == $resultado['codigo'])
                    return true;
                return false;
            }
            else
                return true;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }
    
    public function atualizar(Conta $conta)
    {
        try {
            $codigo = $conta->getCodigo();
            $nome = $conta->getNome();
            $email = $conta->getEmail();
            $nome_usuario = $conta->getNomeUsuario();

            $resultado = $this->update(
                'conta',
                'nome = :nome, email = :email, nome_usuario = :nome_usuario',
                [
                 ':nome' => $nome,
                 ':email' => $email,
                 ':nome_usuario' => $nome_usuario
                ],
                'codigo = ' . $codigo
            );

            if ($conta instanceof Administrador)
            {
                $codigo = $conta->getCredencial()->getCodigo();
                $nome = $conta->getCredencial()->getNome();

                $resultado = $this->update(
                    'credencial',
                    'nome = :nome',
                    [
                        ':nome' => $nome
                    ],
                    'codigo = ' . $codigo
                );
            }
            else if ($conta instanceof Cliente)
            {
                $codigo = $conta->getCodigo();
                $telefone = $conta->getTelefone();

                $resultado = $this->update(
                    'cliente',
                    'telefone = :telefone',
                    [
                        ':telefone' => $telefone
                    ],
                    'codigo = ' . $codigo
                );
            }
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na atualização dos dados");
            return $erro;
        }
    }

    public function excluir($codigo)
    {
        try {
            $resultado = $this->delete('conta', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }

    public function trocarSenha($codigo, $senha)
    {
        try {

            $senha = password_hash($senha, PASSWORD_DEFAULT);
            
            $resultado = $this->update(
                'conta',
                'senha = :senha',
                [
                 ':senha' => $senha
                ],
                'codigo = ' . $codigo
            );

            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}