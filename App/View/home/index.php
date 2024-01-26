<div class="container-sm my-5">

  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>

  <div class="row mb-4">
    <div class="col-auto mx-auto">
      <h1>Catálogo</h1>
    </div>
  </div>

    <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) { ?>
        <div class="row">
            <?php foreach($dados['produtos'] as $produto) { ?>
              <div class="col-6 col-md-3 mb-3">
                  <a class="card text-center btn btn-danger"
                  href="http://<?= APP_HOST ?>/produto/detalhesProduto/<?= $produto->getCodigo() ?>">
                      <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>"
                      class="card-img-top" width="200px" height="200px">
                      <div class="card-body">
                          <h5 class="card-title"><?= $produto->getNome() ?></h5>
                          <p class="card-text">R$ <?= $produto->getPreco() ?></p>
                      </div>
                  </a>
              </div>
            <?php } ?>
        </div>
        <?= $dados['paginacao'] ?>


  <?php } else if (isset($dados['produtos']) && empty($dados['produtos'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não há produtos.</h2>
      </div>
    </div>
  <?php } ?>

</div>