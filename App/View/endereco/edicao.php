<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['endereco']) && !empty($dados['endereco'])) { ?>
    <div class="row">
      <div class="col">
        <form method="POST" action="http://<?=APP_HOST?>/endereco/atualizar">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Edição de endereco</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['endereco']->getCodigo() ?>">
          <input type="hidden" name="cliente" value="<?= $dados['endereco']->getCliente()->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="rua" class="form-label">Rua</label>
              <input type="text" class="form-control border border-primary" id="rua" name="rua"
              value="<?= $dados['endereco']->getRua() ?>" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="numero" class="form-label">Número</label>
              <input type="number" class="form-control border border-primary" id="numero" name="numero"
              value="<?= $dados['endereco']->getNumero() ?>" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="bairro" class="form-label">Bairro</label>
              <input type="text" class="form-control border border-primary" id="bairro" name="bairro"
              value="<?= $dados['endereco']->getBairro() ?>" required>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="cidade" class="form-label">Cidade</label>
              <input type="text" class="form-control border border-primary" id="cidade" name="cidade"
              value="<?= $dados['endereco']->getCidade() ?>" required>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="estado" class="form-label">Estado</label>
              <input type="text" class="form-control border border-primary" id="estado" name="estado"
              value="<?= $dados['endereco']->getEstado() ?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg">&ensp;</i>Atualizar
              </button>
            </div>
            <div class="col-auto">
              <a href="http://<?=APP_HOST?>/endereco" class="btn btn-secondary">
                <i class="bi bi-x-lg">&ensp;</i>Cancelar
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>