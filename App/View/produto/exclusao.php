<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['produto']) && !empty($dados['produto'])) { ?>
    <div class="row">
      <div class="col">
        <form method="POST" action="http://<?=APP_HOST?>/produto/excluir">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Exclusão de produto</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['produto']->getCodigo() ?>">
          <input type="hidden" name="imagem_atual" value="<?= $dados['produto']->getImagem() ?>">
          <div class="row mb-3">
            <div class="col-10 col-md-6 col-lg-4">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary" id="nome" name="nome"
              value="<?= $dados['produto']->getNome() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="preco" class="form-label">Preço</label>
              <input type="text" class="form-control border border-primary" id="preco" name="preco"
              value="<?= $dados['produto']->getPrecoView() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="estoque" class="form-label">Estoque</label>
              <input type="number" class="form-control border border-primary" id="estoque" name="estoque"
              value="<?= $dados['produto']->getEstoque() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-10 col-md-8 col-lg-5">
              <h4>Imagem atual:</h4>
              <img src="http://<?=APP_HOST?>/public/imagem/produto/<?=$dados['produto']->getImagem()?>" width="60%">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="departamento" class="form-label">Departamento</label>
              <input class="form-control border border-primary" id="departamento" name="departamento"
              value="<?= $dados['produto']->getDepartamento()->getNome(); ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <h3>Tem certeza que quer excluir esse produto ?</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash">&ensp;</i>Excluir
              </button>
            </div>
            <div class="col-auto">
              <a href="http://<?=APP_HOST?>/produto" class="btn btn-secondary">
                <i class="bi bi-x-lg">&ensp;</i>Cancelar
                  </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>