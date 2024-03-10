<?php

namespace App\Model\DAO;

use App\Model\Entidades\Endereco;
use Exception;
use PDO;

class EnderecoDAO extends BaseDAO
{
    public function localizar($codigo)
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM endereco WHERE codigo = '$codigo'");

            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $endereco = new Endereco(
                $arrayResultado['codigo'],
                $arrayResultado['rua'],
                $arrayResultado['numero'],
                $arrayResultado['bairro'],
                $arrayResultado['cidade'],
                $arrayResultado['estado'],
                $arrayResultado['cep']
            );
            
            return $endereco;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }
    
    public function listar($cod_cliente)
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM endereco
                WHERE cod_cliente = $cod_cliente");

            $arrayEnderecos = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $enderecos = [];

            foreach($arrayEnderecos as $enderecoEncontrado)
            {
                $endereco = new Endereco(
                    $enderecoEncontrado['codigo'],
                    $enderecoEncontrado['rua'],
                    $enderecoEncontrado['numero'],
                    $enderecoEncontrado['bairro'],
                    $enderecoEncontrado['cidade'],
                    $enderecoEncontrado['estado'],
                    $enderecoEncontrado['cep']
                );

                $enderecos[] = $endereco;
            }

            return $enderecos;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "", $cod_cliente)
    {
        try {
            $pdoStatement = $this->select("SELECT * FROM endereco
                WHERE cod_cliente = $cod_cliente
            AND rua LIKE '%$busca%' OR numero LIKE '%$busca%'
            OR bairro LIKE '%$busca%' OR cidade LIKE '%$busca%'
            OR estado LIKE '%$busca%' OR cep LIKE '%$busca%' LIMIT $indice, $limitePorPagina");

            $arrayEnderecos = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $enderecos = [];

            foreach($arrayEnderecos as $enderecoEncontrado)
            {
                $endereco = new Endereco(
                    $enderecoEncontrado['codigo'],
                    $enderecoEncontrado['rua'],
                    $enderecoEncontrado['numero'],
                    $enderecoEncontrado['bairro'],
                    $enderecoEncontrado['cidade'],
                    $enderecoEncontrado['estado'],
                    $enderecoEncontrado['cep']
                );

                $enderecos[] = $endereco;
            }

            return $enderecos;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(Endereco $endereco)
    {
        try {
            $rua = $endereco->getRua();
            $numero = $endereco->getNumero();
            $bairro = $endereco->getBairro();
            $cidade = $endereco->getCidade();
            $estado = $endereco->getEstado();
            $cep = $endereco->getCep();
            $cliente = $endereco->getCliente()->getCodigo();

            $resultado = $this->insert(
                'endereco',
                ':rua, :numero, :bairro, :cidade, :estado, :cep, :cod_cliente',
                [
                    ':rua' => $rua,
                    ':numero' => $numero,
                    ':bairro' => $bairro,
                    ':cidade' => $cidade,
                    ':estado' => $estado,
                    ':cep' => $cep,
                    ':cod_cliente' => $cliente
            ]);

            $arrayResultado = ['resultado' => $resultado, 'codigo' => $this->getConexao()->lastInsertId()];
            
            return $arrayResultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function atualizar(Endereco $endereco)
    {
        try {
            $codigo = $endereco->getCodigo();
            $rua = $endereco->getRua();
            $numero = $endereco->getNumero();
            $bairro = $endereco->getBairro();
            $cidade = $endereco->getCidade();
            $estado = $endereco->getEstado();
            $cep = $endereco->getCep();

            $resultado = $this->update(
                'endereco',
                'rua = :rua, numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep',
                [
                 ':rua' => $rua,
                 ':numero' => $numero,
                 ':bairro' => $bairro,
                 ':cidade' => $cidade,
                 ':estado' => $estado,
                 ':cep' => $cep
                ],
                'codigo = ' . $codigo
            );
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na atualização dos dados");
            return $erro;
        }
    }

    public function excluir(Endereco $endereco)
    {
        try {
            $codigo = $endereco->getCodigo();
            $resultado = $this->delete('endereco', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            if ($excecao->getCode() == 23000)
                $erro = new Exception("Erro " . $excecao->getCode() . ". Endereco não foi excluído pois está em uma venda.");
            else
                $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}