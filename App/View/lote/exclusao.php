<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['lote']) && !empty($dados['lote'])) { ?>
    <div class="row">
      <div class="col">
        <form method="POST" action="http://<?=APP_HOST?>/lote/excluir">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Exclusão de lote</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['lote']->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="data" class="form-label">Data</label>
              <input type="text" class="form-control border border-primary" id="data" name="data"
              value="<?= $dados['lote']->getData() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="fornecedor" class="form-label">Fornecedor</label>
              <input type="text" class="form-control border border-primary" id="fornecedor" name="fornecedor"
              value="<?= $dados['lote']->getFornecedor()->getNome() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="total" class="form-label">Total</label>
              <input type="text" class="form-control border border-primary" id="total" name="total"
              value="<?= $dados['lote']->getTotal() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <h3>Tem certeza que quer excluir esse lote ?</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash">&ensp;</i>Excluir
              </button>
            </div>
            <div class="col-auto">
              <a href="http://<?=APP_HOST?>/lote" class="btn btn-secondary">
                <i class="bi bi-x-lg">&ensp;</i>Cancelar
                  </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>