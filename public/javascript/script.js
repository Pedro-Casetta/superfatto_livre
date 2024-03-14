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
        document.getElementById('telefone').value = "";

    } else if ($tipo == "cliente") {
        document.getElementById('campoCredencial').style.display = "none";
        document.getElementById('credencial').removeAttribute('required');
        document.getElementById('credencial').value = "";
        document.getElementById('campoTelefone').style.display = "inline";
        document.getElementById('telefone').setAttribute('required', '');
    } else {
        document.getElementById('campoTelefone').style.display = "none";
        document.getElementById('campoCredencial').style.display = "none";
        document.getElementById('credencial').removeAttribute('required');
        document.getElementById('credencial').value = "";
        document.getElementById('telefone').removeAttribute('required');
        document.getElementById('telefone').value = "";
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

window.addEventListener("DOMContentLoaded", () => {
    let botoes_editar = document.getElementsByClassName("editar");
    let botoes_excluir = document.getElementsByClassName("excluir");

    for (let i = 0; i < botoes_editar.length; i++) {
        let botao_editar = botoes_editar[i].getBoundingClientRect();
        let botao_excluir = botoes_excluir[i].getBoundingClientRect();

        if (botao_editar.bottom <= botao_excluir.top)
        {
            botoes_editar[i].style.marginBottom = "10px";
        }
        else
        {
            botoes_editar[i].style.marginBottom = "";
        }
    }
});

window.addEventListener("resize", () => {
    var botoes_editar = document.getElementsByClassName("editar");
    var botoes_excluir = document.getElementsByClassName("excluir");

    for (let i = 0; i < botoes_editar.length; i++) {
        var botao_editar = botoes_editar[i].getBoundingClientRect();
        var botao_excluir = botoes_excluir[i].getBoundingClientRect();

        if (botao_editar.bottom <= botao_excluir.top)
        {
            botoes_editar[i].style.marginBottom = "10px";
        }
        else
        {
            botoes_editar[i].style.marginBottom = "";
        }
    }
});