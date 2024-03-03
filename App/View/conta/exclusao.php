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
        <form method="POST" action="http://<?=APP_HOST?>/conta/excluir">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Exclusão de conta</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['conta']->getCodigo() ?>">
          <div class="row mb-3">
            <div class="col-auto">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary" id="nome" name="nome"
              value="<?= $dados['conta']->getNome() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="email" class="form-label">E-mail</label>
              <input type="text" class="form-control border border-primary" id="email" name="email"
              value="<?= $dados['conta']->getEmail() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <label for="nome_usuario" class="form-label">Nome de usuário</label>
              <input type="text" class="form-control border border-primary" id="nome_usuario" name="nome_usuario"
              value="<?= $dados['conta']->getNomeUsuario() ?>" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <?php if ($dados['conta']->getTipo() == 'administrador') {?>
                <div class="col-auto">
                    <label for="credencial" class="form-label">Credencial</label>
                    <input type="text" class="form-control border border-primary" id="credencial" name="credencial"
                    value="<?= $dados['conta']->getCredencial()->getNome() ?>" readonly>
                </div>
            <?php } else if ($dados['conta']->getTipo() == 'cliente') {?>
                <div class="col-auto">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control border border-primary" id="nome_usuario" name="nome_usuario"
                    value="<?= $dados['conta']->getTelefone() ?>" readonly>
                </div>
            <?php } ?>
          </div>
          <div class="row mb-3">
            <div class="col-auto">
              <h3>Tem certeza que quer excluir essa conta ?</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash">&ensp;</i>Excluir
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