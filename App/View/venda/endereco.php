<div class="container-sm my-5">

  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>

  <div class="row mb-3">
      <div class="col-auto">
        <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
          <i class="bi bi-arrow-left">&ensp;</i>Voltar
        </a>
      </div>
      <div class="col-auto">
        <h1>Finalizar compra</h1>
      </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <div class="row mb-3">
          <h2>Venda</h2>
      </div>
      <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) { ?>
      <?php foreach($dados['produtos'] as $produto) { ?>
      <div class="row mb-3">
        <div class="col-auto">
            <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>"
            class="" width="400px" height="400px">
        </div>
        <div class="col-auto">
            <?= $produto->getNome() ?>   
        </div>
        <div class="col-auto">
            <?= $produto->getPreco() ?>   
        </div>
        <div class="col-auto">
            <?= $produto->getQuantidade() ?>   
        </div>
        <div class="col-auto">
            <?= $produto->getSubtotal() ?>   
        </div>
      </div>
      <?php } } if (isset($dados['venda']) && !empty($dados['venda'])) ?>
      <div class="row mb-3">
          <h2>Valor total: R$ <?= $dados['venda']->getTotal() ?></h2>
      </div>
    </div>
    <div class="col-auto">
      <form method="POST" action="http://<?=APP_HOST?>/venda/salvarEndereco" enctype="multipart/form-data">
        <input type="hidden" name="venda" value="<?= $dados['venda']->getCodigo() ?>">
        <div class="row mb-3">
          <div class="col-auto">
            <h5>Cadastre o endereço</h1>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-11 col-md-9 col-lg-6">
            <label for="rua" class="form-label">Rua</label>
            <input type="text" class="form-control border border-primary" id="rua" name="rua" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6 col-md-4 col-lg-3">
            <label for="numero" class="form-label">Número</label>
            <input type="number" class="form-control border border-primary" id="numero" name="numero" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6 col-md-4 col-lg-3">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control border border-primary" id="bairro" name="bairro" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6 col-md-4 col-lg-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control border border-primary" id="cidade" name="cidade" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6 col-md-4 col-lg-3">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control border border-primary" id="estado" name="estado" required>
          </div>
        </div>
        <div class="row">
          <div class="col-auto">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-floppy">&ensp;</i>Salvar endereço
            </button>
          </div>
          <div class="col-auto">
            <button type="reset" class="btn btn-warning">
              <i class="bi bi-eraser">&ensp;</i>Limpar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>