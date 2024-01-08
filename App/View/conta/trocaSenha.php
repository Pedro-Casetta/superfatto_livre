<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['conta']) && !empty($dados['conta'])) { ?>
    <div class="row">
      <div class="col">
        <form method="POST" action="http://<?=APP_HOST?>/conta/trocarSenha">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Troca de senha</h1>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="senha" class="form-label">Nova senha</label>
              <input type="password" class="form-control border border-primary" id="senha" name="senha" required>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="confirma_senha" class="form-label">Confirmar nova senha</label>
              <input type="password" class="form-control border border-primary" id="confirma_senha" name="confirma_senha" required>
            </div>
        </div>
        <div class="row">
          <div class="col-auto">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-lg">&ensp;</i>Trocar
            </button>
          </div>
          <div class="col-auto">
            <a href="http://<?=APP_HOST?>/conta/encaminharPerfil" class="btn btn-secondary">
              <i class="bi bi-x-lg">&ensp;</i>Cancelar
            </a>
          </div>
        </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>