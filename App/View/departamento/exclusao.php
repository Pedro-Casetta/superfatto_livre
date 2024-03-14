<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['departamento']) && !empty($dados['departamento'])) { ?>
    <div class="row">
      <div class="col">
        <form method="POST" action="http://<?=APP_HOST?>/departamento/excluir">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Exclusão de departamento</h1>
            </div>
          </div>
          <input type="hidden" id="codigo" name="codigo" value="<?= $dados['departamento']->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-auto">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary" id="nome" name="nome"
              value="<?= $dados['departamento']->getNome() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <h3>Tem certeza que quer excluir esse departamento ?</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash">&ensp;</i>Excluir
              </button>
            </div>
            <div class="col-auto">
              <a href="http://<?=APP_HOST?>/departamento" class="btn btn-secondary">
                <i class="bi bi-x-lg">&ensp;</i>Cancelar
                  </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>