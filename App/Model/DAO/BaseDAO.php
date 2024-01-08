<?php

namespace App\Model\DAO;

use App\Lib\Conexao;

abstract class BaseDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function select($sql) 
    {
        if(!empty($sql))
        {
            return $this->conexao->query($sql);
        }
    }

    public function insert($tabela, $colunas, $valores) 
    {
        if(!empty($tabela) && !empty($colunas) && !empty($valores))
        {
            $parametros = $colunas;
            $colunas = str_replace(":", "", $colunas);

            $pdoStatement = $this->conexao->prepare("INSERT INTO $tabela ($colunas) VALUES ($parametros)");
            $resultado = $pdoStatement->execute($valores);

            return $resultado;
        }else{
            return false;
        }
    }

    public function update($tabela, $colunas, $valores, $where=null)
    {
        if(!empty($tabela) && !empty($colunas) && !empty($valores))
        {
            if($where)
            {
                $where = " WHERE $where ";
            }

            $pdoStatement = $this->conexao->prepare("UPDATE $tabela SET $colunas $where");
            $resultado = $pdoStatement->execute($valores);

            return $resultado;
        }else{
            return false;
        }
    }

    public function delete($tabela, $where=null)
    {
        if(!empty($tabela))
        {

            if($where)
            {
                $where = " WHERE $where ";
            }

            $pdoStatement = $this->conexao->prepare("DELETE FROM $tabela $where");
            $resultado = $pdoStatement->execute();

            return $resultado;
        }else{
            return false;
        }
    }

    public function getConexao()
    {
        return $this->conexao;
    }
}