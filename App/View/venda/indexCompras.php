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
      <h1>Histórico de compras</h1>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
    <div class="col-auto mx-auto me-0">
      <form class="d-flex" method="GET" action="http://<?=APP_HOST?>/venda/indexCompras">
        <input class="form-control me-2" type="date" size="25" id="data" name="data">
        <input class="form-control me-2" type="search" size="25" id="busca" name="busca" placeholder="situação, endereço...">
        <button class="btn btn-primary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>
  </div>

  <?php if (isset($dados['vendas']) && !empty($dados['vendas'])) {
  foreach($dados['vendas'] as $venda) { ?>
    <div class="row mx-auto mb-3 bg-success-subtle rounded p-2">
      <div class="row">
        <div class="col-auto me-2">
          <b>Data:</b> <?= $venda->getDataView() ?>
        </div>
        <div class="col-auto me-2">
          <b>Total:</b> R$ <?= $venda->getTotalView() ?>
        </div>
        <div class="col-auto">
          <b>Situação:</b> <?= $venda->getSituacao() ?>
        </div>
        <div class="col-auto">
          <a href="http://<?=APP_HOST?>/venda/indexProdutosCompra/<?= $venda->getCodigo() ?>" class="btn btn-warning">
            <i class="bi bi-eye">&nbsp;</i>Visualizar itens
          </a>
        </div>
      </div>
      <h5 class="row">Endereço de entrega:</h5>
      <div class="row ms-3">
        <div class="col-auto">
          <?= $venda->getEndereco()->getRua() ?>
        </div>
        <div class="col-auto">
          <?= $venda->getEndereco()->getNumero() ?>
        </div>
        <div class="col-auto">
          <?= $venda->getEndereco()->getBairro() ?>
        </div>
        <div class="col-auto">
          <?= $venda->getEndereco()->getCidade() ?>
        </div>
        <div class="col-auto">
          <?= $venda->getEndereco()->getEstado() ?>
        </div>    
        <div class="col-auto">
          <?= $venda->getEndereco()->getCep() ?>
        </div>
      </div>
    </div>
  <?php } } else if (isset($dados['vendas']) && empty($dados['vendas'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não foi feita nenhuma compra até o momento.</h2>
      </div>
    </div>
  <?php } ?>
  <?= $dados['paginacao'] ?>

</div>