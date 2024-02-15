<div class="container-sm my-5">

  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>

  <div class="row mb-3">
    <div class="col-auto">
      <h1>Carrinho</h1>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/venda/iniciarVendaCarrinho"
      class="btn btn-success <?= (isset($dados['produtos_carrinho']) && empty($dados['produtos_carrinho'])) ? 'disabled' : '' ?>">
        <i class="bi bi-currency-dollar">&ensp;</i>Comprar do carrinho
      </a>
    </div>
    <div class="col-auto mx-auto me-5">
      <h2>Total: R$ <?= $dados['carrinho']->getTotal() ?></h2>
    </div>
  </div>

  <?php if (isset($dados['produtos_carrinho']) && !empty($dados['produtos_carrinho'])) {
    foreach($dados['produtos_carrinho'] as $produto) { ?>
      <div class="row mb-3">
        <div class="row">
          <div class="col-auto">
            <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>"
            class="" width="200px" height="200px">
          </div>
          <div class="col-auto">
              <?= $produto->getNome() ?>
          </div>
          <div class="col-auto">
              <?= $produto->getPrecoView() ?>
          </div>
          <div class="col-auto">
              <a href="http://<?=APP_HOST?>/carrinho/diminuirQuantidade/<?= $produto->getCodigo() ?>"
              class="btn btn-danger <?= ($produto->getQuantidade() <= 1) ? 'disabled' : '' ?>">
                  <i class="bi bi-dash"></i>
              </a>
          </div>
          <div class="col-auto">
              <input type="number" id="quantidade<?= $produto->getCodigo() ?>" value="<?= $produto->getQuantidade() ?>"
              class="form-control border border-primary"
              oninput="alterarQuantidadeProdutoCarrinho(
                'quantidade<?= $produto->getCodigo() ?>',
                '<?= APP_HOST ?>',
                '<?= $produto->getCodigo() ?>')" min="1" max="<?= $produto->getEstoque() ?>">
          </div>
          <div class="col-auto">
              <a href="http://<?=APP_HOST?>/carrinho/aumentarQuantidade/<?= $produto->getCodigo() ?>"
              class="btn btn-success <?= ($produto->getEstoque() <= 0) ? 'disabled' : '' ?>">
                  <i class="bi bi-plus"></i>
              </a>
          </div>    
          <div class="col-auto">
              <?= $produto->getSubtotal() ?>
          </div>
        </div>
        <div class="row">
          <div class="col-auto">
            <a href="http://<?=APP_HOST?>/carrinho/removerProduto/<?= $produto->getCodigo() ?>" class="btn btn-danger">
              <i class="bi bi-trash">&nbsp;</i>Remover
            </a>
          </div>
        </div>
      </div>
  <?php } } else if (isset($dados['produtos_carrinho']) && empty($dados['produtos_carrinho'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Nenhum produto no carrinho.</h2>
      </div>
    </div>
  <?php } ?>

</div>