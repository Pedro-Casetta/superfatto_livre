<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['produto_lote']) && !empty($dados['produto_lote'])) { ?>
    <div class="row">
      <div class="col">
        <form method="POST" action="http://<?=APP_HOST?>/produtoLote/excluir">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Exclusão de produto do lote</h1>
            </div>
          </div>
          <input type="hidden" id="produto" name="produto" value="<?= $dados['produto_lote']->getCodigo() ?>">
          <input type="hidden" id="lote" name="lote" value="<?= $dados['produto_lote']->getLote()->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-10 col-md-6 col-lg-4">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary" id="nome" name="nome"
              value="<?= $dados['produto_lote']->getNome() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-10 col-md-8 col-lg-5">
              <h4>Imagem:</h4>
              <img src="http://<?=APP_HOST?>/public/imagem/produto/<?=$dados['produto_lote']->getImagem()?>" width="60%">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="preco" class="form-label">Preço</label>
              <input type="text" class="form-control border border-primary" id="preco" name="preco"
              value="<?= $dados['produto_lote']->getPreco() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="quantidade" class="form-label">Quantidade</label>
              <input type="number" class="form-control border border-primary" id="quantidade" name="quantidade"
              value="<?= $dados['produto_lote']->getQuantidade() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="subtotal" class="form-label">Subtotal</label>
              <input type="text" class="form-control border border-primary" id="subtotal" name="subtotal"
              value="<?= $dados['produto_lote']->getSubtotal() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <h3>Tem certeza que quer excluir esse produto do lote ?</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash">&ensp;</i>Excluir
              </button>
            </div>
            <div class="col-auto">
              <a href="http://<?=APP_HOST?>/produtoLote/index/<?= $dados['produto_lote']->getLote()->getCodigo() ?>" class="btn btn-secondary">
                <i class="bi bi-x-lg">&ensp;</i>Cancelar
                  </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>