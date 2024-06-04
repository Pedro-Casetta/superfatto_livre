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
    <div class="col-12 col-lg-6">
      <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) { ?>
        <div class="row mb-3">
          <div class="col-auto">
            <h2>Itens comprados</h2>
          </div>
        </div>
      <?php foreach ($dados['produtos'] as $produto) { ?>
        <div class="row mb-3 bg-success-subtle rounded mx-auto p-2">
          <div class="col-auto">
              <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>"
              class="border border-black border-2" width="150px" height="150px">
              <h4 class="mt-1 text-center"><?= $produto->getNome() ?></h4>
          </div>
          <div class="col-auto my-auto ms-3">
            <h4 class="text-center">Preço</h4>
            <h5 class="text-center">R$ <?= $produto->getPrecoView() ?></h5>
          </div>
          <div class="col-auto my-auto ms-3">
            <h4 class="text-center">Quantidade</h4>
            <h5 class="text-center"><?= $produto->getQuantidade() ?></h5> 
          </div>
          <div class="col-auto my-auto ms-3">
            <h4 class="text-center">Subtotal</h4>
            <h5 class="text-center">R$ <?= $produto->getSubtotalView() ?></h5>
          </div>
        </div>
      <?php } } ?>
    </div>
    <div class="col-12 col-lg-6">
      <?php if (isset($dados['venda']) && !empty($dados['venda'])) { ?>
        <div class="row mb-1">
          <div class="col-auto alert alert-success">
            <i class="bi bi-check-circle h1"></i>
            <h1 class="d-inline">Obrigado pela compra!</h1>
          </div>
        </div>
        <div class="row mb-1">
          <div class="col-auto alert alert-info p-2">
            <h3>Data da compra: <?= $dados['venda']->getDataView() ?></h3>
          </div>
        </div>
        <div class="row mb-1">
          <div class="col-auto alert alert-info p-2">
            <h3>Total: R$ <?= $dados['venda']->getTotalView() ?></h3>
          </div>
        </div>
        <div class="row mb-1">
          <div class="col-auto alert alert-info p-2">
            <h3>Situação: <?= $dados['venda']->getSituacao() ?></h3>
          </div>
        </div>
        <h4 class="row">Endereço de entrega:</h4>
        <div class="row mb-1 alert alert-info">
          <div class="col-auto px-1">
            <h5><?= $dados['venda']->getEndereco()->getRua() ?>,</h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['venda']->getEndereco()->getNumero() ?> -</h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['venda']->getEndereco()->getBairro() ?>,</h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['venda']->getEndereco()->getCidade() ?> -</h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['venda']->getEndereco()->getEstado() ?></h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['venda']->getEndereco()->getCep() ?></h5>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>