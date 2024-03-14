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
        <form method="POST" action="http://<?=APP_HOST?>/produtoLote/atualizar">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Edição de produto do lote <?= $dados['produto_lote']->getLote()->getCodigo() ?></h1>
            </div>
          </div>
          <input type="hidden" name="velho_cod_produto" value="<?= $dados['produto_lote']->getCodigo() ?>">
          <input type="hidden" name="lote" value="<?= $dados['produto_lote']->getLote()->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-auto">
              <label for="produto" class="form-label">Produto</label>
              <select class="form-select border border-primary" id="produto" name="produto" required>
                <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) { ?>
                  <?php foreach($dados['produtos'] as $produto) {
                    if ($produto->getDepartamento()->getCodigo() == $dados['lote']->getFornecedor()->getDepartamento()->getCodigo()) { ?>
                      <option value="<?= $produto->getCodigo() ?>"
                        <?= ($produto->getCodigo() == $dados['produto_lote']->getCodigo()) ? 'selected' : '' ?>>
                        <?= $produto->getNome() ?>
                      </option>
                <?php } } } ?>
              </select>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-auto">
              <label for="quantidade" class="form-label">Quantidade</label>
              <input type="number" min="1" class="form-control border border-primary" id="quantidade" name="quantidade"
              value="<?= $dados['produto_lote']->getQuantidade() ?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg">&ensp;</i>Atualizar
              </button>
            </div>
            <div class="col-auto">
              <a href="http://<?=APP_HOST?>/produtoLote/index/<?= $dados['lote']->getCodigo() ?>" class="btn btn-secondary">
                <i class="bi bi-x-lg">&ensp;</i>Cancelar
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>