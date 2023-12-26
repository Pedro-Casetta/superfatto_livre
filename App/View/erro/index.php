<?php if(isset($dados['erro'])) { ?>
  <div class="row" id="erro">
    <div class="col alert alert-danger">
      <button onclick="fecharMensagem('erro')" type="button" class="btn-close" aria-label="Close"></button>
      <h2><?= $dados['erro'] ?></h2>
    </div>
  </div>
<?php } ?>