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
        <form method="POST" action="http://<?=APP_HOST?>/funcionario/excluir">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Exclusão de funcionário</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['funcionario']->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="cpf" class="form-label">CPF</label>
              <input type="text" class="form-control border border-primary" id="cpf" name="cpf"
              value="<?= $dados['funcionario']->getCpf() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary" id="nome" name="nome"
              value="<?= $dados['funcionario']->getNome() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="setor" class="form-label">Setor</label>
              <input type="text" class="form-control border border-primary" id="setor" name="setor"
              value="<?= $dados['funcionario']->getSetor() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="salario" class="form-label">Salário</label>
              <input type="text" class="form-control border border-primary" id="salario" name="salario"
              value="<?= $dados['funcionario']->getSalario() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <h3>Tem certeza que quer excluir esse funcionário ?</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash">&ensp;</i>Excluir
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