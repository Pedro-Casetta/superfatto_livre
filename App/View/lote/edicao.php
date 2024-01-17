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
        <form method="POST" action="http://<?=APP_HOST?>/lote/atualizar">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Edição de lote</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['lote']->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="data" class="form-label">Data</label>
              <input type="date" class="form-control border border-primary" id="data" name="data"
              value="<?= $dados['lote']->getData() ?>" required>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-auto">
              <label for="fornecedor" class="form-label">Fornecedor</label>
              <select class="form-select border border-primary" id="fornecedor" name="fornecedor" required>
                <?php if (isset($dados['fornecedores']) && !empty($dados['fornecedores'])) { ?>
                  <?php foreach($dados['fornecedores'] as $fornecedor) { ?>
                    <option value="<?= $fornecedor->getCodigo() ?>"
                    <?= ($fornecedor->getCodigo() == $dados['lote']->getFornecedor()->getCodigo()) ? 'selected' : '' ?>>
                      <?= $fornecedor->getNome() ?>
                    </option>
                <?php } } ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg">&ensp;</i>Atualizar
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