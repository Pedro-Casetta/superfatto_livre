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
        <form method="POST" action="http://<?=APP_HOST?>/fornecedor/excluir">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Exclusão de fornecedor</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['fornecedor']->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="cnpj" class="form-label">CNPJ</label>
              <input type="text" class="form-control border border-primary" id="cnpj" name="cnpj"
              value="<?= $dados['fornecedor']->getCnpj() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary" id="nome" name="nome"
              value="<?= $dados['fornecedor']->getNome() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="departamento" class="form-label">Departamento</label>
              <input class="form-control" id="departamento" name="departamento"
              value="<?= $dados['fornecedor']->getDepartamento()->getNome(); ?>" readonly>
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