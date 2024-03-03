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
        <a href="http://<?=APP_HOST?>/<?= 'venda/iniciarVenda' . 
          (isset($dados['carrinho']) ? 'Carrinho'
          : 'Individual/' . $dados['produtos'][0]->getCodigo() . '/' . $dados['produtos'][0]->getQuantidade() )?>"
          class="btn btn-secondary">
          <i class="bi bi-arrow-left">&ensp;</i>Voltar
        </a>
      </div>
      <div class="col-auto">
        <h1>Finalizar compra</h1>
      </div>
  </div>
  <div class="row mb-3">
    <div class="col-6 col-md-auto border border-2 border-primary mb-3">
      <div class="row mb-3 ">
        <div class="col-auto">
          <h2>Itens</h2>
        </div>
        <div class="col-auto mx-auto me-0">
            <h2>Total: R$ <?= (isset($dados['carrinho'])) ?
              $dados['carrinho']->getTotalView() : $dados['produtos'][0]->getSubtotalView() ?></h2>
        </div>
      </div>
      <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) {
        foreach ($dados['produtos'] as $produto) { ?>
      <div class="row mb-3 bg-success-subtle rounded mx-auto p-2">
        <div class="col-auto">
            <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>"
            class="border border-black border-2" width="150px" height="150px">
            <h4 class="mt-1 text-center"><?= $produto->getNome() ?></h4>
        </div>
        <div class="col-auto mx-auto my-auto ms-3">
          <h4 class="text-center">Preço</h4>
          <h5 class="text-center">R$ <?= $produto->getPrecoView() ?></h5>
        </div>
        <div class="col-auto mx-auto my-auto ms-3">
          <h4 class="text-center">Quantidade</h4>
          <h5 class="text-center"><?= $produto->getQuantidade() ?></h5> 
        </div>
        <div class="col-auto mx-auto my-auto ms-3">
          <h4 class="text-center">Subtotal</h4>
          <h5 class="text-center">R$ <?= $produto->getSubtotalView() ?></h5>
        </div>
      </div>
      <?php } } if (isset($dados['endereco']) && !empty($dados['endereco'])) { ?>
        <h4 class="row">Endereço de entrega:</h4>
        <div class="row mb-3">
          <div class="col-auto px-1">
            <h5><?= $dados['endereco']->getRua() ?>,</h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['endereco']->getNumero() ?> -</h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['endereco']->getBairro() ?>,</h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['endereco']->getCidade() ?> -</h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['endereco']->getEstado() ?></h5>
          </div>
          <div class="col-auto px-1">
            <h5><?= $dados['endereco']->getCep() ?></h5>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="col-auto mx-auto">
      <form method="POST" action="http://<?=APP_HOST?>/venda/realizarPagamento" enctype="multipart/form-data">
        <?php if(isset($_POST['produto'])) { ?>
          <input type="hidden" id="produto" name="produto" value="<?= $dados['produtos'][0]->getCodigo() ?>">
          <input type="hidden" id="quantidade" name="quantidade" value="<?= $dados['produtos'][0]->getQuantidade() ?>">
        <?php } ?>
        <input type="hidden" id="total" name="total"
        value="<?= (isset($dados['carrinho'])) ? $dados['carrinho']->getTotal() : $dados['produtos'][0]->getSubtotal() ?>">
        <input type="hidden" id="endereco" name="endereco" value="<?= $dados['endereco']->getCodigo() ?>">
        <div class="row mb-3">
          <div class="col-auto">
            <h5>Escolha a forma de pagamento</h5>
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