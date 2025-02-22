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

            $pdoStatement = $this->select("SELECT c.* FROM carrinho c WHERE c.codigo = $codigo");

            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $carrinho = new Carrinho(
                $arrayResultado['codigo'],
                $arrayResultado['total']
            );
            
            return $carrinho;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function limpar(Carrinho $carrinho)
    {
        try {
            $codigo = $carrinho->getCodigo();
            $resultado = $this->delete('produto_carrinho', 'cod_carrinho = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}