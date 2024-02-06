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
            $pdoStatement = $this->select("SELECT c.*, cp.nome, cp.descricao cp.desconto FROM carrinho c, cupom cp
                WHERE c.codigo = $codigo AND cp.codigo = c.cod_cupom");

            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $carrinho = new Carrinho(
                $arrayResultado['codigo'],
                0.0,
                $arrayResultado['cod_cupom'],
                $arrayResultado['nome'],
                $arrayResultado['descricao'],
                $arrayResultado['desconto']
            );
            
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