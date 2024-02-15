<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['produto']) && !empty($dados['produto'])) { ?>
    <div class="row mb-3">
        <div class="col-auto">
          <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
            <i class="bi bi-arrow-left">&ensp;</i>Voltar
          </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $dados['produto']->getImagem() ?>"
            class="" width="400px" height="400px">
        </div>
        <div class="col">
          <div class="row mb-3">
              <h2><?= $dados['produto']->getNome() ?></h2>
          </div>
          <div class="row mb-3">
              <h2>R$ <?= $dados['produto']->getPrecoView() ?></h2>
          </div>
          <form method="POST" action="http://<?=APP_HOST?>/venda/iniciarVendaIndividual" enctype="multipart/form-data">
            <input type="hidden" name="produto" value="<?= $dados['produto']->getCodigo() ?>">
            <div class="row mb-3">
              <div class="col-6 col-md-4 col-lg-3">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="number" min="1" max="<?= $dados['produto']->getEstoque() ?>" oninput="alterarQuantidadeInserirCarrinho()"
                class="form-control border border-primary" id="quantidade" name="quantidade" value="1" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-auto">
                <button type="submit" class="btn btn-warning">
                  <i class="bi bi-currency-dollar">&ensp;</i>Comprar
                </button>
              </div>
            </div>
          </form>
          <form method="POST" action="http://<?=APP_HOST?>/carrinho/inserirNoCarrinho" enctype="multipart/form-data">
            <input type="hidden" name="produto_carrinho" value="<?= $dados['produto']->getCodigo() ?>">
            <input type="hidden" name="carrinho" value="<?= $sessao::getCodigoConta() ?>">
            <input type="hidden" id="quantidade_carrinho" name="quantidade_carrinho" value="1">
            <div class="row mb-3">
              <div class="col-auto">
                <button type="submit" class="btn btn-success">
                  <i class="bi bi-cart">&ensp;</i>Inserir no carrinho
                </button>
              </div>
            </div>
          </form>
        </div>
    </div>
  <?php } ?>

</div>