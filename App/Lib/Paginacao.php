<?php

namespace App\Lib;

abstract class Paginacao
{
    public static int $limitePorPagina = 8;

    public static function calcularIndice($paginaSelecionada)
    {
        $indice = ($paginaSelecionada - 1) * self::$limitePorPagina;
        return $indice;
    }

    public static function criarPaginacao($caminho, $paginaSelecionada, $totalPaginas, $busca = "", $departamento = "")
    {
        $paginaAnterior = $paginaSelecionada - 1;
        $paginaSeguinte = $paginaSelecionada + 1;

        if ($paginaAnterior <= 0)
            $paginaAnterior = $paginaSelecionada;
        if ($paginaSeguinte > $totalPaginas)
            $paginaSeguinte = $paginaSelecionada;
        
        $paginacao = '
        <div class="row">
            <ul class="nav">
                <li class="nav-item">
                    <a href="http://' . APP_HOST . $caminho . '?paginaSelecionada=' . $paginaAnterior .
                    '&departamento=' . $departamento . '&busca=' . $busca . '" class="btn btn-dark">
                        <i class="bi bi-caret-left">&ensp;</i>Anterior
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">' . $paginaSelecionada . ' de ' . $totalPaginas . '</a>
                </li>
                <li class="nav-item">
                    <a href="http://' . APP_HOST . $caminho . '?paginaSelecionada=' . $paginaSeguinte .
                    '&departamento=' . $departamento . '&busca=' . $busca . '" class="btn btn-dark">
                        <i class="bi bi-caret-right">&ensp;</i>Próximo
                    </a>
                </li>
            </ul>
        </div>
        ';

        return $paginacao;
    }
}