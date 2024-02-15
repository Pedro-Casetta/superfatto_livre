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
    <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) { ?>
      <div class="col-auto">
        <div class="row mb-3">
          <div class="col-auto">
            <h2>Itens comprados</h2>
          </div>
        </div>
        <?php foreach ($dados['produtos'] as $produto) { ?>
          <div class="row mb-3">
            <div class="col-auto">
                <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>"
                class="" width="200px" height="200px">
            </div>
            <div class="col-auto">
                <?= $produto->getNome() ?>   
            </div>
            <div class="col-auto">
                R$ <?= $produto->getPrecoView() ?>   
            </div>
            <div class="col-auto">
                <?= $produto->getQuantidade() ?>   
            </div>
            <div class="col-auto">
                R$ <?= $produto->getSubtotal() ?>   
            </div>
          </div>
        <?php } } if (isset($dados['venda']) && !empty($dados['venda'])) { ?>
          <div class="row mb-3">
            <div class="col-auto">
                <?= $dados['venda']->getEndereco()->getRua() ?>
            </div>
            <div class="col-auto">
                <?= $dados['venda']->getEndereco()->getNumero() ?>
            </div>
            <div class="col-auto">
                <?= $dados['venda']->getEndereco()->getBairro() ?>
            </div>
            <div class="col-auto">
                <?= $dados['venda']->getEndereco()->getCidade() ?>
            </div>
            <div class="col-auto">
                <?= $dados['venda']->getEndereco()->getEstado() ?>
            </div>
            <div class="col-auto">
                <?= $dados['venda']->getEndereco()->getCep() ?>
            </div>
          </div>
      </div>
      <div class="col-auto">
        <div class="row mb-3">
          <div class="col-auto">
            <h3>Obrigado pela compra!</h3>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <h3>Data da compra: <?= $dados['venda']->getData() ?></h3>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <h3>Total: R$ <?= $dados['venda']->getTotal() ?></h3>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <h3>Situação: <?= $dados['venda']->getSituacao() ?></h3>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>