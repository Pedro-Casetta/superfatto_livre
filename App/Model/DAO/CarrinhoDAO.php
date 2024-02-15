<?php

namespace App\Model\DAO;

use App\Model\Entidades\Carrinho;
use Exception;
use PDO;

class CarrinhoDAO extends BaseDAO
{
    public function localizar($codigo)
    {
        try {

            $pdoStatement = $this->select("SELECT c.*, cp.nome, cp.descricao, cp.desconto
            FROM carrinho c
            LEFT OUTER JOIN cupom cp ON cp.codigo = c.cod_cupom
            WHERE c.codigo = $codigo");

            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            if ($arrayResultado['cod_cupom'] == null)
            {
                $carrinho = new Carrinho(
                    $arrayResultado['codigo'],
                    $arrayResultado['total']
                );
            }
            else
            {
                $carrinho = new Carrinho(
                    $arrayResultado['codigo'],
                    $arrayResultado['total'],
                    $arrayResultado['cod_cupom'],
                    $arrayResultado['nome'],
                    $arrayResultado['descricao'],
                    $arrayResultado['desconto']
                );
            }
            
            return $carrinho;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function aplicarCupom(Carrinho $carrinho)
    {
        try {
            $codigo = $carrinho->getCodigo();
            $cod_cupom = $carrinho->getCupom()->getCodigo();

            $resultado = $this->update(
                'carrinho',
                'cod_cupom = :cod_cupom',
                [
                 ':cod_cupom' => $cod_cupom
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
}