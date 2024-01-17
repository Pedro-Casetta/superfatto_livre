<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['funcionario']) && !empty($dados['funcionario'])) { ?>
    <div class="row">
      <div class="col">
        <form method="POST" action="http://<?=APP_HOST?>/funcionario/atualizar">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Edição de funcionário</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['funcionario']->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="cpf" class="form-label">CPF</label>
              <input type="text" class="form-control border border-primary" id="cpf" name="cpf"
              value="<?= $dados['funcionario']->getCpf() ?>" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary" id="nome" name="nome"
              value="<?= $dados['funcionario']->getNome() ?>" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="setor" class="form-label">Setor</label>
              <input type="text" class="form-control border border-primary" id="setor" name="setor"
              value="<?= $dados['funcionario']->getSetor() ?>" required>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="salario" class="form-label">Salário</label>
              <input type="text" class="form-control border border-primary" id="salario" name="salario"
              value="<?= $dados['funcionario']->getSalario() ?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg">&ensp;</i>Atualizar
              </button>
            </div>
            <div class="col-auto">
              <a href="http://<?=APP_HOST?>/funcionario" class="btn btn-secondary">
                <i class="bi bi-x-lg">&ensp;</i>Cancelar
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>