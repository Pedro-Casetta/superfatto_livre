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
      <h1>Produtos da compra</h1>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-auto">
      <h4 class="alert alert-info">Data da compra: <?=$dados['venda']->getData() ?></h4>
    </div>
    <div class="col-auto">
      <h4 class="alert alert-info">Total: R$ <?=$dados['venda']->getTotalView() ?></h4>
    </div>
    <div class="col-auto">
      <h4 class="alert alert-info">Situação: <?=$dados['venda']->getSituacao() ?></h4>
    </div>
  </div>
  <div class="row mb-3 mx-auto alert alert-info">
    <div class="col-auto px-1">
      <h4>Endereço:  <?=$dados['venda']->getEndereco()->getRua() ?>,</h4>
    </div>
    <div class="col-auto px-1">
      <h4><?=$dados['venda']->getEndereco()->getNumero() ?> -</h4>
    </div>
    <div class="col-auto px-1">
      <h4><?=$dados['venda']->getEndereco()->getBairro() ?>,</h4>
    </div>
    <div class="col-auto px-1">
      <h4><?=$dados['venda']->getEndereco()->getCidade() ?> -</h4>
    </div>
    <div class="col-auto px-1">
      <h4><?=$dados['venda']->getEndereco()->getEstado() ?> -</h4>
    </div>
    <div class="col-auto px-1">
      <h4><?=$dados['venda']->getEndereco()->getCep() ?></h4>
    </div>
  </div>
  <div class="row mb-3">
  <div class="col-auto">
      <a href="http://<?=APP_HOST?>/venda/indexCompras" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/venda/realizarPagamentoPendente/<?= $dados['venda']->getCodigo() ?>"
      class="btn btn-success <?= ($dados['venda']->getSituacao() == "Aguardando pagamento") ? '' : 'disabled' ?>">
        <i class="bi bi-credit-card">&ensp;</i>Realizar pagamento pendente
      </a>
    </div>
  </div>

  <?php if (isset($dados['produtos_venda']) && !empty($dados['produtos_venda'])) {
  foreach($dados['produtos_venda'] as $produto) { ?>
    <div class="row mb-3 bg-success-subtle rounded mx-auto p-2">
      <div class="col-auto">
        <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>" width="150px" height="150px"
        class="border border-black border-2">
        <h4 class="mt-1 text-center"><?= $produto->getNome() ?></h4>
      </div>
      <div class="col-auto my-auto ms-5">
        <h4 class="text-center">Preço</h4>
        <h4>R$ <?= $produto->getPrecoView() ?></h4>
      </div>
      <div class="col-auto my-auto ms-5">
        <h4 class="text-center">Quantidade</h4>
        <h4 class="text-center"><?= $produto->getQuantidade() ?></h4>
      </div>
      <div class="col-auto my-auto ms-5">
        <h4 class="text-center">Subtotal</h4>
        <h4>R$ <?= $produto->getSubtotalView() ?></h4>
      </div>
    </div>
  <?php } } ?>
</div>