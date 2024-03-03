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

function alterarQuantidadeInserirCarrinho() {

    let valor_atualizado = document.getElementById('quantidade').value;
    document.getElementById('quantidade_carrinho').value = valor_atualizado;
}

function alterarQuantidadeProdutoCarrinho(id, app_host, produtoId) {

    setTimeout(() => {
        let quantidade = document.getElementById(id).value;
        let request = new XMLHttpRequest();

        request.open('POST', 'http://' + app_host + '/carrinho/alterarQuantidade/' + produtoId, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        request.send('quantidade=' + encodeURIComponent(quantidade));

        window.location.reload();
    }, 1500);
}