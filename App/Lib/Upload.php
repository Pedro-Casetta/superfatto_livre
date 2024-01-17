<?php

namespace App\Lib;

class Upload
{
    public function subirImagem($caminho)
    {
        if ($_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE)
        {
            $imgPath = "public/imagem/" . $caminho . "/";
            
            $imagemNome = $_FILES['imagem']['name'];
            $imagemTmp = $_FILES['imagem']['tmp_name'];

            $imgNomeArray = explode('.', $imagemNome);
            $imgTipo = strtolower(end($imgNomeArray));

            $novaImagem = uniqid();
            $novaImagem .= "." . $imgTipo;

            $resultado = move_uploaded_file($imagemTmp, $imgPath . $novaImagem);

            if ($resultado)
                return $novaImagem;
            else
                return false;
        }
        else
            return false;
    }

    public function removerImagem($caminho)
    {
        return unlink("public/imagem/" . $caminho);
    }
}