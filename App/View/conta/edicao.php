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
        <form method="POST" action="http://<?=APP_HOST?>/conta/atualizar">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Edição de conta</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['conta']->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary" id="nome" name="nome"
              value="<?= $dados['conta']->getNome() ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="email" class="form-label">E-mail</label>
              <input type="text" class="form-control border border-primary" id="email" name="email"
              value="<?= $dados['conta']->getEmail() ?>" required>
            </div>
        </div>
        <div class="row mb-3">
          <div class="col-6 col-md-4 col-lg-3">
            <label for="nome_usuario" class="form-label">Nome de usuário</label>
            <input type="text" class="form-control border border-primary" id="nome_usuario" name="nome_usuario"
            value="<?= $dados['conta']->getNomeUsuario() ?>" required>
          </div>
        </div>
        <div class="row mb-4">
            <?php if ($dados['conta']->getTipo() == 'administrador') {?>
                <div class="col-6 col-md-4 col-lg-3">
                    <label for="credencial" class="form-label">Credencial</label>
                    <input type="text" class="form-control border border-primary" id="credencial" name="credencial"
                    value="<?= $dados['conta']->getCredencial() ?>" required>
                </div>
            <?php } else if ($dados['conta']->getTipo() == 'cliente') {?>
                <div class="col-6 col-md-4 col-lg-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control border border-primary" id="telefone" name="telefone"
                    value="<?= $dados['conta']->getTelefone() ?>" required>
                </div>
            <?php } ?>
        </div>
        <div class="row">
          <div class="col-auto">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-lg">&ensp;</i>Atualizar
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