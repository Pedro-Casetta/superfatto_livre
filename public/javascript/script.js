function fecharMensagem($id) {
    document.getElementById($id).style.display = "none";
}

function exibirCampoCadastroConta($tipo) {

    if ($tipo == "administrador")
    {
        document.getElementById('campoCredencial').style.display = "inline";
        document.getElementById('credencial').setAttribute('required', '');
        document.getElementById('campoTelefone').style.display = "none";
        document.getElementById('telefone').removeAttribute('required');

    } else if ($tipo == "cliente") {
        document.getElementById('campoCredencial').style.display = "none";
        document.getElementById('credencial').removeAttribute('required');
        document.getElementById('campoTelefone').style.display = "inline";
        document.getElementById('telefone').setAttribute('required', '');
    } else {
        document.getElementById('campoTelefone').style.display = "none";
        document.getElementById('campoCredencial').style.display = "none";
        document.getElementById('credencial').removeAttribute('required');
        document.getElementById('telefone').removeAttribute('required');
    }
}