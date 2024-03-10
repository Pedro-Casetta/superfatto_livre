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
              <input type="text" class="form-control border border-primary
              <?= (isset($dados['validacao']) && !$dados['validacao']['nome_validado'] ? 'is-invalid' : '') ?>"
              id="nome" name="nome"
              value="<?= (isset($dados['formulario'])) ? $dados['formulario']['nome'] : $dados['conta']->getNome() ?>" required>
              <?php if (isset($dados['validacao']) && !$dados['validacao']['nome_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O nome deve conter apenas letras, espaços ou apóstrofos.
              </div>
            <?php } ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="email" class="form-label">E-mail</label>
              <input type="text" class="form-control border border-primary
              <?= (isset($dados['validacao']) && !$dados['validacao']['email_validado'] ? 'is-invalid' : '') ?>"
              id="email" name="email"
              value="<?= (isset($dados['formulario'])) ? $dados['formulario']['email'] : $dados['conta']->getEmail() ?>" required>
              <?php if (isset($dados['validacao']) && !$dados['validacao']['email_validado']) { ?>
                <div class="alert alert-danger mt-1">
                  O formato de e-mail está incorreto.
                </div>
              <?php } else if (isset($dados['validacao']) && !$dados['validacao']['email_novo']) { ?>
                <div class="alert alert-danger mt-1">
                  Esse e-mail já está sendo utilizado.
                </div>
              <?php } ?>
            </div>
        </div>
        <div class="row mb-3">
          <div class="col-6 col-md-4 col-lg-3">
            <label for="nome_usuario" class="form-label">Nome de usuário</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['usuario_validado'] ? 'is-invalid' : '') ?>"
            id="nome_usuario" name="nome_usuario"
            value="<?= 
            (isset($dados['formulario'])) ? $dados['formulario']['nome_usuario'] : $dados['conta']->getNomeUsuario() ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['usuario_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O nome de usuário deve conter pelo menos 6 dígitos alfanuméricos (A a Z, 0 a 9).
              </div>
            <?php } else if (isset($dados['validacao']) && !$dados['validacao']['usuario_novo']) { ?>
              <div class="alert alert-danger mt-1">
                Esse nome de usuário já está sendo utilizado.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-4">
          <?php if ($dados['conta']->getTipo() == 'cliente') {?>
            <div class="col-6 col-md-4 col-lg-3">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="text" class="form-control border border-primary
              <?= (isset($dados['validacao']) && !$dados['validacao']['telefone_validado'] ? 'is-invalid' : '') ?>"
              id="telefone" name="telefone"
              value="<?= (isset($dados['formulario'])) ? $dados['formulario']['telefone'] : $dados['conta']->getTelefone() ?>" required>
              <?php if (isset($dados['validacao']) && !$dados['validacao']['telefone_validado']) { ?>
                <div class="alert alert-danger mt-1">
                  O telefone deve conter pelo menos 8 dígitos, todos numéricos (0 a 9).
                </div>
              <?php } ?>
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