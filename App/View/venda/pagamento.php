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
        <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
          <i class="bi bi-arrow-left">&ensp;</i>Voltar
        </a>
      </div>
      <div class="col-auto">
        <h1>Finalizar compra</h1>
      </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <div class="row mb-3">
          <h2>Venda</h2>
      </div>
      <?php if (isset($dados['produto']) && !empty($dados['produto'])) { ?>
      <div class="row mb-3">
        <div class="col-auto">
            <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $dados['produto']->getImagem() ?>"
            class="" width="200px" height="200px">
        </div>
        <div class="col-auto">
            <?= $dados['produto']->getNome() ?>   
        </div>
        <div class="col-auto">
            <?= $dados['produto']->getPreco() ?>   
        </div>
        <div class="col-auto">
            <?= $dados['produto']->getQuantidade() ?>   
        </div>
        <div class="col-auto">
            <?= $dados['produto']->getSubtotal() ?>   
        </div>
      </div>
      <?php } if (isset($dados['endereco']) && !empty($dados['endereco'])) { ?>
        <div class="row mb-3">
            <div class="col-auto">
                <?= $dados['endereco']->getRua() ?>
            </div>
            <div class="col-auto">
                <?= $dados['endereco']->getNumero() ?>
            </div>
            <div class="col-auto">
                <?= $dados['endereco']->getBairro() ?>
            </div>
            <div class="col-auto">
                <?= $dados['endereco']->getCidade() ?>
            </div>
            <div class="col-auto">
                <?= $dados['endereco']->getEstado() ?>
            </div>
        </div>
      <?php } if (isset($dados['produto']) && !empty($dados['produto'])) { ?>
            <div class="row mb-3">
                <h2>Valor total: R$ <?= $dados['produto']->getSubtotal() ?></h2>
            </div>
        <?php } ?>
    </div>
    <div class="col-auto">
      <form method="POST" action="http://<?=APP_HOST?>/venda/realizarPagamento" enctype="multipart/form-data">
        <input type="hidden" id="produto" name="produto" value="<?= $dados['produto']->getCodigo() ?>">
        <input type="hidden" id="quantidade" name="quantidade" value="<?= $dados['produto']->getQuantidade() ?>">
        <input type="hidden" id="subtotal" name="subtotal" value="<?= $dados['produto']->getSubtotal() ?>">
        <input type="hidden" id="cliente" name="cliente" value="<?= $sessao::getCodigoConta() ?>">
        <input type="hidden" id="endereco" name="endereco" value="<?= $dados['endereco']->getCodigo() ?>">
        <div class="row mb-3">
          <div class="col-auto">
            <h5>Escolha a forma de pagamento</h1>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
              <label class="form-check-label" for="flexRadioDefault2">
                <img class="bg-light p-1" src="http://<?= APP_HOST ?>/public/imagem/pagamentos/pp-logo-200px.png">
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-credit-card">&ensp;</i>Realizar pagamento
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>