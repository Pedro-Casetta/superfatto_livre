<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['fornecedor']) && !empty($dados['fornecedor'])) { ?>
    <div class="row">
      <div class="col">
        <form method="POST" action="http://<?=APP_HOST?>/fornecedor/atualizar">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Edição de fornecedor</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['fornecedor']->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="cnpj" class="form-label">CNPJ</label>
              <input type="text" class="form-control border border-primary" id="cnpj" name="cnpj"
              value="<?= $dados['fornecedor']->getCnpj() ?>" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary" id="nome" name="nome"
              value="<?= $dados['fornecedor']->getNome() ?>" required>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-auto">
              <label for="departamento" class="form-label">Departamento</label>
              <select class="form-select border border-primary" id="departamento" name="departamento" required>
                <?php if (isset($dados['departamentos']) && !empty($dados['departamentos'])) { ?>
                  <?php foreach($dados['departamentos'] as $departamento) { ?>
                    <option value="<?= $departamento->getCodigo() ?>" 
                    <?= ($departamento->getCodigo() == $dados['fornecedor']->getDepartamento()->getCodigo()) ? 'selected' : '' ?>>
                      <?= $departamento->getNome() ?>
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
              <a href="http://<?=APP_HOST?>/fornecedor" class="btn btn-secondary">
                <i class="bi bi-x-lg">&ensp;</i>Cancelar
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>