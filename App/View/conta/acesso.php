<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <div class="row">
    <div class="col">
      <form method="POST" action="http://<?=APP_HOST?>/conta/acessar">
        <div class="row mb-3">
          <div class="col-auto">
            <h1>Acessar conta</h1>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
              <i class="bi bi-arrow-left">&ensp;</i>Voltar
            </a>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="nome_usuario" class="form-label">Nome de usuário</label>
              <input type="text" class="form-control border border-black" id="nome_usuario" name="nome_usuario" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="senha" class="form-label">Senha</label>
              <input type="password" class="form-control border border-black" id="senha" name="senha" required>
            </div>
        </div>
        <div class="row">
          <div class="col-auto">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-box-arrow-in-right">&ensp;</i>Acessar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>